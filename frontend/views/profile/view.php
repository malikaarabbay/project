<?php
use yii\helpers\Url;
use frontend\widgets\ContestWidget;
use frontend\widgets\NewTestWidget;
use frontend\widgets\BlogWidget;
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;
use vova07\fileapi\Widget as FileAPI;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = 'Профиль пользователя';

/* @var $this yii\web\View */
?>
<!-- LEFT -->
<div class="col-xs-12 col-md-8 col-sm-12 wrap-content-left">

<!-- CONTENT -->
<div class="row">
<div class="col-xs-12 wrap-content-blog">
<div class="title">Профиль пользователя</div>
<div class="row">

<div class="col-xs-12 main-profile-item">

    <div class="row">
        <div class="col-xs-8 ">
            <span class="cabinet-title"><?= $user->lastname.' '.$user->firstname . ' ' . $user->secondname ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?php
            echo EasyThumbnailImage::thumbnailImg(
                $user->imagePath,
                196,
                216,
                EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                [
                    'alt' => $user->firstname,
                    'class' => 'profile-view',
                ]
            );
            ?>

        </div>

        <div class="col-xs-12 col-sm-8 col-md-7">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="title">ФИО</div>
                    <div class="form-group">
                        <p class="profile-text">
                            <?= $user->firstname . ' ' . $user->lastname ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

</div>
</div>
<!-- CONTENT -->
</div>
<!-- LEFT -->
