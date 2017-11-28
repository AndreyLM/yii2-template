<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/28/17
 * Time: 11:28 AM
 */

namespace domain\services;


use domain\entities\menu\Item;
use domain\entities\menu\Menu;
use domain\exceptions\DomainException;
use domain\formaters\IMenuFormatter;
use domain\repositories\IMenuRepository;
use domain\repositories\MySqlMenuRepository;
use yii\web\NotFoundHttpException;

class MenuService implements IMenuService
{
    /* @var IMenuRepository */
    private $menuRepository;
    public function __construct()
    {
        $this->menuRepository = new MySqlMenuRepository();
    }

    /* @return Menu[] */
    public function getMenuList()
    {
        return $this->menuRepository->getMenuList();
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Menu
     */
    public function getMenu($id)
    {
        $this->menuRepository->getMenu($id);
    }

    /* @param $menuId int
     * @throws NotFoundHttpException
     * @return Item[]
     * */
    public function getMenuItems($menuId)
    {
        $this->getMenuItems($menuId);
    }

    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */
    public function delete($id)
    {
        $this->menuRepository->delete($id);
    }

    /* @param $menu Menu
     * @throws DomainException
     * @return int
     */
    public function saveMenu(Menu $menu)
    {
        // TODO: Implement saveMenu() method.
    }

    /* @param $item Item
     * @throws DomainException
     * @return int
     */
    public function saveMenuItem(Item $item)
    {
        // TODO: Implement saveMenuItem() method.
    }

    /* @param $formatter IMenuFormatter
     * @param $menuId int
     * @throws DomainException
     * @return mixed
     * */
    public function format(IMenuFormatter $formatter, $menuId)
    {
        // TODO: Implement format() method.
    }
}