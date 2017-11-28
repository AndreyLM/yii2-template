<?php

/* @var $this yii\web\View */
/* @var $model domain\entities\Category */
/* @var $meta domain\entities\Meta */
/* @var $list */

$this->title = 'Update Category: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <?= $this->render('_form.twig', [
        'model' => $model,
        'meta' => $meta,
        'list' => $list
    ]) ?>

</div>
