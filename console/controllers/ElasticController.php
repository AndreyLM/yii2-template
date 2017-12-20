<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/19/17
 * Time: 10:18 AM
 */

namespace console\controllers;


use Elasticsearch\ClientBuilder;
use yii\base\Module;
use yii\console\Controller;

class ElasticController extends Controller
{
    private $client;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->configureElastic();
    }

    private function configureElastic()
    {
        $this->client = ClientBuilder::create();
        $this->client->setHosts(['elasticsearch:9200']);
        $this->client->build();
    }

    public function actionMappings()
    {
        $params = [
            'index' => 'knowledge',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1,
                ],

                'mappings' => [
                    'articles' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        '_all' => [
                            'enabled' => false
                        ],
                        'properties' => [
                            'title' => [
                                'type' => 'text',
                            ],
                            'age' => [
                                'type' => 'integer'
                            ]
                        ]
                    ]
                ]

            ]
        ];

    }
}