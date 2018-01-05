<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 8:24 AM
 */

namespace domain\services;


use domain\entities\Article;
use domain\entities\searches\ActiveRecordArticleSearch;
use domain\entities\searches\BaseArticleSearch;
use domain\formaters\ArrayListCategoryFormatter;
use domain\formaters\IArticleFormatter;
use domain\repositories\IArticleRepository;
use domain\repositories\MySqlArticleRepository;
use DomainException;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

class ArticleService implements IArticleService
{
    private $articleRepository;

    public function __construct(IArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article)
    {
        if($this->validate($article))
            return $this->articleRepository->save($article);

        return false;
    }

    /* @return \domain\entities\Article[]*/
    public function getAll(): array
    {
        return $this->articleRepository->getAll();
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
        return $this->articleRepository->get($id);
    }

    /* @param $id int
     * @throws DomainException
     * @return bool
     * */
    public function delete($id)
    {
        return $this->articleRepository->delete($id);
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
        return $this->articleRepository->getByCategoryId($categoryId);
    }

    /* @throws \domain\exceptions\DomainException
     * @return bool
     */
    public function synchronize()
    {
        // TODO: Implement synchronize() method.
    }

    /* @return BaseArticleSearch */
    public function getSearchModel()
    {
        return new ActiveRecordArticleSearch();
    }
}