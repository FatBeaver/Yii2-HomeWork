<?php 

use yii\helpers\Html;
use app\models\Calendar;


?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?= \yii\helpers\Html::encode($model->name); ?></h3>
    </div>
    <div class="panel-body">
        <h3>Автор события : <?= $model->author->username; ?></h3>
        <p>Содержание заметки : <?= $model->content; ?></p>
        <p>Дата начала : <?= \Yii::$app->formatter->asDate($model->date_of_create, 'php:d.m.y H:i')?></p>
        <p>Дата обновления : <?= \Yii::$app->formatter->asDate($model->date_of_change, 'php:d.m.y H:i')?></p>
        <p>Дата окончания : <?= \Yii::$app->formatter->asDate($model->expiration_date, 'php:d.m.y H:i')?></p>
        <?php if (Calendar::canEdit($model)) { ?>
            <a href="<?= \Yii::$app->urlManager->createUrl(['calendar/view', 'id' => $model->id]) ?>" class="edit_event">
            Редактировать
            </a>
        <?php } else {?>
            <p class="not_edit_event">Событие закончилось</p>
        <?php } ?>
    </div>
</div>
