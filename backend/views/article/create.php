<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model domain\entities\Article */
/* @var $meta domain\entities\Meta */
/* @var $categories array */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'meta' => $meta,
        'categories' => $categories,
    ]) ?>

</div>
