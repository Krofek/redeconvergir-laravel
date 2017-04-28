<?php

namespace App\Engines;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Elasticsearch\Client as Elastic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

class ElasticsearchEngine extends Engine
{
    /**
     * Index where the models will be saved.
     *
     * @var string
     */
    protected $index;
    protected $elastic;

    /**
     * @var Builder
     */
    protected $builder = null;

    /**
     * Create a new engine instance.
     *
     * @param  \Elasticsearch\Client $elastic
     * @param $index
     */
    public function __construct(Elastic $elastic, $index)
    {
        $this->elastic = $elastic;
        $this->index = $index;
    }

    /**
     * Update the given model in the index.
     *
     * @param  Collection  $models
     * @return void
     */
    public function update($models)
    {
        $params['body'] = [];

        $models->each(function($model) use (&$params)
        {
            $params['body'][] = [
                'update' => [
                    '_id' => $model->getKey(),
                    '_index' => $this->index,
                    '_type' => $model->searchableAs(),
                ]
            ];
            $params['body'][] = [
                'doc' => $model->toSearchableArray(),
                'doc_as_upsert' => true
            ];
        });

        $this->elastic->bulk($params);
    }

    /**
     * Remove the given model from the index.
     *
     * @param  Collection  $models
     * @return void
     */
    public function delete($models)
    {
        $params['body'] = [];

        $models->each(function($model) use (&$params)
        {
            $params['body'][] = [
                'delete' => [
                    '_id' => $model->getKey(),
                    '_index' => $this->index,
                    '_type' => $model->searchableAs(),
                ]
            ];
        });

        $this->elastic->bulk($params);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->performSearch($builder, [
            'numericFilters' => $this->filters($builder),
            'size' => $builder->limit,
        ]);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @param  int  $perPage
     * @param  int  $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        $result = $this->performSearch($builder, [
            'numericFilters' => $this->filters($builder),
            'from' => (($page * $perPage) - $perPage),
            'size' => $perPage,
        ]);

        $result['nbPages'] = $result['hits']['total']/$perPage;

        return $result;
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @param  array  $options
     * @return mixed
     */
    protected function performSearch(Builder $builder, array $options = [])
    {
        $params = [
            'index' => $this->index,
            'type' => $builder->model->searchableAs(),
            'body' => [
                'query' => $builder->query,
            ]
        ];

        if (!empty($builder->orders)) {
            $params['body']['sort'] = [];
            foreach ($builder->orders as $order) {
                $params['body']['sort'][$order['column']] = $order['direction'];
            }
        }

        if (isset($options['from'])) {
            $params['body']['from'] = $options['from'];
        }

        if (isset($options['size'])) {
            $params['body']['size'] = $options['size'];
        }

        if (isset($options['numericFilters']) && count($options['numericFilters'])) {
            $params['body']['query']['bool']['must'] = array_merge($params['body']['query']['bool']['must'],
                $options['numericFilters']);
        }

        return $this->elastic->search($params);
    }

    /**
     * Get the results of the given query mapped onto models.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(Builder $builder)
    {
        $this->builder = $builder;

        return Collection::make($this->map(
            $this->search($builder), $builder->model
        ));
    }

    /**
     * Get the filter array for the query.
     *
     * @param  Builder  $builder
     * @return array
     */
    protected function filters(Builder $builder)
    {
        return collect($builder->wheres)->map(function ($value, $key) {
            return ['match_phrase' => [$key => $value]];
        })->values()->all();
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        return collect($results['hits'])->pluck('_id')->values();
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Collection
     */
    public function map($results, $model)
    {
        if (count($results['hits']['total']) === 0) {
            return Collection::make();
        }

        // Apply custom callback function.
        if ($this->builder->callback) {
            $queryBuilder = call_user_func($this->builder->callback, $model);
        } else {
            $queryBuilder = $model;
        }

        $keys = collect($results['hits']['hits'])
            ->pluck('_id')->values()->all();

        // Fetch models that correspond to hits' ids.
        $models = $queryBuilder->whereIn(
            $model->getKeyName(), $keys
        )->get()->keyBy($model->getKeyName());

        // Finally, map fetched models to elastic hits, and because we've possibly applied a callback (which may filter
        // results), some of elements within $results['hits]['hits'] are not present within $models.
        // We map models to elastic hits because we want sorting functionality, and results have already been sorted
        // within $results['hits']['hits'].
        return collect($results['hits']['hits'])->map(function ($hit) use ($model, $models) {
            return $models->contains($hit['_id']) ? $models[$hit['_id']] : null;
        })->reject(function ($initiative) {
            return empty($initiative);
        });
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {
        return $results['hits']['total'];
    }

    /**
     * Returns string with escaped elastic reserved characters.
     * These are + - = && || > < ! ( ) { } [ ] ^ " ~ * ? : \ /
     *
     * @param $string
     * @return mixed
     */
    public static function escape($string) {
        $regex = "/[\\+\\-\\=\\&\\|\\!\\(\\)\\{\\}\\[\\]\\^\\\"\\~\\*\\<\\>\\?\\:\\\\\\/]/";
        return preg_replace($regex, addslashes('\\$0'), $string);
    }

    /**
     * Prepares (i.e. formats and escapes) search query
     * @param string $query
     * @return string
     */
    public static function prepareSearchQuery($query) {
        $query = trim(mb_strtolower(ElasticsearchEngine::escape($query)));
        if($query === "") {
            $query = "*";
        }
        return $query;
    }
}