<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/8/17
 * Time: 10:41 AM
 */

namespace domain\formaters;


use domain\entities\menu\Item;
use domain\entities\menu\Menu;
use yii\helpers\Url;

class NavMenuFormatter implements IMenuFormatter
{
    /* @var Item[] */
    private $items = [];
    private $result =[];
    private $parentKeys = [];

    /*  @param  $menu Menu
     * @param $items Item[]
     * @return mixed
     * */
    public function format(Menu $menu, array $items)
    {
        foreach ($items as $item)
        {
            $this->items[$item->id] = $item;
            $this->parentKeys[$item->parentId] = $item->parentId;
        }
    }

    public function makeTree(Item $item)
    {
        $res = [];
        $res['label'] = $item->title;
        $res['url'] = $this->setUrl($item);

        if (!$this->hasChildren($item))
            return $res;


        /* @var $child Item*/
        foreach ($this->items as $child) {
            if ($child->parentId === $item->id) {
                $res['items'] = $this->makeTree($child);
            }
        }

        return $res;
    }

    private function hasChildren($item)
    {
        return array_key_exists($item->id, $this->parentKeys);
    }

    private function setUrl(Item $item)
    {
        if($item->type === Item::TYPE_ITEM_ARTICLE) {
            return Url::to(['/blog/article', 'id' => $item->id]);
        }

        if($item->type === Item::TYPE_ITEM_CONTAINER) {
            return '#';
        }

        if($item->type === Item::TYPE_ITEM_TABLE_OF_CONTENT) {
            return Url::to(['/blog/table-of-content', 'id' => $item->id]);
        }

        if($item->type === Item::TYPE_ITEM_TABLE_OF_CONTENT) {
            return Url::to(['/blog/table-of-content', 'id' => $item->id]);
        }

        if($item->type === Item::TYPE_ITEM_BLOG_ARTICLES) {
            return Url::to(['/blog/list', 'id' => $item->id]);
        }

        if($item->type === Item::TYPE_FAVORITE_ARTICLES) {
            return Url::to(['/blog/favorites', 'id' => $item->id]);
        }

        return '#';
    }
}