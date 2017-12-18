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
use domain\formaters\IMenuRenderer;
use domain\forms\UploadForm;
use domain\repositories\IMenuRepository;
use domain\repositories\MySqlMenuRepository;
use yii\web\NotFoundHttpException;

class MenuService implements IMenuService
{
    /* @var IMenuRepository */
    private $menuRepository;
    public function __construct(IMenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
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
        return $this->menuRepository->getMenu($id);
    }

    /* @param $menuId int
     * @throws NotFoundHttpException
     * @return Item[]
     * */
    public function getFullMenuItems($menuId)
    {
        $fullMenu = [];

        $fullMenu['menu'] = $this->getMenu($menuId);
        $fullMenu['items'] = $this->getMenuItems($menuId);

        return $fullMenu;
    }

    public function getMenuItems($menuId)
    {
        return $this->menuRepository->getMenuItems($menuId);
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Item
     */
    public function getItem($id)
    {
        return $this->menuRepository->getItem($id);
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
        $menu->type = Menu::TYPE_MENU;

        if(!$menu->validate())
            return false;

        return $this->menuRepository->saveMenu($menu);
    }

    /* @param $item Item
     * @throws DomainException
     * @return int
     */
    public function saveMenuItem(Item $item)
    {
        return $this->menuRepository->saveMenuItem($item);
    }

    /* @param $formatter IMenuFormatter
     * @param $menuId int
     * @throws DomainException
     * @return mixed
     * */
    public function format(IMenuFormatter $formatter, $menuId)
    {
        return $formatter->format(
            $this->getMenu($menuId),
            $this->getMenuItems($menuId));
    }

    /* @param $id int
     * @param $uploadForm UploadForm
     * @throws \RuntimeException
     * @return bool
     */
    public function addItemImage($id, $uploadForm)
    {
        $this->menuRepository->addItemImage($id, $uploadForm);
    }

    /* @param $menuRenderer IMenuRenderer
     * @return mixed
     */
    public function render(IMenuRenderer $menuRenderer, $categoryId)
    {
        return $menuRenderer->render(
            \Yii::$container->get('domain\services\ICategoryService'),
            \Yii::$container->get('domain\services\IArticleService'),
            $categoryId
        );
    }
}