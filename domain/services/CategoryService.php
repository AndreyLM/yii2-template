<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 4:14 PM
 */

namespace domain\services;


use domain\entities\Category;
use domain\repositories\MySqlCategoryRepository;

class CategoryService implements ICategoryService
{
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new MySqlCategoryRepository();
    }

    public function save(Category $category): integer
    {
        $this->categoryRepository->save($category);
    }
}