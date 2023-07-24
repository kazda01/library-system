<?php

/** @var yii\web\View $this */

use kazda01\search\SearchInput;

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= Yii::t('app', 'Welcome to the library system!') ?></h1>

        <p class="lead"><?= Yii::t('app', 'Your one-stop library system for managing a vast collection of books and keeping track of borrowers.') ?></p>

        <?= SearchInput::widget([
            'search_id' => 'user-search',
            'placeholder' => Yii::t('app', 'Search users..'),
            'wrapperClass' => 'col-11 col-lg-8 col-xl-7 mx-auto my-4',
        ]); ?>

    </div>

</div>