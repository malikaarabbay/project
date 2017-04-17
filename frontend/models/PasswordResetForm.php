<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Password reset request form
 */
class PasswordResetForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
//                'filter' => ['status' => Profile::STATUS_ACTIVE],
                'message' => 'Пользователь с данной электронной почтой не зарегистрирован'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }


    public function newPassword()
    {
        $user = User::findOne(['email' => $this->email]);

        $tempPass = $this->stringGenerate(10);

//        $user->password_reset_token = sha1($tempPass);
        $generatePasswordHash = Yii::$app->security->generatePasswordHash($tempPass);
        $user->password_hash = $generatePasswordHash;
        $user->generateAuthKey();
        if($user->save() && $this->sendPassToEmail($tempPass, $user, $this->email)){
//            var_dump($generatePasswordHash);
            return true;
        } else {
            return false;
        }

    }

    public function sendPassToEmail($newPass, $user, $email)
    {
        return Yii::$app->mailer->compose('resetPassword', [
            'user' => $user->firstname,
            'newPass' => $newPass,
        ])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'project.kz robot'])
            ->setSubject('Восстановление пароля')
            ->send();
    }


    // генератор случайных символов
    function stringGenerate($length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 0; $i <= $length; $i++) {
            $result .= $characters[mt_rand (0, strlen ($characters) - 1)];
        }
        return $result;
    }



}
