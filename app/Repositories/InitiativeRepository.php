<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:11 PM
 */

namespace App\Repositories;


use App\Interfaces\InitiativeRepositoryInterface;
use App\Models\Initiative;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class InitiativeRepository implements InitiativeRepositoryInterface
{
    /**
     * @var Initiative
     */
    protected $initiative;

    public function __construct(Initiative $initiative)
    {
        $this->initiative = $initiative;
    }

    public function getAll()
    {
        return $this->initiative->all();
    }

    public function find($id)
    {
        return $this->initiative->find($id);
    }

    /**
     * filter by:
     * - category
     * - tags
     * - audience
     * - area type
     * - audience size
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|Initiative[]
     */
    public function filterFromRequest(Request $request)
    {
        $results = $this->initiative->with('category', 'otherCategory', 'tags', 'audience', 'location');

        if ($request->has('category_id')) {
            $this->filterOneToOne($results, 'category_id', $request);
        }

        if ($request->has('tags')) {
            $this->filterManyToOne($results, 'tags', $request);
        }

        if ($request->has('audience')) {
            $this->filterManyToOne($results, 'audience', $request);
        }

        if ($request->has('location_type')) {
            $this->filterOneToOne($results, 'location_type', $request);
        }

        if ($request->has('audience_size')) {
            $this->filterOneToOne($results, 'audience_size', $request);
        }

        return $results->get();
    }

    /**
     * @param Eloquent|Model|Builder $results
     * @param $type
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    private function filterManyToOne(&$results, $type, Request $request)
    {
        $names = [];
        foreach ($request->input($type) as $row) $names[] = config('rede_initiative.' . $type)[$row];
        return $results->whereHas($type, function ($query) use ($names) {
            /** @var Eloquent $query */
            $query->whereIn('name', $names);
        });
    }

    /**
     * @param Eloquent|Model|Builder $results
     * @param $type
     * @param Request $request
     * @return $this
     */
    private function filterOneToOne(&$results, $type, Request $request) {
        return $results->whereIn($type, $request->input($type));
    }
}