<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model domain\entities\Article */
/* @var $meta domain\entities\Meta */
/* @var $categories array */

$this->title = 'Update Article: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'meta' => $meta,
        'categories' => $categories
    ]) ?>

</div>
