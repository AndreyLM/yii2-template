<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/19/17
 * Time: 10:18 AM
 */

namespace console\controllers;

use domain\mysql\Article;
use Elasticsearch\ClientBuilder;
use yii\base\Module;
use yii\console\Controller;

class ElasticController extends Controller
{
    const ARTICLE_INDEX = 'knowledge_article';
    const ARTICLE_TYPE = 'article';
    private $client;


    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->configureElastic();
    }

    private function actionMappingArticles()
    {


        $params = $this->articleIndexParams();

        $response = $this->client->indices()->create($params);

        $this->stdout(var_dump($response));
    }

    public function actionReindexArticles()
    {
        $this->stdout('1. Removing index...'.PHP_EOL);
        $this->deleteArticleIndex();
        $this->stdout('2. Creating mapping'.PHP_EOL);
        $this->actionMappingArticles();
        $this->stdout('3. Putting data'.PHP_EOL);
        $params = [];

        /* @var $article \domain\mysql\Article */
        foreach (Article::find()->with('category')->with('user')->each(100) as $key => $article) {


            $params['body'][] = [
                'index' => [
                    '_index' => self::ARTICLE_INDEX,
                    '_type' => self::ARTICLE_TYPE,
                    '_id' => $article->id,
                ]
            ];

            $params['body'][] = [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'text_intro' => $article->text_intro,
                'text_body' => $article->text_body,
                'text_body_markdown' => $article->text_body_markdown,
                'category_id' => $article->category_id,
                'category_title' => $article->category->id,
                'user_name' => $article->user->username,
                'author' => $article->author,
                'status' => (bool)$article->status,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
                'publishing_at' => $article->publishing_at,
            ];

            if ($key !=0 && $key % 100 == 0) {
                $responses = $this->client->bulk($params);

                $params = ['body' => []];

                $this->stdout(var_dump($responses));

                unset($responses);
            }
        }

        if(!empty($params['body'])) {
            $responses = $this->client->bulk($params);
            $this->stdout(var_dump($responses));
        }
    }

    public function deleteArticleIndex()
    {


        $response = $this->client->indices()->delete([
            'index' => self::ARTICLE_INDEX
        ]);

        $this->stdout(var_dump($response));
    }

    private function articleIndexParams()
    {
        $params = [
            'index' => self::ARTICLE_INDEX,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    self::ARTICLE_TYPE => [
                        '_all' => [
                            'enabled' => false
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer'
                            ],
                            'title' => [
                                'type' => 'text'
                            ],
                            'slug' => [
                                'type' => 'text'
                            ],
                            'text_intro' => [
                                'type' => 'text'
                            ],
                            'text_body' => [
                                'type' => 'text'
                            ],
                            'text_body_markdown' => [
                                'type' => 'text'
                            ],
                            'category_id' => [
                                'type' => 'integer',
                            ],
                            'category_title' => [
                                'type' => 'keyword'
                            ],
                            'user_name' => [
                                'type' => 'keyword',
                                'index' => false
                            ],
                            'author' => [
                                'type' => 'text'
                            ],
                            'status' => [
                                'type' => 'boolean'
                            ],
                            'created_at' => [
                                'type' => 'date'
                            ],
                            'updated_at' => [
                                'type' => 'date'
                            ],
                            'publishing_at' => [
                                'type' => 'date'
                            ],
                        ]
                    ]
                ]
            ]
        ];


        return $params;
    }

    private function configureElastic()
    {
        $client = ClientBuilder::create();
        $client->setHosts(['elasticsearch:9200']);
        $this->client = $client->build();
    }

}