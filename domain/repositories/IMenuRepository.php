<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:08 PM
 */

namespace domain\repositories;


interface IMenuRepository
{
    public function add();
    public function delete();
    public function update();
    public function get();
}