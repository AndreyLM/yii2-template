<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/20/17
 * Time: 10:23 AM
 */

namespace domain\entities;


use yii\base\Model;

class Setting extends Model
{
    public $id;
    public $title;
    public $value;
    public $options;

    public function rules()
    {
        return [
            [['id', 'title', 'value'], 'required'],
            [['title', 'value'], 'string'],
            [['id'], 'integer'],
        ];
    }
}