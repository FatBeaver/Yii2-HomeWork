<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="calendar-forms">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 3]) ?>

        <?= $form->field($model, 'date_of_create')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'expiration_date')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'users')
        ->checkboxList($viewModel->getUserOptions(), ['separator' => '</br>'])
        ->label('Пользователи')
        ->hint('Пользователи имеющие доступ к заметке'); ?>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
<div>