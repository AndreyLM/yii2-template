<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model domain\entities\Category */
/* @var $meta domain\entities\Meta */
/* @var $list */

$this->title = 'Update Category: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'meta' => $meta,
        'list' => $list
    ]) ?>

</div>
