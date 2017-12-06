<?php

namespace domain\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /* @var \yii\web\UploadedFile[] */
    public $files;

    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['image']]
        ];
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }

        return false;
    }
}