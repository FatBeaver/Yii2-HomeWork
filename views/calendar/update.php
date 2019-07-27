<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = 'Изменить событие: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Активные события', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение события';
?>
<div class="calendar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viewModel' => $viewModel,
    ]) ?>

</div>
