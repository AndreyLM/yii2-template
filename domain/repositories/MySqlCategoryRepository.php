<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:04 PM
 */

namespace domain\repositories;


use domain\exceptions\DomainException;
use domain\mysql\Category as ARCategory;
use domain\entities\Category;
use yii\web\NotFoundHttpException;

class MySqlCategoryRepository implements ICategoryRepository
{

    public function save(Category $category)
    {
        $category->id ?
            $arCategory = $this->find($category->id) :
            $arCategory = new ARCategory();
        $parent = $this->find($category->parentId);



        $this->mapToActiveRecord($category, $arCategory);

        if(!$arCategory->appendTo($parent)->save())
            throw new \RuntimeException('Cannot save category. Please check all fields');

        return $arCategory->id;
    }

    public function get(int $id):Category
    {
        $arCategory = $this->find($id);

        $category = new Category();
        $this->mapToEntity($arCategory, $category);

        return $category;
    }


    /* @return \domain\entities\Category[] */
    public function getAll(): array
    {
        $categories = [];
        $arCategories = ARCategory::find()->orderBy('lft')->all();

        foreach ($arCategories as $arCategory) {
            $category = new Category();
            $this->mapToEntity($arCategory, $category);
            $categories[] = $category;
        }

        return $categories;
    }

    /* @param $id int
     * @return bool
     * */
    public function delete($id)
    {
        $arCategory = $this->find($id);
        if(!$arCategory->delete())
            throw new \RuntimeException('Removing error');

        return true;
    }

    private function find($id)
    {
        if(!$arCategory = ARCategory::findOne($id)) {
            throw new NotFoundHttpException('Category is not found');
        }

        return $arCategory;
    }


    private function mapToEntity(ARCategory $arCategory, Category $category)
    {
        $category->id = $arCategory->id;
        $category->title = $arCategory->title;
        $category->setMeta($arCategory->meta);
        $category->description = $arCategory->description;
        $category->name = $arCategory->name;
        $category->status = $arCategory->status;
        $category->lvl = $arCategory->depth;
    }

    private function mapToActiveRecord(Category $category, ARCategory $arCategory)
    {
        $arCategory->title = $category->title;
        $arCategory->meta = $category->getMeta();
        $arCategory->description = $category->description;
        $arCategory->name = $category->name;
        $arCategory->status = $category->status;
    }
}