<?php

namespace App\Console\Commands;

use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class ElasticsearchMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:mappings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Elasticsearch indices and mappings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => config('scout.elasticsearch.index'),
        ];
        if ($client->indices()->exists($params)){
            $client->indices()->delete($params);
        }
        $params = [
            'index' => config('scout.elasticsearch.index'),
            'body' => [
                'mappings' => [
                    'initiatives' => [
                        'properties' => [
                            'locations' =>[
                                'type' => 'nested',
                                'properties' => [
                                    'position' => [
                                        'type' => 'geo_point'
                                    ]
                                ]
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $response = $client->indices()->create($params);
        $this->comment('Index ' . $params['index'] . ' created.');
    }
}
