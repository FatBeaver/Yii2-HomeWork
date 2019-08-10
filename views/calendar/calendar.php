<?php 

use yii\helpers\Html;

$this->title = 'Календарь';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="main_calendar_block">
    <h1 class="calendar_title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render( '_calendarForm',[   //-------Форма выбора даты 
        'model' => $model,         
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
            for ($i = 1; $i < $date->format('N'); $i++) {
                echo '<div class="days_of_prev_month"></div>';
            }
            foreach ($month as $number => $day) {

                if ($day != null) {   

                    $id = $model->setIdInArray($day);

                    echo '<div class="day_with_notes">';
                    echo Html::a('Событий ' . count($day) , ['calendar/index', 'id' => $id]);
                    echo '</div>';

                } else {
                    if (($date->format('D') == 'Sat') || $date->format('D') == 'Sun') {
                        echo '<div class="day_without_notes week_end">' . $number . '</div>';
                    } else {
                        echo '<div class="day_without_notes">' . $number . '</div>';
                    }
                }
                $date->modify('+1 day');
            }
        ?>
    </div>
    </div>        
</div>
