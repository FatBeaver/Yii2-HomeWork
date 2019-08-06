<?php 

use yii\helpers\Html;

$this->title = 'Календарь';
$this->params['breadcrumbs'][] = $this->title;

$date = new \DateTime('first day of this month');

?>
<div class="calendar_table">
    <h1 class="calendar_title"><?= Html::encode($this->title) ?></h1>

    <div class="select_date">  
        <?php $calendar->selectedCalendarDate($date); ?> 
    </div>



    <table border="1" class="calendar_notes">
        <tr>
            <th>Пн</th>
            <th>Вт</th>
            <th>Ср</th>
            <th>Чт</th>
            <th>Пт</th>
            <th class="week_end">Сб</th>
            <th class="week_end">Вс</th>
        </tr>
<?php   
        $currentDay = 1;
        for ($i = 0; $i < count($month); $i++) {
            echo '<tr>';
/////////////////////////////////////////////////////////////////////////////////////////
                if ($i === 0) {
                    $weekLength = 7 - count($month[0]);
                    for ($j = 0; $j < $weekLength; $j++) {
                        echo '<td class="null_date"></td>';
                    }
                }                                                                     
////////////////////////////////////////////////////////////////////////////////////////
                foreach ($month[$i] as $day) {
                    if ($day != null) {

                        foreach ($day as $note_id) {
                            $id[] = $note_id['id'];
                        }
                        $notes = count($day);

                        echo '<td class="notes">'; ?>
                        <?= Html::a('Cобытий</br>' . $notes, ['calendar/index', 'id' => $id]); ?>
                  <?php echo'</td>';

                        $currentDay++;

                    } else {
                       
                        $time = $calendar->getThisDate();  
                        if ( ($time->format('n') == $date->format('n')) && ($currentDay == date('j')) 
                                && ($time->format('Y') == $date->format('Y')) ) {     
                            echo '<td class="today_date">' . $currentDay . '</td>';
                            $currentDay++;
    
                        } else {
                            echo '<td>' . $currentDay . '</td>';
                            $currentDay++;
                        }    
                    }    

                    if ($currentDay > $calendar->getMonthLength($date)) {
                        break;
                    }
                }

                if ($curentDay > $calendar->getMonthLength($date)) {
                    break;
                }
/////////////////////////////////////////////////////////////////////////////////////////               
            echo '</tr>';
        }
        
?>
    </table>
</div>