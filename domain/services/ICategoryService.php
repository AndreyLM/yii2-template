<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:10 PM
 */

namespace domain\services;


use domain\entities\Category;
use domain\formaters\ICategoryFormatter;

interface ICategoryService
{
    public function save(Category $category);

    /* @return \domain\entities\Category[]*/
    public function getAll():array;

    public function getOne($id):Category;

    /* @param $categories \domain\entities\Category[]
     * @param $categoryFormatter
     * @return mixed
     * */
    public function format(ICategoryFormatter $categoryFormatter, array $categories);

    /* @param $id int
     * @return bool
     * */
    public function delete($id);
}