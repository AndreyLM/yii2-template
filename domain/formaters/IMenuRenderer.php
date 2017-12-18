<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 9:40 AM
 */

namespace domain\formaters;


use domain\services\IArticleService;
use domain\services\ICategoryService;
use DomainException;

interface IMenuRenderer
{
    /* @param $categoryService ICategoryService
     * @param $articleService IArticleService
     * @param $categoryId int
     * @throws DomainException
     * @return mixed*/
    public function render(ICategoryService $categoryService, IArticleService $articleService, $categoryId);
}