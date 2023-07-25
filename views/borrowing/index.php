<?php

use app\models\Borrowing;
use app\models\Customer;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\BorrowingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Borrowings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrowing-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Borrowing'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php
    $customers = [];
    foreach (Customer::find()->asArray()->all() as $customer) {
        $customers[$customer['id']] = "{$customer['name']} {$customer['surname']}";
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'fk_customer',
                'label' => Yii::t('app', 'Customer'),
                'value' => function ($model) {
                    return "{$model->customer->name} {$model->customer->surname}";
                },
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'hideSearch' => true,
                    'options' => ['prompt' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'data' => $customers
                ],
                'headerOptions' => ['style' => 'min-width:200px'],
            ],
            [
                'attribute' => 'bookTitle',
                'label' => Yii::t('app', 'Book'),
                'value' => function ($model) {
                    return "{$model->book->title}";
                }
            ],
            [
                'attribute' => 'borrow_date',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->borrow_date);
                },
                'filterType' => \kartik\grid\GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'options' => ['autocomplete' => 'off'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ],
            ],
            [
                'attribute' => 'return_date',
                'value' => function ($model) {
                    return $model->return_date === null ? '-' : Yii::$app->formatter->asDate($model->return_date);
                },
                'filterType' => \kartik\grid\GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'options' => ['autocomplete' => 'off'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ],
            ],
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
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>