<?php
namespace domain\mysql\behaviors;

use domain\entities\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'meta_json';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event)
    {
        $model = $event->sender;
        $metaStd = Json::decode($model->getAttribute($this->jsonAttribute));

        $meta = new Meta();
        $meta->title = ArrayHelper::getValue($metaStd, 'title');
        $meta->description = ArrayHelper::getValue($metaStd, 'description');
        $meta->keywords = ArrayHelper::getValue($metaStd, 'keywords');

        $model->{$this->attribute} = $meta;
    }

    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute('meta_json', Json::encode([
            'title' => $model->{$this->attribute}->title,
            'description' => $model->{$this->attribute}->description,
            'keywords' => $model->{$this->attribute}->keywords,
        ]));
    }
}