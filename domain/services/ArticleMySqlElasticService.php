<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/28/17
 * Time: 11:47 AM
 */

namespace domain\services;


use domain\entities\Article;
use yii\web\NotFoundHttpException;

class ArticleMySqlElasticService implements IArticleService
{

    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article)
    {
        // TODO: Implement save() method.
    }

    /* @return \domain\entities\Article[] */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function getOne($id): Article
    {
        // TODO: Implement getOne() method.
    }

    /* @param $id int
     * @return bool
     * */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /* @param $categoryService ICategoryService
     * @return array
     * */
    public function getCategoryList(ICategoryService $categoryService)
    {
        // TODO: Implement getCategoryList() method.
    }

    /* @param $categoryId int
     * @return array | null
     */
    public function getByCategoryId($categoryId)
    {
        // TODO: Implement getByCategoryId() method.
    }
}