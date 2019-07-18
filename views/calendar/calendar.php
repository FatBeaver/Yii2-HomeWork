<?php 

use yii\helpers\Html;
use app\models\Calendar;

$this->title = 'Календарь на текущий месяц';
$this->params['breadcrumbs'][] = $this->title;

$CalendarDay = 1;
?>
<div class="calendar_table">
    <h1><?= Html::encode($this->title) ?></h1>

    <table border="1" class="calendar_notes">
        <th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th>
        <?php foreach ($monthNotes as $week): ?>
            <tr>
                <?php foreach($week as $day) {
                    $id = array();
                    if ($day == null) {
                        echo '<td>' . $CalendarDay . '</td>';
                    } else {
                        foreach($day as $notes) {
                            $id[] = $notes ->id;
                        }
                        $notes = count($day);?>
                        <?= '<td class="event_data">'?>
                        <a href="<?=Yii::$app->urlManager->createUrl(['calendar/index', 'id' => $id]) ?>">
                        <?='Cобытий <br/>' . $notes . '</a></td>'?>
            <?php   }
                    $CalendarDay++;
                } ?>
            </tr>
                <?php endforeach; ?>
    </table>

</div>