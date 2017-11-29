<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:08 PM
 */

namespace domain\repositories;


use domain\entities\menu\Item;
use domain\entities\menu\Menu;
use domain\mysql\Menu as ARMenu;
use domain\exceptions\DomainException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class MySqlMenuRepository implements IMenuRepository
{

    /* @return Menu[] */
    public function getMenuList()
    {
        $arMenus = ARMenu::find()->where(['depth' => 1])->all();
        $menus = [];
        foreach ($arMenus as $arMenu) {
            $menus [] = $this->mapMenuToEntity($arMenu);
        }

        return $menus;
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Menu
     */
    public function getMenu($id)
    {
        return $this->mapMenuToEntity($this->find($id));
    }

    /* @param $menuId int
     * @throws NotFoundHttpException
     * @return Item[]
     * */
    public function getMenuItems($menuId)
    {
        $menu = $this->find($menuId);
        $arItems = ARMenu::find()->where(['>', 'lft', $menu->lft])
            ->andWhere(['<', 'rgt', $menu->rgt])->all();
        $items=[];

        foreach ($arItems as $arItem)
        {
            $items[] = $this->mapItemToEntity($arItem);
        }

        return $items;
    }

    /* @param $id int
     * @throws \RuntimeException
     * @throws DomainException
     * @return bool
     * */
    public function delete($id)
    {
        if($id == 1)
            throw new DomainException('Cannot delete root menu container');
        $model = $this->find($id);

        if($model->depth === 1)
        {
            if(!$model->deleteWithChildren())
                throw new \RuntimeException('Problem with deleting menu');

            return true;
        }

        if(!$model->delete())
            throw new \RuntimeException('Problem with deleting menu-item');

        return true;
    }

    /* @param $menu Menu
     * @throws DomainException
     * @return int
     */
    public function saveMenu(Menu $menu)
    {
        $arMenu = $this->mapMenuToActiveRecord($menu);

        $root = $this->find(1);
        if (!$arMenu->appendTo($root)->save())
            throw new DomainException('Cannot save. Please check your input values');

        return true;
    }

    /* @param $item Item
     * @throws DomainException
     * @return int
     */
    public function saveMenuItem(Item $item)
    {
        $arItem = $this->mapItemToActiveRecord($item);

        return $this->save($arItem);
    }

    private function mapMenuToEntity(ARMenu $arMenu):Menu
    {
        $menu = new Menu();
        $menu->id= $arMenu->id;
        $menu->title= $arMenu->title;
        $menu->name= $arMenu->name;
        $menu->description= $arMenu->description;
        $menu->status= $arMenu->status;
        $menu->type= Menu::TYPE_MENU;

        return $menu;
    }

    private function mapItemToEntity(ARMenu $arItem):Item
    {
        $item = new Item();

        $item->id= $arItem->id;
        $item->title= $arItem->title;
        $item->name= $arItem->name;
        $item->description= $arItem->description;
        $item->status= $arItem->status;
        $item->type= $arItem->type;
        $item->img = $arItem->img;
        $item->relation = $arItem->relation;
        $item->depth = $arItem->depth;
        $item->menuId = $arItem->parent->id;

        return $item;
    }

    private function mapMenuToActiveRecord(Menu $menu) : ARMenu
    {
        $menu->id ? $arMenu = $this->find($menu->id) : $arMenu = new ARMenu();

        $arMenu->title= $menu->title;
        $arMenu->name= $menu->name;
        $arMenu->description= $menu->description;
        $arMenu->status= $menu->status;
        $arMenu->type= Menu::TYPE_MENU;

        return $arMenu;
    }

    private function mapItemToActiveRecord(Item $item) : ARMenu
    {
        $item->id ? $arItem = $this->find($item->id) : $arItem =  new ARMenu();

        $arItem->title = $item->title;
        $arItem->name = $item->name;
        $arItem->description = $item->description;
        $arItem->status = $item->status;
        $arItem->type = $item->type;
        $arItem->img = $item->img;
        $arItem->relation = $item->relation;

        return $arItem;
    }

    private function find($id)
    {
        if(!$arMenu = ARMenu::findOne(['id' => $id]))
            throw new NotFoundHttpException('Cannot find menu or item');

        return $arMenu;
    }

    private function save(ActiveRecord $model)
    {
        if(!$model->save())
            throw new DomainException('Cannot save. Please check your input values');

        return $model->id;
    }
}