<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/30/17
 * Time: 9:36 AM
 */

namespace domain\formaters;


use domain\entities\menu\Item;
use domain\entities\menu\Menu;

class ArrayListMenuItemsFormatter implements IMenuFormatter
{

    /*  @param  $menu Menu
     * @param $items Item[]
     * @return mixed
     * */
    public function format(Menu $menu, array $items)
    {
        $result = [];
        $result[$menu->id] = 'Menu: '.$menu->title;
        foreach ($items as $item) {
            $result[$item->id] = str_repeat('-', $item->depth).$item->title;
        }

        return $result;
    }
}