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
        <?php for($i = 0; $i < 32; $i = $i + 7): ?>
            <tr>
                <?php for ($j = 0; $j < 7; $j++) {
                    if ($CalendarDay > 31) {
                        break;
                    }
                    $id = array();
                    if ($monthNotes[$CalendarDay] == null) {
                        echo '<td>' . $CalendarDay . '</td>';
                    } else {
                        foreach($monthNotes[$CalendarDay] as $note) {
                            $id[] = $note['id'];
                        }
                            $notes = count($monthNotes[$CalendarDay]);?>
                            <?= '<td class="event_data">'?>
                            <a href="<?=Yii::$app->urlManager->createUrl(['calendar/index', 'id' => $id]) ?>">
                            <?='Cобытий <br/>' . $notes . '</a></td>'?>
            <?php   }
                    $CalendarDay++;
                } ?>
            </tr>
                <?php endfor; ?>
    </table>

</div>