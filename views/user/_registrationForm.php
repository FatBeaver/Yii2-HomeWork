<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 50])->label('Логин') ?>

    <?= $form->field($model, 'password')->textInput(['minlength' => 6]) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 50])->label('Ваше имя') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 50])->label('Ваша фамилия') ?>
    
    <div class="form-group">
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>