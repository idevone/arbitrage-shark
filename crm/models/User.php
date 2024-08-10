<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $authKey
 * @property string $accessToken
 * @property string $role
 * @property string $telegram_accounts
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    private static array $users = [
        '100' => [
            'id' => '100',
            'username' => 'dev',
            'password' => 'dev',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
            'role' => 'admin',
            'status' => 'active'
        ]
    ];

    public function rules(): array
    {
        return [
            [['username', 'password_hash', 'authKey', 'accessToken'], 'required'],
            [['username', 'password_hash', 'accessToken', 'role', 'telegram_accounts', 'status', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['accessToken'], 'unique'],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username): ?User
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }
}
