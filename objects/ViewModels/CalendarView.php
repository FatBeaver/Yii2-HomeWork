<?php 

namespace app\objects\ViewModels;

use yii\base\Model;

class CalendarView extends Model {

    public $month;
    public $years;

    public function rules() {
        return [
            [['month', 'years'], 'safe'],
        ];
    }

     /**
     * @return array
     */
    public function getOptoinsDate($date) {
        if ($date == 'years') {
            $years = [
                '2010' => '2010',
                '2011' => '2011',
                '2012' => '2012',
                '2013' => '2013',
                '2014' => '2014',
                '2015' => '2015',
                '2016' => '2016',
                '2017' => '2017',
                '2018' => '2018',
                '2019' => '2019',
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
                '2026' => '2026',
            ];  

            return $years;
        } 

        if ($date == 'month') {
            $month = [
                '1'   => 'Январь',
                '2'   => 'Февраль',
                '3'   => 'Март',
                '4'   => 'Апрель',
                '5'   => 'Май',
                '6'   => 'Июнь',
                '7'   => 'Июль',
                '8'   => 'Август',
                '9'   => 'Сентябрь',
                '10'  => 'Октябрь',
                '11'  => 'Ноябрь',
                '12'  => 'Декабрь',
            ];

            return $month;
        }
    }

    /**
     * @return  bool
     */
    public function canWrite($note) {
        
        return $note->author_id == \Yii::$app->getUser()->getId();
    }
}