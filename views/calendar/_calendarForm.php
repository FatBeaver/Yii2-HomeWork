<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$month = $model->getOptoinsDate('month');
$years = $model->getOptoinsDate('years');
?>

<div class="select_date">
    <?php $form = ActiveForm::begin(['method' => 'GET']); ?>
    
    <?= $form->field($model, 'years')->dropDownList([
        $years,
    ])->label('Выберите год'); ?>

    <?= $form->field($model, 'month')->dropDownList([
        $month,
    ])->label('Выберите месяц'); ?>

    <div class="form-group">
        <?= Html::submitButton('Выбрать дату', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>