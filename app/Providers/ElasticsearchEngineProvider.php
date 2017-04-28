<?php

namespace App\Providers;

use App\Engines\ElasticsearchEngine;
use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class ElasticsearchEngineProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        resolve(EngineManager::class)->extend('elasticsearch', function(){
            return new ElasticsearchEngine(ElasticBuilder::create()
                ->setHosts(config('scout.elasticsearch.config.hosts'))
                ->build(),
                config('scout.elasticsearch.index')
            );
        });
    }
}