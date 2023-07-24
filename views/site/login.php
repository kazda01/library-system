<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'Login');
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <small><?= Yii::t('app', 'Please log in to access all features of the site.') ?></small>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <div style="color:#999" class="my-3">
        <?= Yii::t('app', 'If you forgot your password you can <a class="text-dark" href="{link}">reset it</a>.', ['link' => 'request-password-reset']) ?>
    </div>

    <div class="form-group">
        <div class="col-lg-11">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-lg btn-dark', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>