<?php 

use yii\helpers\Html;

$this->title = 'Календарь';
$this->params['breadcrumbs'][] = $this->title;

$month = $model->getNotesForCalendar();
$date = new \DateTime('first day of this month');
$weekEndDate = $model->getThisDate();
?>

<div class="main_calendar_block">
    <h1 class="calendar_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render( '_calendarForm',[
        'model' => $model,
        'viewModel' => $viewModel,
    ]); ?>

    <div class="calendar">
        <div class="wrapper_calendar">
        <div class="days_name">
            <div class="header_name_day">Пн</div>
            <div class="header_name_day">Вт</div>
            <div class="header_name_day">Ср</div>
            <div class="header_name_day">Чт</div>
            <div class="header_name_day">Пт</div>
            <div class="header_name_day week_end">Сб</div>
            <div class="header_name_day week_end">Вс</div>   
        </div>
            <?php
            foreach ($month as $number => $day) {
                
                if ($number == 1) {

                    $dayFirstWeek = $model->getWeekOfThisMonth($model->getThisDate());

                    if ($day != null) {
                        $id = $model->setIdInArray($day);

                        echo '<div class="day_with_notes day_number' . $dayFirstWeek . '">';
                        echo Html::a('Событий ' . count($day) , ['calendar/index', 'id' => $id]);
                        echo '</div>';

                    } else {

                        if ($weekEndDate->format('D') == 'Mon' || $weekEndDate->format('D') == 'Sun') {
                            echo '<div class="day_without_notes week_end day_number' . $dayFirstWeek . 
                            '">' . $number . '</div>';

                        } else {
                            echo '<div class="day_without_notes day_number' . $dayFirstWeek . 
                            '">' . $number . '</div>';
                        }

                    }

                    $weekEndDate->modify('+1 day');
                    continue;
                }

                if ($day != null) {   

                    $id = $model->setIdInArray($day);

                    echo '<div class="day_with_notes">';
                    echo Html::a('Событий ' . count($day) , ['calendar/index', 'id' => $id]);
                    echo '</div>';

                } else {
                    if (($weekEndDate->format('D') == 'Sat') || $weekEndDate->format('D') == 'Sun') {
                        echo '<div class="day_without_notes week_end">' . $number . '</div>';
                    } else {
                        echo '<div class="day_without_notes">' . $number . '</div>';
                    }
                }
                $weekEndDate->modify('+1 day');
            }
        ?>
    </div>
    </div>        
</div>
