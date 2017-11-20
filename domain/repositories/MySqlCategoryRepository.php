<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:04 PM
 */

namespace domain\repositories;


use domain\mysql\Category as ARCategory;
use domain\entities\Category;
use yii\web\NotFoundHttpException;

class MySqlCategoryRepository implements ICategoryRepository
{

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function save(Category $category):integer
    {
        $arCategory = new ARCategory();

        if($category->id)
        {
            $arCategory->id = $category->id;
        }


        $this->mapToActiveRecord($category, $arCategory);
        $arCategory->save();
        return $arCategory->id;
    }

    public function get(integer $id):Category
    {
        if(!$arCategory = ARCategory::findOne($id)) {
            throw new NotFoundHttpException('Category is not found');
        }

        $category = new Category();
        $this->mapToEntity($arCategory, $category);

        return $category;
    }

    private function mapToEntity(ARCategory $arCategory, Category $category)
    {
        $category->id = $arCategory->id;
        $category->title = $arCategory->title;
        $category->meta = $arCategory->meta;
        $category->description = $arCategory->description;
        $category->name = $arCategory->name;
        $category->status = $arCategory->status;
    }

    private function mapToActiveRecord(Category $category, ARCategory $arCategory)
    {
        $arCategory->title = $category->title;
        $arCategory->meta = $category->meta;
        $arCategory->description = $category->description;
        $arCategory->name = $category->name;
        $arCategory->status = $category->status;
    }
}