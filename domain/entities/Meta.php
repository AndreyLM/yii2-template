<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 3:37 PM
 */

namespace domain\entities;


use yii\base\Model;

class Meta extends Model
{
    public $title;
    public $description;
    public $keywords;

    public function rules()
    {
        return [
            [['title', 'description', 'keywords'], 'default', 'value' => ''],
            [['title','description','keywords'], 'string']
        ];
    }
}