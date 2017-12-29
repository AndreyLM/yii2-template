<?php

namespace domain\widgets;

use domain\services\IMenuService;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/22/17
 * Time: 11:10 AM
 */

class MenuImageWidget extends Widget
{
    /* @var IMenuService*/
    private $menuService;
    public $menuId;

    public function init()
    {
        $this->menuService = \Yii::$container->get('domain\services\IMenuService');
        parent::init();
    }

    public function run()
    {
        if(!$this->menuId) {
            echo '<p>Please choose menu id for widget</p>';
        }

        /* @var $this->menuService IMenuService*/
        $menu = $this->menuService->getFullMenuItems($this->menuId);
        $items=[];

        /* @var $item \domain\entities\menu\Item*/
        foreach ($menu['items'] as $item)
        {
            echo $item->title.'   '.$item->depth;
//            if($item->depth === )
        }
    }
}