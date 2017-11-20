<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:10 PM
 */

namespace domain\services;


use domain\entities\Category;

interface ICategoryService
{
    public function save(Category $category):integer;
}