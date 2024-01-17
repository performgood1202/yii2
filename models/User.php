<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    // public $id;
    // public $name;
    // public $email;
    // public $password;
    // public $authKey;
    // public $accessToken;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password', ], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['password'],'string','min'=>6],
            [['name', 'email', 'password'], 'string', 'max' => 100],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
     /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
       return static::findOne(['email' => $email]);
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
