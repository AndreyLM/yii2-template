<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 9:48 AM
 */

namespace domain\formaters\renderer;


class Article implements ICompositeItem
{
    public $title;

    public function addItem(ICompositeItem $item)
    {
        return false;
    }

    public function render()
    {
        return 'Article: '. $this->title;
    }
}