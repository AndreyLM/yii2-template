<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:11 PM
 */

namespace domain\services;


use domain\entities\Article;
use domain\entities\searches\BaseArticleSearch;
use domain\exceptions\DomainException;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

interface IArticleService
{
    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article);

    /* @return \domain\entities\Article[]*/
    public function getAll():array;

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function getOne($id):Article;

     /* @param $id int
     * @return bool
     * */
    public function delete($id);

    /* @param $categoryService ICategoryService
     * @return array
     * */
    public function getCategoryList(ICategoryService $categoryService);

    /* @param $categoryId int
     * @return array | null*/
    public function getByCategoryId($categoryId);

    /* @throws DomainException
     * @return bool
    */
    public function synchronize();

    /* @return BaseArticleSearch */
    public function getSearchModel();
}