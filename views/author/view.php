<?php

use app\models\Book;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Author $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'createdBy.username',
                'label' => Yii::t('app', 'Created by')
            ],
            [
                'attribute' => 'updatedBy.username',
                'label' => Yii::t('app', 'Updated by')
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h3><?= Yii::t('app', 'Books') ?></h3>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getBooks(),
        ]),
        'columns' => [
            'title',
            'year_of_publication',
            'isbn',
            [
                'label' => Yii::t('app', 'Available'),
                'class' => 'kartik\grid\BooleanColumn',
                'value' => function ($model) {
                    return $model->isAvailable();
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute(["/book/{$action}", 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>