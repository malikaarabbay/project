<?php
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Url;
?>

<div class="col-xs-12 col-sm-4 col-md-4">
    <div class="article-img">
        <?=
        EasyThumbnailImage::thumbnailImg(
            $model->imagePath,
            400,
            250,
            EasyThumbnailImage::THUMBNAIL_OUTBOUND,
            [
                'alt' => $model->title,
                'class' => 'img-responsive'
            ]
        );
        ?>
    </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-8">
    <div class="article-item">
        <div class="article-title"><?= $model->title ?></div>
        <div class="article-date"><?= Yii::$app->formatter->asDate($model->created, 'dd.MM.yyyy') ?></div>
        <div class="article-announce"><?= $model->anounce ?></div>
        <div class="article-author">Автор: <?= $model->user->firstname.' '.$model->user->lastname ?></div>
        <div class="article-btn"><a href="<?= Url::toRoute(['/article/view', 'slug' => $model->slug]) ?>" class="btn btn-success">Подробнее</a></div>
    </div>
</div>



