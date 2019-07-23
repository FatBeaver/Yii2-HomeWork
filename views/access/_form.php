<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'note_id')->dropDownList($viewModel->getNoteOptions()) ?>

    <?= $form->field($model, 'user_id')->dropDownList($viewModel->getUserOptions()) ?>

    <div class="form-group">
        <?= Html::submitButton('Разрешить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
