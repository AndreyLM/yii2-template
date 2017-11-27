<?php

use domain\entities\Article;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model domain\entities\Article */
/* @var $categoryList array */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            [
                'attribute' => 'categoryId',
                'value' => function(Article $article) use ($categoryList)
                {
                    return $categoryList[$article->categoryId];
                }
            ],
//            'categoryId',
            'userId',
            'author',
            'status',
            'favorite',
            'createdAt',
            'updatedAt',
            'publishingAt',
        ],
    ]) ?>

</div>
