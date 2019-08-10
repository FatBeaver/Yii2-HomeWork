<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$month = $model->getOptoinsDate('month');
$years = $model->getOptoinsDate('years');
?>

<div class="select_date">
    <?php $form = ActiveForm::begin(['method' => 'GET']); ?>
        <div class="inner_active_form">

            <?= $form->field($model, 'years')->dropDownList([
                $years,
            ])->label('Выберите год'); ?>

            <?= $form->field($model, 'month')->dropDownList([
                $month,
            ])->label('Выберите месяц'); ?>

            <div class="form-group">
                <?= Html::submitButton('Выбрать дату', ['class' => 'btn btn-success date_button']) ?>
            </div>

        </div>        
    <?php ActiveForm::end(); ?>
    <h2>
        Сегодня : 
        <?= date('j') . ' ' . $model->headerCalendarDate($model->getOptoinsDate('calendar_head')) . 
        ' ' . date('Y') ?>
    </h2>
</div>