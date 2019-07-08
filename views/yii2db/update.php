<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Yii2db */

$this->title = 'Update Yii2db: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Yii2dbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="yii2db-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
