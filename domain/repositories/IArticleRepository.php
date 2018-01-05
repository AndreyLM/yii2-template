<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:05 PM
 */

namespace domain\repositories;


use domain\entities\Article;
use domain\exceptions\DomainException;
use yii\web\NotFoundHttpException;

interface IArticleRepository
{
    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */
    public function delete($id);

    /* @param $article Article
     * @param $categoryTitle string
     * @throws DomainException
     *  @return int
     */
    public function save(Article $article, $categoryTitle = '');

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function get(int $id):Article;

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll():array;

    /* @param $categoryId int
     * @return array | null*/
    public function getByCategoryId($categoryId);

    /* Rewrite all your data with new one */
    public function import(IArticleRepository $articleRepository);
}