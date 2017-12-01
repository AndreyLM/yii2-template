<?php

namespace domain\entities\gallery;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/1/17
 * Time: 11:15 AM
 */

class Gallery extends Model
{
    public $id;
    public $title;
    public $name;

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 192],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
        ];
    }
}