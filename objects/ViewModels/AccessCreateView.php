<?php 

namespace app\objects\ViewModels;

use yii\helpers\BaseArrayHelper;
use app\models\Calendar;
use app\models\User;

class AccessCreateView {
    /**
     * @return array    
     */

    public function getNoteOptions()
    {
        $models = Calendar::find()->all();

        return BaseArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @return array
     */
    public function getUserOptions() {
        $models = User::find()->all();

        return BaseArrayHelper::map($models, 'id', 'username');
    }
}