<?php 

use yii\helpers\Html;
use app\models\forms\UserForm;

?>

<div class="user_profile_data">
    <p class="user_view">Пользователь : <?= $model->username ?></p>
    <?= Html::img($model->getImage(), ['width' => 300], ['alt' => 'img']) ?> 

    <p class="string_data"><span class="index_span">Имя  :</span> <?= Html::encode($model->first_name) ?></p>
    <p class="string_data"><span class="index_span">Фамилия :</span> <?= Html::encode($model->last_name) ?></p>
    <p class="string_data"><span class="index_span">Email :</span> <?= Html::encode($model->email) ?></p>

</div> 
