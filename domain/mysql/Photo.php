<?php

namespace domain\mysql;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $file
 * @property int $sort
 *
 * @property Gallery $gallery
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id', 'file', 'sort'], 'required'],
            [['gallery_id', 'sort'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_id' => 'Gallery ID',
            'file' => 'File',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\queries\PhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \domain\mysql\queries\PhotoQuery(get_called_class());
    }
}
