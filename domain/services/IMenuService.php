<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:10 PM
 */

namespace domain\services;

use domain\entities\menu\Item;
use domain\entities\menu\Menu;
use domain\formaters\IMenuFormatter;
use domain\exceptions\DomainException;
use yii\web\NotFoundHttpException;


interface IMenuService
{
    /* @return Menu[] */
    public function getMenuList();

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Menu */
    public function getMenu($id);

    /* @param $menuId int
     * @throws NotFoundHttpException
     * @return Item[]
     * */
    public function getFullMenuItems($menuId);

    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Item */
    public function getItem($id);

    public function delete($id);

    /* @param $menu Menu
     * @throws DomainException
     *  @return int
     */
    public function saveMenu(Menu $menu);

    /* @param $item Item
     * @throws DomainException
     *  @return int
     */
    public function saveMenuItem(Item $item);

    /* @param $formatter IMenuFormatter
     * @param $menuId int
     * @throws DomainException
     * @return mixed
     * */
    public function format(IMenuFormatter $formatter, $menuId);


}