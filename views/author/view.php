<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

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

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Title') ?></th>
                <th><?= Yii::t('app', 'Year of publication') ?></th>
                <th><?= Yii::t('app', 'ISBN') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($model->getBooks()->count() == 0) : ?>
                <tr>
                    <td colspan="3"><?= Yii::t('app', 'Author has no books.') ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ($model->books as $book) : ?>
                    <tr>
                        <td><a class="link-dark link-underline-opacity-0 link-underline-opacity-100-hover" href="<?= Url::to(['/book/view', 'id' => $book->id]) ?>"><?= $book->title ?></a></td>
                        <td><?= $book->year_of_publication ?></td>
                        <td><?= $book->isbn ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>