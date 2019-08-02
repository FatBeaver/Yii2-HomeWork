<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Изменить профиль : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Редактирование профиля', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::img($model->getImage(), ['width' => 350]) ?>
    <p class="updatepage_user_image">Ваш аватар </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
