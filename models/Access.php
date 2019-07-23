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
            'note_id' => 'Заметки',
            'user_id' => 'Пользователи',
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

    public static function saveAccess( Calendar $note, int $userId) {
        $access = new self();
        $access->setAttributes([
            'note_id' => $note->id,
            'user_id' => $userId,
        ]);

        $access->save();
        }
}
