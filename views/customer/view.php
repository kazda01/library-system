<?php

use app\models\Borrowing;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Customer $model */

$this->title = "{$model->name} {$model->surname}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Borrow'), ['/borrowing/create', 'fk_customer' => $model->id], ['class' => 'btn btn-success']) ?>
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
            'card_id',
            'name',
            'surname',
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
    ]) ?><h3><?= Yii::t('app', 'Borrowings') ?></h3>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getBorrowings(),
            'sort' => [
                'defaultOrder' => [
                    'borrow_date' => SORT_DESC,
                ]
            ],
        ]),
        'columns' => [
            'book.title',
            'book.isbn',
            'borrow_date:date',
            'return_date:date',
            [
                'label' => Yii::t('app', 'Active borrow'),
                'class' => 'kartik\grid\BooleanColumn',
                'value' => function ($model) {
                    return $model->isActive();
                }
                // you may configure additional properties here
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Borrowing $model, $key, $index, $column) {
                    return Url::toRoute(["/borrowing/{$action}", 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
