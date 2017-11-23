<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model domain\entities\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-default">
        <div class="box-header">
            Main information
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'name',
                    'description',
                    'status',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            Meta
        </div>
        <div class="box-border">
            <?= DetailView::widget([
                'model' => $model->getMeta(),
                'attributes' => [
                    'title',
                    'description',
                    'keywords',
                ],
            ]) ?>
        </div>
    </div>


</div>
