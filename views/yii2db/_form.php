<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Yii2db */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yii2db-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_at')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'end_at')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'create_ad')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'updated_at')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
