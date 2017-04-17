<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Achievement;
use common\models\AchievementType;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="col-xs-12 main-blog-item cabinet-stars">
    <span class="cabinet-title">Мои достижения</span>
    <div class="col-xs-3 col-sm-2 col-md-2 cabinet-star">
        <ul>
            <li>
                <img src="/img/cabinet-star-active.png " height="64" width="64" alt="">
                <p>Регистрация</p>
                <br/>
            </li>
        </ul>
    </div>

    <?php foreach($achievements as $achievement) {?>

        <?php foreach($userAchievements as $userAchievement) { ?>

            <?php if($achievement->id == $userAchievement->achievement_id) {?>

                <?php $achievement->status = 1; ?>

            <?php } ?>

        <?php } ?>

    <?php }?>

    <?php foreach($achievements as $achievement) { ?>



        <div class="col-xs-3 col-sm-2 col-md-2 cabinet-star">
            <ul>
                <li>

                    <?php if($achievement->status == 1) {?>

                        <img src="/img/cabinet-star-active.png " height="64" width="64" alt="">

                    <?php } else {?>

                        <img src="/img/cabinet-star.png " height="64" width="64" alt="">

                    <?php }?>

                    <p><?= $achievement->title?></p>
                </li>
            </ul>
        </div>



    <?php } ?>

    <div class="clearfix"></div>
</div>



















