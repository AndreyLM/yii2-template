<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:05 PM
 */

namespace domain\repositories;


use domain\entities\Category;
use domain\exceptions\DomainException;
use yii\web\NotFoundHttpException;

interface ICategoryRepository
{
    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */
    public function delete($id);

    /* @param $category Category
     * @throws DomainException
     *  @return int
     */
    public function save(Category $category);

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Category
     */
    public function get(int $id):Category;

    /* @param $id int
     * @throws NotFoundHttpException
     * @return array Category[]
     */
    public function getOneWithChildren($id);

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll():array;
}