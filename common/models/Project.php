<?php

namespace common\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $active
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creator
 * @property User $updater
 * @property User[] $users
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    const RELATION_PROJECT_USERS = 'projectUsers';
    const RELATION_USERS = 'users';
    const RELATION_TASKS = 'tasks';
    const RELATION_CREATOR = 'creator';
    const RELATION_UPDATER = 'updater';

    const STATUS_NONACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const STATUSES = [
        self::STATUS_NONACTIVE,
        self::STATUS_ACTIVE
    ];

    const STATUSES_LABELS = [
        self::STATUS_NONACTIVE => 'неактивен',
        self::STATUS_ACTIVE => 'активен'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            ['active', 'in', 'range' => self::STATUSES],
            [['creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ['class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id'
            ],
             'saveRelations' => [
                'class'     => SaveRelationsBehavior::class,
                'relations' => [
                    self::RELATION_PROJECT_USERS,
                ]
        ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id']);
    }
}
