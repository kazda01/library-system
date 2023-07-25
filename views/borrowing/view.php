<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Borrowing $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Borrowings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="borrowing-view">

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
            [
                'attribute' => 'customerNameCard',
                'label' => Yii::t('app', 'Customer') . ' (' . Yii::t('app', 'Card ID') . ')',
                'value' => function ($model) {
                    return "{$model->customer->name} {$model->customer->surname} ({$model->customer->card_id})";
                }
            ],
            'book.title',
            'borrow_date:date',
            'return_date:date',
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

</div>