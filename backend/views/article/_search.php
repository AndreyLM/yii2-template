<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model domain\mysql\searches\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'text_intro') ?>

    <?php // echo $form->field($model, 'text_body') ?>

    <?php // echo $form->field($model, 'text_body_markdown') ?>

    <?php // echo $form->field($model, 'meta_json') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'favorite') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'publishing_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
