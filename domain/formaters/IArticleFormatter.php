<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 11:01 AM
 */

namespace domain\formaters;


interface IArticleFormatter
{
    /* @param  $articles \domain\entities\Article[]
     *  @return mixed
     */
    public function format(array $articles);
}