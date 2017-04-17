<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    <ul class="nav nav-pills">
        <li><a href="<?= Url::toRoute(['/profile/index']) ?>">Личный кабинет</a></li>
        <li><a href="<?= Url::toRoute(['/user/index']) ?>">Мои посты</a></li>
    </ul>
</div>
<div class="col-xs-12">
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => function($data) {
                    return Html::img($data->image,['width'=>100]);
                },
            ],
            'title',
            'anounce:ntext',
//            'description:ntext',
            //'photo',
            // 'status',
            // 'created',
            // 'updated',
//            'is_published',
            'created:datetime',
            [
                'attribute' => 'is_published',
                'class' => 'yii\grid\DataColumn',
                'label' => 'Опубликован',
                'value' => function ($data) {
                    return ($data->is_published) ? Yii::$app->params['published'][$data->is_published] : '';
                },
                'filter' => Yii::$app->params['published']
            ],
            // 'meta_keywords:ntext',
            // 'meta_description:ntext',
            // 'slug',
            [
                'header' => 'Действия',
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>

</div>
</div>

