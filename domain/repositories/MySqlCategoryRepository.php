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
        $arCategory = $this->mapToActiveRecord($category);

        if($category->parentId !== $arCategory->parent->id && $category->id !== 1)
        {
            $parent = $this->find($category->parentId);
            try {
                $arCategory->appendTo($parent);
            } catch (\Exception $exception) {
                throw new DomainException('Wrong parent category');
            }
        }

        if(!$arCategory->save())
            throw new \RuntimeException('Cannot save category. Please check all fields');

        return $arCategory->id;
    }

    public function get(int $id):Category
    {
        $arCategory = $this->find($id);

        return $this->mapToEntity($arCategory);
    }


    /* @return \domain\entities\Category[] */
    public function getAll(): array
    {
        $categories = [];
        $arCategories = ARCategory::find()->orderBy('lft')->all();

        foreach ($arCategories as $arCategory) {
            $categories[] = $this->mapToEntity($arCategory);
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


    private function mapToEntity(ARCategory $arCategory)
    {
        $category = new Category();

        $category->id = $arCategory->id;
        $category->title = $arCategory->title;
        $category->setMeta($arCategory->meta);
        $category->description = $arCategory->description;
        $category->name = $arCategory->name;
        $category->status = $arCategory->status;
        $category->lvl = $arCategory->depth;
        $category->parentId = $arCategory->parent->id;

        return $category;
    }

    private function mapToActiveRecord(Category $category)
    {
        $category->id ?
            $arCategory = $this->find($category->id) :
            $arCategory = new ARCategory();

        $arCategory->title = $category->title;
        $arCategory->meta = $category->getMeta();
        $arCategory->description = $category->description;
        $arCategory->name = $category->name;
        $arCategory->status = $category->status;


        return $arCategory;
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return array Category[]
     */
    public function getOneWithChildren($id)
    {
        
        $categories = [];
        $arCategory = $this->find($id);
        $arCategories = ARCategory::find()->where(['>=', 'lft', $arCategory->lft])
            ->andWhere(['<=', 'rgt', $arCategory->rgt])->all();
        foreach ($arCategories as $category)
        {
            $categories[] = $this->mapToEntity($category);
        }

        return $categories;
    }
}