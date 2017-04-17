<?php
/* @var $this yii\web\View */
$this->title = 'Project';
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
?>
<div class="row">
    <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => "{items}\n<div class='clearfix'></div>{pager}",
]) ?>  
</div>



