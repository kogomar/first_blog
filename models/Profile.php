<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $isAdmin
 * @property string $photo
 * @property string $fullname
 *
 * @property Comment[] $comments
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['fullname'], 'required'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
            [['fullname'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
           // 'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
            'fullname' => 'Fullname',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Comment::className(), ['user_id' => 'id']);

    }

    public function updateProfile()
    {
        $profile = ($profile=Profile::findOne(Yii::$app->user->id)) ? $profile: new Profile();
        $profile->id=Yii::$app->user->id;
        $profile->name=$this->name;
        $profile->fullname=$this->fullname;
        return $profile->save() ? true:false;
    }
}
