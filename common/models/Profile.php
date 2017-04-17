<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use vova07\fileapi\behaviors\UploadBehavior;


/**
 * ContactForm is the model behind the contact form.
 */
class Profile extends Model
{
    public $lastname;
    public $firstname;
    public $secondname;
    public $phone;
    public $sex;
    public $photo;
    public $secondPhone;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname', 'secondname','phone','secondPhone','photo'], 'string' ],

            ['sex', 'integer'],
            // email has to be a valid email address
            ['email', 'email'],

        ];
    }


    public function changeProfile()
    {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->phone = $this->phone;
            $user->sex = $this->sex;
            $user->email = $this->email;
            $user->photo = $this->photo;

            $user = $user->save();
            return $user;
        }
        return null;
    }

    public function attributeLabels()
    {
        return [
            'photo' => Yii::t('app', 'Change photo'),
            'lastname' => Yii::t('profile', 'Lastname'),
            'firstname' => Yii::t('profile', 'Firstname'),
            'secondname' => Yii::t('profile', 'Secondname'),
        ];
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    'photo' => [
                        'path' => '@frontend/web/images',
                        'tempPath' => '@frontend/web/images',
                        'url' => Yii::getAlias('@frontendWebroot/images')
                    ],
                ]
            ],
        ];

    }





}
