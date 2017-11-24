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

    /* @param $category Article
     * @throws DomainException
     *  @return int
     */
    public function save(Article $category);

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function get(int $id):Article;

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll():array;
}