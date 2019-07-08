<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Yii2db */

$this->title = 'Create Yii2db';
$this->params['breadcrumbs'][] = ['label' => 'Yii2dbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yii2db-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
