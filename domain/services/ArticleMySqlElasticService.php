<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/28/17
 * Time: 11:47 AM
 */

namespace domain\services;


use domain\entities\Article;
use domain\entities\searches\ActiveRecordArticleSearch;
use domain\entities\searches\BaseArticleSearch;
use domain\entities\searches\ElasticArticleSearch;
use domain\exceptions\DomainException;
use domain\formaters\ArrayListCategoryFormatter;
use domain\formaters\IArticleFormatter;
use domain\repositories\ElasticArticleRepository;
use domain\repositories\IArticleRepository;
use domain\repositories\MySqlArticleRepository;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class ArticleMySqlElasticService implements IArticleService
{

    /* @var IArticleRepository*/
    private $elasticRepository;
    /* @var IArticleRepository*/
    private $mySqlRepository;

    public function __construct()
    {
        $this->mySqlRepository = new MySqlArticleRepository();
        $this->elasticRepository = new ElasticArticleRepository();
    }

    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article)
    {
        if($this->validate($article))
            return $this->mySqlRepository->save($article);

        return false;
    }

    /* @return \domain\entities\Article[]*/
    public function getAll(): array
    {
        return $this->elasticRepository->getAll();
    }

    /* @param $articles \domain\entities\Article[]
     * @param $articleFormatter
     * @return mixed
     * */
    public function format(IArticleFormatter $articleFormatter, array $articles)
    {
        return $articleFormatter->format($articles);
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function getOne($id): Article
    {
        return $this->mySqlRepository->get($id);
    }

    /* @param $id int
     * @throws DomainException
     * @return bool
     * */
    public function delete($id)
    {
        return $this->mySqlRepository->delete($id);
    }

    public function validate(Article $article)
    {
        if(!$article->validate() || !$article->getMeta()->validate()) {
            return false;
        }

        return true;
    }

    /* @param $categoryService ICategoryService
     * @return array
     * */
    public function getCategoryList(ICategoryService $categoryService)
    {
        $categories = $categoryService->getAll();
        return $categoryService->format(new ArrayListCategoryFormatter(), $categories);
    }

    /* @param $categoryId int
     * @return array | null
     */
    public function getByCategoryId($categoryId)
    {
        return $this->mySqlRepository->getByCategoryId($categoryId);
    }

    public function synchronize() {
        $this->elasticRepository->import($this->mySqlRepository);
    }

    /* @return BaseArticleSearch */
    public function getSearchModel()
    {
        return new ActiveRecordArticleSearch();
    }
}