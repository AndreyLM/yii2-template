<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 9:47 AM
 */

namespace domain\formaters\renderer;

interface ICompositeItem
{
    public function addItem(ICompositeItem $item);
    public function render();
}