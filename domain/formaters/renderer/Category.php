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
        $output = '<ul><li><h4>'. $this->title.'</h4>';
        /* @var $item ICompositeItem*/
        foreach ($this->items as $item)
        {
            $output .= $item->render();
        }
        $output.='</li></ul>';

        return $output;
    }
}