<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model domain\entities\Article */
/* @var $form yii\widgets\ActiveForm */
/* @var $meta domain\entities\Meta */
/* @var $categories array */

?>

<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-header">
            Common attributes
        </div>
        <div class="box-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'categoryId')->dropDownList($categories) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <?= $form->field($model, 'textIntro')->textarea() ?>

            <?= $form->field($model, 'textBody')->textarea() ?>

            <?= $form->field($model, 'textBodyMarkdown')->textarea() ?>

            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <?= $form->field($model, 'status')->checkbox() ?>
                    <?= $form->field($model, 'favorite')->checkbox() ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'publishingAt')->textInput() ?>
                </div>
            </div>





        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            Meta attributes
        </div>
        <div class="box-body">
            <?= $form->field($meta, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($meta, 'description')->textInput(['maxlength' => true]) ?>

            <?= $form->field($meta, 'keywords')->textarea() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
