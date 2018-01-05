<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/29/17
 * Time: 10:17 AM
 */

namespace domain\repositories;


use common\models\User;
use domain\entities\Article;
use domain\mysql\Article as ARArticle;
use domain\exceptions\DomainException;
use Elasticsearch\ClientBuilder;
use yii\web\NotFoundHttpException;

class ElasticArticleRepository implements IArticleRepository
{
    const ARTICLE_INDEX = 'knowledge_article';
    const ARTICLE_TYPE = 'article';
    const ARTICLE_HOST = 'elasticsearch:9200';
    private $client;

    public function __construct()
    {
        $this->init();
    }

    public function delete($id)
    {
        return $this->client->delete([
            'index' => self::ARTICLE_INDEX,
            'type' => self::ARTICLE_TYPE,
            'id' => $id
        ]);
    }

    /* @param $article Article
     * @param $categoryTitle
     * @throws DomainException
     * @return int
     */
    public function save(Article $article, $categoryTitle = '')
    {
         if(!$this->client->indices()->exists(['index' => self::ARTICLE_INDEX])) {
             $this->createMappings();
         }

        $params = [
            'index' => self::ARTICLE_INDEX,
            'type' => self::ARTICLE_TYPE,
            'id' => $article->id,
            'body' => [
                'doc' => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'text_intro' => $article->textIntro,
                    'text_body' => $article->textBody,
                    'text_body_markdown' => $article->textBodyMarkdown,
                    'category_id' => $article->categoryId,
                    'category_title' => $categoryTitle,
                    'user_name' => $article->userId ? User::findOne(['id' => $article->userId]) :
                                        \Yii::$app->user->identity->username,
                    'author' => $article->author,
                    'status' => (bool)$article->status,
                    'created_at' => $article->createdAt,
                    'updated_at' => $article->updatedAt,
                    'publishing_at' => $article->publishingAt,
                ]
            ]
        ];

        return $this->client->update($params);
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function get(int $id): Article
    {
        $params = [
            'index' => self::ARTICLE_INDEX,
            'type' => self::ARTICLE_TYPE,
            'id' => $id
        ];

        $result = $this->client->get($params);

        return $this->mapToArticle($result['_source']);

    }

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll(): array
    {
        $params = [
            'index' => self::ARTICLE_INDEX,
            'type' => self::ARTICLE_TYPE,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        $result = $this->client->search($params);
        $articles = [];

        foreach ($result['hits']['hits'] as $art) {
            $articles[] = $this->mapToArticle($art['_source']);
        }

        return $articles;
    }

    /* @param $categoryId int
     * @return array | null
     */
    public function getByCategoryId($categoryId)
    {
        $params = [
            'index' => self::ARTICLE_INDEX,
            'type' => self::ARTICLE_TYPE,
            'body' => [
                'match' => [
                    'category_id' => $categoryId
                ]
            ]
        ];

        $result = $this->client->search($params);

        $articles = [];

        foreach ($result['hits']['hits'] as $art) {
            $articles[] = $this->mapToArticle($art['_source']);
        }

        return $articles;
    }

    public function import(IArticleRepository $articleRepository)
    {
        $params = [];

        /* @var $article \domain\mysql\Article */
        foreach (ARArticle::find()->with('category')->with('user')->each(100) as $key => $article) {


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
                $this->client->bulk($params);
                $params = ['body' => []];
            }
        }

        if(!empty($params['body'])) {
            $this->client->bulk($params);
        }
    }


    private function init()
    {
        $client = ClientBuilder::create();
        $client->setHosts([self::ARTICLE_HOST]);
        $this->client = $client->build();
    }

    private function createMappings()
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

        return $this->client->indices()->create($params);
    }

    private function mapToArticle(array $arr)
    {
        $article = new Article();

        $article->id = $arr['id'];
        $article->title = $arr['title'];
        $article->slug = $arr['slug'];
        $article->categoryId = $arr['category_id'];
        $article->author = $arr['author'];
        $article->userId = $arr['user_id'];

        $article->textIntro = $arr['text_intro'];
        $article->textBody = $arr['text_body'];
        $article->textBodyMarkdown = $arr['text_body_markdown'];

        $article->status = (int)$arr['status'];
        $article->favorite = (int)$arr['favorite'];

        $article->createdAt = $arr['created_at'];
        $article->updatedAt = $arr['updated_at'];
        $article->publishingAt = $arr['publishing_at'];

        return $article;
    }
}