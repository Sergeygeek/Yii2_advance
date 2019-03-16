<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password
 * @property string $avatar
 *
 * @property Task[] $activedTasks
 * @property Task[] $createdTasks
 * @property Task[] $updatedTasks
 * @property Task[] $createdProjects
 * @property Task[] $updatedProjects
 * @mixin \mohorev\file\UploadImageBehavior::class
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $password;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ACTIVED_TASKS = 'activedTasks';
    const CREATED_TASKS = 'createdTasks';
    const UPDATED_TASKS = 'updatedTasks';
    const CREATED_PROJECTS = 'createdProjects';
    const UPDATED_PROJECTS = 'updatedProjects';
    const AVATAR_PREVIEW = 'preview';
    const AVATAR_ICO = 'ico';
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    const STATUSES = [
      self::STATUS_DELETED, self::STATUS_ACTIVE
    ];

    const STATUS_LABELS = [
        self::STATUS_DELETED => 'Удаленный', self::STATUS_ACTIVE => 'Активный'
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_UPDATE],
//            'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@frontend/web/upload/user/{id}',
                'url' => Yii::$app->params['front.scheme'] .
                    Yii::$app->params['front.domain'] . Yii::getAlias('@web/upload/user/{id}'),
                'thumbs' => [
                    self::AVATAR_ICO => ['width' => 30, 'quality' => 90],
                    self::AVATAR_PREVIEW => ['width' => 200, 'height' => 200],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUSES],
            [['username', 'email', 'auth_key', 'password'], 'safe'],
            ['avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => [self::SCENARIO_UPDATE]]
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->generateAuthKey();
        }

        if ($this->password) {
            $this->generateAuthKey();
        }


        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if($password){
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }

        $this->password = $password;

    }

    /**
     * @inheritdoc
     */

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getActivedTasks()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    public function getCreatedTasks()
    {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }

    public function getUpdatedTasks()
    {
        return $this->hasMany(Task::className(), ['updater_id' => 'id']);
    }

    public function getCreatedProjects()
    {
        return $this->hasMany(Project::className(), ['creator_id' => 'id']);
    }

    public function getUpdatedProjects()
    {
        return $this->hasMany(Project::className(), ['updater_id' => 'id']);
    }

    public function getAvatar()
    {
        return $this->getThumbUploadUrl('avatar',self::AVATAR_ICO);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }
}
