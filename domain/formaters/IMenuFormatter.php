<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/28/17
 * Time: 11:00 AM
 */

namespace domain\formaters;


use domain\entities\menu\Item;
use domain\entities\menu\Menu;

interface IMenuFormatter
{
    /*  @param  $menu Menu
     * @param $items Item[]
     * @return mixed
     * */
    public function format(Menu $menu, array $items);
}