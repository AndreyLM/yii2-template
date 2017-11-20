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
    public function delete();
    public function save(Category $category):integer;
    public function get(integer $id):Category;
}