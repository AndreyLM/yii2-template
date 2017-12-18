<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/18/17
 * Time: 9:48 AM
 */

namespace domain\formaters\renderer;


class Category implements ICompositeItem
{
    public $id;
    public $title;
    private $items = [];

    public function addItem(ICompositeItem $item)
    {
        $this->items[] = $item;
    }

    public function render()
    {
        $output = 'Category: '. $this->title;
        /* @var $item ICompositeItem*/
        foreach ($this->items as $item)
        {
            $output .= $item->render();
        }

        return $output;
    }
}