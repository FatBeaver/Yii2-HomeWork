<?php 

use yii\helpers\Html;
use app\models\forms\UserForm;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?= Html::a($model->username, ['user/view', 'id' => $model->id], ['class' => 'profile_view']) ?></h3>
    </div>   
</div>
