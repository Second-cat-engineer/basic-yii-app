<?php

namespace app\models\user;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * Class User.
 *
 * @property integer $id
 * @property string $login
 * @property string $email
 * @property string $password_hash
 * @property string $access_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package app\models\user
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName(): string
    {
        return 'user';
    }

    public function attributes(): array
    {
        return [
            'id',
            'login',
            'email',
            'password_hash',
            'access_token',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function rules()
    {
        return [
            [
                ['login', 'email', 'password_hash', 'status',],
                'required'
            ],
            [
                ['login', 'password_hash',],
                'string'
            ],
            [
                ['status'],
                'integer'
            ],
            [['login', 'email'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => 'app\models\user\User',
                'message' => Yii::t('rbac-admin', 'This email address has already been taken.')
            ],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }









    use UserTokenTrait;



    const SCENARIO_LOAD_BY_USER = 'loadByUser';
    const SCENARIO_LOAD_BY_ADMIN = 'loadByAdmin';




    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_LOAD_BY_USER => [
                'username',
                'email',
            ],
            self::SCENARIO_LOAD_BY_ADMIN => [
                'username',
                'email',
                'status',
            ],
        ]);
    }






    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'passwordHash' => Yii::t('user', 'Password Hash'),
            'passwordResetToken' => Yii::t('user', 'Password Reset Token'),
            'email' => Yii::t('user', 'Email'),
            'authKey' => Yii::t('user', 'Auth Key'),
            'tokens' => Yii::t('user', 'Tokens'),
            'status' => Yii::t('user', 'Status'),
            'createdAt' => Yii::t('user', 'Created At'),
            'updatedAt' => Yii::t('user', 'Updated At'),
        ];
    }




    public static function findIdentity($id)
    {
        return static::find()->byId($id)->active()->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->byToken($token)->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not Implemented.');
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }






    /**
     * Finds user by login
     *
     * @param string $login
     * @return ActiveRecord|null
     */
    public static function findByLogin(string $login): ActiveRecord|null
    {
        return static::find()->byLogin($login)->active()->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()->byPasswordResetToken($token)->active()->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }



    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }
}