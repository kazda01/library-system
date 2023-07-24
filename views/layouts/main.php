<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Yii::$app->name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Html::tag(
                'i',
                '',
                ['class' => 'fa fa-book-open me-3']
            ) . Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark position-sticky']
        ]);

        $menuItems =  [
        ];

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('app', 'Books'), 'url' => ['/book']];
            $menuItems[] = ['label' => Yii::t('app', 'Authors'), 'url' => ['/author']];
            $menuItems[] =
                '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    Yii::t('app', 'Logout'),
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
            $menuItems[] = '<small class="text-secondary ms-md-auto align-self-center">' .
                Yii::t('app', 'Logged in as') . ' <b>' . Yii::$app->user->identity->username . '</b></small>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav w-100'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0 my-5" role="main">
        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>