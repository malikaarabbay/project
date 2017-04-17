<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use vova07\fileapi\behaviors\UploadBehavior;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $photo;
    public $city_id;
    public $password;
    public $passwordRepeat;
    public $firstname;
    public $lastname;
    public $birthday;
    public $sex;
    public $activated;
    public $agreed;
    public $vk_id;
    public $fb_id;
    public $mr_id;
    public $ok_id;
    public $li_id;
    public $gg_id;
    public $tw_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['photo', 'string', 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'on' => 'default'],
            ['email', 'email', 'on' => 'default'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['phone', 'string'],
            [['city_id', 'sex'], 'integer'],
            ['birthday', 'safe'],

            [['password','email', 'firstname', 'lastname', 'passwordRepeat'], 'required'],

            [['password'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],

            ['password', 'string', 'min' => 6],
            [['phone', 'city_id'], 'safe'],
            [['vk_id', 'fb_id', 'mr_id', 'gg_id', 'ok_id', 'li_id', 'tw_id'], 'safe'],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->sex = $this->sex;
            $user->birthday = Yii::$app->formatter->asTimestamp($this->birthday);
            if($this->photo) {
                $user->photo = $this->photo;
            }
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя:',
            'lastname' => 'Фамилия:',
            'email' => 'Email:',
            'phone' => 'Телефон:',
            'city_id' => 'Город:',
            'sex' => 'Пол:',
            'password' => 'Пароль:',
            'passwordRepeat' => 'Повтор пароля:',
        ];
    }

    public function scenarios()
    {
        return [
            'social' => ['firstname', 'lastname', 'email', 'sex', 'photo', 'birthday', 'activated'],
            'default' => ['firstname', 'lastname', 'email', 'sex', 'photo', 'birthday', 'activated', 'phone', 'password', 'city_id', 'about', 'agreed', 'passwordRepeat'],
        ];
    }

    public function signupSocial()
    {
        if ($this->validate()) {
            $user = new User();
            $user->scenario = 'social';
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->birthday = $this->birthday;
            $user->photo = $this->photo;
            $user->sex = $this->sex;
            $user->vk_id = $this->vk_id;
            $user->fb_id = $this->fb_id;
            $user->mr_id = $this->mr_id;
            $user->ok_id = $this->ok_id;
            $user->li_id = $this->li_id;
            $user->gg_id = $this->gg_id;
            $user->tw_id = $this->tw_id;
            $user->activated = 1;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $user->save();
            return $user;
        }

        return null;
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
