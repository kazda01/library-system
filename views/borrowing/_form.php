<?php

use app\models\Book;
use app\models\Customer;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Borrowing $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile(
    '@web/js/invalid-feedback_display.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

?>

<div class="borrowing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $customers = [];
    foreach (Customer::find()->asArray()->all() as $customer) {
        $customers[$customer['id']] = "{$customer['name']} {$customer['surname']}";
    }
    ?>
    <?= $form->field($model, 'fk_customer')->widget(Select2::class, [
        'data' => $customers,
        'options' => [
            'prompt' => ''
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'fk_book')->widget(Select2::class, [
        'data' => ArrayHelper::map(Book::find()->all(), 'id', 'title'),
        'options' => [
            'prompt' => ''
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'borrow_date')->widget(DatePicker::class, [
        'options' => ['class' => 'test'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'return_date')->widget(DatePicker::class, [
        'options' => ['class' => 'test'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>