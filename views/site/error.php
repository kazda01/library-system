<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        <?= Yii::t('app', 'The above error occurred while the Web server was processing your request.') ?>
    </p>
    <p>
        <?= Yii::t('app', 'Please contact us at <a href="mailto:{email_address}">{email_address}</a> if you believe this is a server error. Thank you.', ['email_address' => Yii::$app->params['supportEmail']]) ?>
    </p>

</div>
