<?php 

namespace app\models\forms;

use app\models\Calendar;
use app\models\User;
use app\models\Access;

class CalendarForm extends Calendar {

   // public $image;
    public $users = [];

    public function rules() {

        $rules = parent::rules();
        $rules[] = ['users', 'checkUser'];

        return $rules;
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->users = Access::find()->select(['user_id'])->andWhere(['note_id' => $this->id])->column();
    } 

    public function checkUser() {
        foreach ($this->users as $userId) {
           if (User::find()->andWhere(['id' => $userId])->count('id') == 0) {
               $this->addError('users', sprintf('Пользователя не существует'));
           }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Access::deleteAll(['note_id' => $this->id]);
        if ($this->users != null) {
            foreach($this->users as $userId) {
                Access::saveAccess($this, $userId);
            }
        }    
    }
}