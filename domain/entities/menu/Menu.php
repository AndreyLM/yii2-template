<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 11:52 AM
 */

namespace domain\entities\menu;


use yii\base\Model;

class Menu extends Model
{
    const TYPE_MENU = '1';

    public $id;
    public $title;
    public $name;
    public $description;
    public $status;
    public $type;


    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }


}