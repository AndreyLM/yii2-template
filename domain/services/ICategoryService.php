<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:10 PM
 */

namespace domain\services;


use domain\entities\Category;
use domain\exceptions\DomainException;
use domain\formaters\ICategoryFormatter;
use yii\web\NotFoundHttpException;

interface ICategoryService
{
    /* @param $category Category
     * @throws DomainException
     *  @return int
     */
    public function save(Category $category);

    /* @return \domain\entities\Category[]*/
    public function getAll():array;

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Category
     */
    public function getOne($id):Category;

    /* @param $id int
     * @throws NotFoundHttpException
     * @return array Category[]
     */
    public function getOneWithChildren($id);

    /* @param $categories \domain\entities\Category[]
     * @param $categoryFormatter
     * @return mixed
     * */
    public function format(ICategoryFormatter $categoryFormatter, array $categories);

    /* @param $id int
     * @throws DomainException
     * @return bool
     * */
    public function delete($id);
}