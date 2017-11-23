<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model domain\entities\Category */
/* @var $meta domain\entities\Meta */
/* @var $list array */


$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <div class="category-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="box box-default">
            <div class="box-body with-border">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'parentId')->dropDownList($list) ?>

                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->checkbox() ?>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">Meta</div>
            <div class="box-body with-border">
                <?= $form->field($meta, 'title')->textInput() ?>
                <?= $form->field($meta, 'description')->textInput() ?>
                <?= $form->field($meta, 'keywords')->textInput() ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
