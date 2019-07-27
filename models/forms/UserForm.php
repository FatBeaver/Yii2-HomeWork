<?php 

namespace app\models\forms;

use app\models\User;

class UserForm extends User {

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['first_name', 'last_name'], 'required'];
        $rules[] = [['first_name', 'last_name'], 'string'];
        $rules[] = ['email', 'email'];
        $rules[] = ['email', 'required'];

        return $rules;
    }

    public function attributeLabels() {
        $attributeLabels[] = parent::attributeLabels();

        $attributeLabels[] = ['first_name' => 'Имя'];
        $attributeLabels[] = ['last_name' => 'Фамилия'];

        return $attributeLabels;
    }


}