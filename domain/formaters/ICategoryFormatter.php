<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/21/17
 * Time: 2:38 PM
 */

namespace domain\formaters;


interface ICategoryFormatter
{

     /* @param  $categories \domain\entities\Category[]
     *  @return mixed
     */
     public function format(array $categories);
}