<?php

$this->title = $model->title;

$this->params['breadcrumbs'][] = $model->title;

$this->registerMetaTag(['name'=> 'keywords', 'content' =>  $model->meta_keywords]);
$this->registerMetaTag(['name'=> 'description', 'content' => $model->meta_description]);

?>

<div class="row">
    <div class="col-xs-12">
        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
</div>
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
<div class="row">
    <div class="col-xs-12">
        <?= \frontend\widgets\Reviews::widget(['model' => $model]) ?>
    </div>
</div>