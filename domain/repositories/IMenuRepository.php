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
use domain\exceptions\DomainException;
use domain\forms\UploadForm;
use yii\web\NotFoundHttpException;

interface IMenuRepository
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
    public function getMenuItems($menuId);

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Item */
    public function getItem($id);

    /* @param $id int
     * @throws \RuntimeException
     * @throws DomainException
     * @return bool
     * */
    public function delete($id);

    /* @param $menu Menu
     * @throws DomainException
     *  @return int
     */
    public function saveMenu(Menu $menu);

    /* @param $item Item
     * @param $uploadForm UploadForm
     * @throws DomainException
     *  @return int
     */
    public function saveMenuItem(Item $item, UploadForm $uploadForm=null);

    /* @param $id int
     * @param $uploadForm UploadForm
     * @throws \RuntimeException
     * @return bool */
    public function addItemImage($id, $uploadForm);
}