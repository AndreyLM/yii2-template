<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 11:04 AM
 */

namespace domain\formaters;


class ArrayListArticleFormatter implements IArticleFormatter
{

    /* @param  $articles \domain\entities\Article[]
     * @return mixed
     */
    public function format(array $articles)
    {
        $list = [];
        foreach ($articles as $article) {
            $list[$article->id] = ['title' => $article->title ];
        }

        return $list;
    }
}