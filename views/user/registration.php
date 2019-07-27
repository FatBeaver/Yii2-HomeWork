<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode('Страница регистрации')?></h1>
<p>Для успешной регистрации необходимо заполнить все поля :</p>

<?= $this->render('_registrationForm', [
    'model' => $model,
    ]) ?>

