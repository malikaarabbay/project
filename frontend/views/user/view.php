<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <ul class="action-button-list">
        <li class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> '.Yii::t('app', 'Artilces List'), ['index'], ['class' => 'btn btn-default']) ?>
        </li>

        <li class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </li>
        <li class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> '.Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </li>
        <li class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app', 'Add New'), ['create'], ['class' => 'btn btn-success']) ?>
        </li>
    </ul>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="content">
                <h1><?= $model->title?></h1>
                <img src="<?= $model->image ?>" alt="" class="img-responsive"/>
                <div class="content-text">
                    <?= $model->description ?>
                </div>
                <div class="content-detail">
                    <div class="pull-left">Добавлено: <?= Yii::$app->formatter->asDate($model->created, 'dd.MM.yyyy') ?></div>
                    <div class="pull-right">Автор: <?= $model->user->firstname.' '.$model->user->lastname ?></div>
                </div>
            </div>
        </div>
    </div>

</div>
