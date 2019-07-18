<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $author_id
 * @property int $user_id
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note_id', 'user_id'], 'required'],
            [['note_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note_id' => 'Note ID',
            'user_id' => 'User ID',
        ];
    }
    /**
     * @return ActiveQuery
     */

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }   
    /**
     * @return ActiveQuery
     */
    public function getNote() {
        return $this->hasOne(Calendar::class, ['id' => 'note_id']);
    }
}
