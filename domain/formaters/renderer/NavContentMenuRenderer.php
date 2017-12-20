<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 9:43 AM
 */

namespace domain\formaters\renderer;


use domain\formaters\IMenuRenderer;
use domain\services\IArticleService;
use domain\services\ICategoryService;
use DomainException;

class NavContentMenuRenderer implements IMenuRenderer
{
    /* @var IArticleService */
    private $articleService;
    private $categoryService;
    /* @var \domain\entities\Category[] */
    private $categories = [];


    /* @param $categoryService ICategoryService
     * @param $articleService IArticleService
     * @param $categoryId int
     * @throws DomainException
     * @return mixed
     */
    public function render(ICategoryService $categoryService, IArticleService $articleService, $categoryId)
    {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;

        /* @var $category \domain\entities\Category */
        $categories = $this->categoryService->getOneWithChildren($categoryId);

        foreach ($categories as $category)
        {
            $this->categories[$category->id] = $category;
        }

        $root = $this->load($categoryId);
        return $root->render();
    }

    private function load($categoryId)
    {
        $category = new Category();
        $category->title = $this->categories[$categoryId]->title;
        $category->id = $this->categories[$categoryId]->id;

        $this->loadArticles($category);
        $this->loadChildCategories($category);

        return $category;
    }

    private function loadArticles(Category $category)
    {
        /* @var $articleService IArticleService */
        $articles = $this->articleService->getByCategoryId($category->id);

        /* @var $article \domain\entities\Article*/
        foreach ($articles as $article)
        {
            $art = new Article();
            $art->id = $article->id;
            $art->title = $article->title;
            $category->addItem($art);
        }
    }

    private function loadChildCategories(Category $parent)
    {
        foreach ($this->categories as $category)
        {
            if($category->parentId === $parent->id)
            {
                $parent->addItem($this->load($category->id));
            }
        }
    }
}