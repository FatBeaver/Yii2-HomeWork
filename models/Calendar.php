<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "calendar".
 *
 * @property int $id id
 * @property string $name Имя заметки
 * @property string $content Содержание заметки
 * @property string $date_of_create Дата создания
 * @property string $date_of_change Дата изменения
 * @property string $expiration_date Дата окончания
 * @property int $author_id
 */
class Calendar extends \yii\db\ActiveRecord
{   

    public $month;
    public $years;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calendar';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' =>[ActiveRecord::EVENT_BEFORE_UPDATE => ['date_of_change']],
                'value' => new Expression('NOW()'),
            ],
        ];
    } 
    
    public function beforeSave($insert)
    {
        if (!$this->author_id) {
            $this->author_id = \Yii::$app->getUser()->getId();
        }

        return parent::beforeSave($insert);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'author_id'], 'required'],
            [['content'], 'string'],
            [['date_of_change', 'expiration_date'], 'safe'],
            [['date_of_create', 'expiration_date'], 'validateCreateDate'],
            [['author_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            //[['month', 'years'], 'safe'],
        ];
    }

    public function validateCreateDate() {

        $createDate = date_create($this->date_of_create);
        $expirationDate = date_create($this->expiration_date);

        $createDate = date_format($createDate, 'Ymd');
        $expirationDate = date_format($expirationDate, 'Ymd');
        
        if ($this->expiration_date == null) {
            $this->expiration_date = $this->date_of_create;

        }

        if ($createDate > $expirationDate) {

            $this->addError('expiration_date', sprintf('Неверно указанна дата окончания события'));
        }

        return true;
    } 

    /**
     * @return bool
     */
    public static function canEdit($model) {
        $createDate = date_create($model->date_of_create);

        if (date_format($createDate, 'Ynj') < date('Ynj')) {

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'content' => 'Содержание',
            'date_of_create' => 'Дата создания',
            'date_of_change' => 'Дата изменения',
            'expiration_date' => 'Дата окончания',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return array
     */
    public function getData($id, $date) { 
        $notes =  Calendar::find()->where('author_id = :id', [':id' => $id])
        ->andWhere('MONTH(date_of_create) = MONTH("' . $date->format('Y-m-d') . '")
        and YEAR(date_of_create) = YEAR("' . $date->format('Y-m-d') . '")')
        ->asArray()->all();
        
        return $notes;
    }
    
    /**
     * @return integer
     */
    public function getLastMonthDay($monthes) {
        for ($i = 0; $i < 12; $i++) {

            if ($monthes[$i] == 2) {
                $monthsDays = 28;
                return $monthsDays;
            } elseif ($monthes[$i]  % 2 == 0) {
                $monthsDays = 30;
            } else {
                $monthsDays = 31;
            }

        }

        return $monthsDays;
    }

    public function getThisDate() {
        if (\Yii::$app->request->get()) {


            (string) $m = $_GET['Calendar']['month'];//\Yii::$app->request->get('month');
            (string) $Y = $_GET['Calendar']['years'];//\Yii::$app->request->get('years');
            (string) $d = 01;
            (string) $selectedDate = $Y . '-' . $m . '-' . $d;

            $date = new \DateTime($selectedDate);
            
            return $date;

        } else {

            $date = new \DateTime('first day of this month');

            return $date;
        }
    }


    /**
     * @return array 
     */
    public function getNotesForCalendar() {
        
        $id = \Yii::$app->getUser()->getId(); // Получение id юзера

        $date = $this->getThisDate(); // Получение выбранного времени или текущего по умолчанию
        
        $sqlData = $this->getData($id, $date);  // Получение данных из бд на выбраный месяц

        $monthLength = $this->getMonthLength ($date); // Длина месяца в днях
           

        for ($i = 1; $i < $monthLength; $i++) {

            if ($sqlData != null) {
                foreach($sqlData as $note) {

                    $timeNote = date_create($note['date_of_create']);
                    $timeNote = date_format($timeNote, 'j');

                    if ($i == $timeNote) {
                        $calendarMonth[$i][] = $note;
                    } else {
                        if($calendarMonth[$i] != null) {
                            continue;
                        }

                        $calendarMonth[$i] = null;
                    }
                }
            } else {
                $calendarMonth[$i] = null;
            }
        }
        return $calendarMonth;
    }        


    /**
     * @return integer
     */
    public function getWeekOfThisMonth($date) {
        if ($date->format('w') == 0) {
            return 7;
        }
        
        return $date->format('w');
    }

    public function getMonthLength ($date) {
        if ($date->format('n') == 2) {
            if ($date->format('y') == 16) {
                if ($date->format('n') == 2) {
                    return 30;
                }
            }
            return 29;

        } else if (($date->format('n') == 1) || ($date->format('n') == 3) || ($date->format('n') == 5) 
            || ($date->format('n') == 7) || ($date->format('n') == 8) || ($date->format('n') == 10) 
            || ($date->format('n') == 12) ) {

            return 32;
        }

        return 31;
    }
    
    /**
     * @return array
     */
    public function setIdInArray($day) {
        
        foreach($day as $note) {
            $id[] = $note['id'];
        } 

        return $id;
    }


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


    public function getAuthor() {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getAccess() {
        return $this->hasOne(Access::class, ['note_id' => 'id']); 
    }

}   
