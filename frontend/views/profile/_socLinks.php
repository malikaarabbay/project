<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
?>

<?php $authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['profile/attach']
]); ?>
    <ul class="attach-list">
        <?php foreach ($authAuthChoice->getClients() as $client) { ?>

            <li>
                <?php switch ($client->getName()) {
                    case ('facebook') :
                        echo Html::tag('span', '', ['class' => 'profile-contact-icon fa fa-facebook-official']) . ' Facebook';
                        if($user->fb_id){
                            echo Html::tag('span', '<span class="glyphicon glyphicon-remove"></span>', ['class' => 'js-unbind unbind-link pull-right','data-url' => Url::toRoute(['/profile/unbind', 'data' => 'fb_id'])]);
                            echo Html::tag('span', Yii::t('app', 'Attached'), ['class' => 'pull-right']);
                        } else {
                            echo $authAuthChoice->clientLink($client, Yii::t('app', 'Attach'), ['class' => 'profile-contact-attach-link pull-right']);
                        }
                        break;
                    case ('vkontakte') :
                        echo Html::tag('span', '', ['class' => 'profile-contact-icon fa fa-vk']) . ' Vkontakte';

                        if($user->vk_id){
                            echo Html::tag('span', '<span class="glyphicon glyphicon-remove"></span>', ['class' => 'js-unbind unbind-link pull-right','data-url' => Url::toRoute(['/profile/unbind', 'data' => 'vk_id'])]);
                            echo Html::tag('span', Yii::t('app', 'Attached'), ['class' => 'pull-right']);
                        } else {
                            echo $authAuthChoice->clientLink($client, Yii::t('app', 'Attach'), ['class' => 'profile-contact-attach-link pull-right']);
                        }
                        break;

                    case ('mailru') :
                        echo Html::tag('span', '', ['class' => 'profile-contact-icon fa fa-at']) . ' Mail.ru';

                        if($user->mr_id){
                            echo Html::tag('span', '<span class="glyphicon glyphicon-remove"></span>', ['class' => 'js-unbind unbind-link pull-right','data-url' => Url::toRoute(['/profile/unbind', 'data' => 'mr_id'])]);
                            echo Html::tag('span', Yii::t('app', 'Attached'), ['class' => 'pull-right']);
                        } else {
                            echo $authAuthChoice->clientLink($client, Yii::t('app', 'Attach'), ['class' => 'profile-contact-attach-link pull-right']);
                        }
                        break;

                    case ('odnoklassniki') :
                        echo Html::tag('span', '', ['class' => 'profile-contact-icon fa fa-odnoklassniki']) . ' Odnoklassniki';

                        if($user->ok_id){
                            echo Html::tag('span', '<span class="glyphicon glyphicon-remove"></span>', ['class' => 'js-unbind unbind-link pull-right','data-url' => Url::toRoute(['/profile/unbind', 'data' => 'ok_id'])]);
                            echo Html::tag('span', Yii::t('app', 'Attached'), ['class' => 'pull-right']);
                        } else {
                            echo $authAuthChoice->clientLink($client, Yii::t('app', 'Attach'), ['class' => 'profile-contact-attach-link pull-right']);
                        }
                        break;

                } ?>
            </li>
        <?php } ?>
    </ul>
<?php AuthChoice::end(); ?>