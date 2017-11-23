<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/21/17
 * Time: 2:47 PM
 */

namespace domain\formaters;


class ArrayListCategoryFormatter implements ICategoryFormatter
{

    /* @param  $categories \domain\entities\Category[]
     * @return mixed
     */
    public function format(array $categories)
    {
        $list = [];
        foreach ($categories as $category) {
            $list[$category->id] = str_repeat('-', $category->lvl).$category->title;
        }

        return $list;
    }
}