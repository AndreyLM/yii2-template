<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 3:37 PM
 */

namespace domain\entities;


class Meta
{
    public $title;
    public $description;
    public $keyword;

    public function __construct($title, $description, $keywords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keyword = $keywords;
    }
}