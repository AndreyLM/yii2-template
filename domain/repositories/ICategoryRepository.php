<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:05 PM
 */

namespace domain\repositories;


use domain\entities\Category;

interface ICategoryRepository
{
    public function add();

    /* @param $id int
     * @return bool
     * */
    public function delete($id);
    public function save(Category $category);
    public function get(int $id):Category;

    /* @return \domain\entities\Category[]*/
    public function getAll():array;
}