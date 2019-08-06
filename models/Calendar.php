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

    public function getData($id, $date) { 
        $notes =  Calendar::find()->where('author_id = :id', [':id' => $id])
        ->andWhere('MONTH(date_of_create) = MONTH("' . $date->format('Y-m-d') . '")
        and YEAR(date_of_create) = YEAR("' . $date->format('Y-m-d') . '")')
        ->asArray()->all();
        
        return $notes;
    }
    
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
        if (\Yii::$app->request->queryParams) {

            (string) $m = \Yii::$app->request->get('month');
            (string) $Y = \Yii::$app->request->get('year');
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

            $monthLength = $this->getMonthLength ($date);
            $currentDay = 1;
            $week = 0;

            $dayOfFirstWeek = $this->getWeekOfThisMonth($date); // Получение первого дня недели числом

            for ($i = 0; $i < 8; $i++) { 

                if ($dayOfFirstWeek == $i) {
                    $dayOfFirstWeek++;
                    
                   if ($sqlData != null) {

                        foreach ($sqlData as $note) {
                                
                            $dateNote = date_create($note['date_of_create']);
                            $dateNote = date_format($dateNote, 'j');
                    
                            if ($i == $dateNote) {
                                $calendarMonth[$week][$currentDay][] = $note;
                    
                            } else {
                                if ($calendarMonth[$week][$currentDay] != null) {
                                    continue;
                                }
                                $calendarMonth[$week][$currentDay] = null;
                            }
                        }

                    }  else {

                        $calendarMonth[$week][$currentDay] = null;
                    }
                } else {

                   continue;   
                }

                $currentDay ++;
            }
            
            while (true) {

                $week++;
                for($i = 0; $i < 7; $i++)
                {
                    if ($sqlData != null) {
                    foreach ($sqlData as $note) {
                            
                        $dateNote = date_create($note['date_of_create']);
                        $dateNote = date_format($dateNote, 'j');
                
                        if ($currentDay == $dateNote) {
                            $calendarMonth[$week][$currentDay][] = $note;
                
                        } else {
                            if ($calendarMonth[$week][$currentDay] != null) {
                                continue;
                            }
                            $calendarMonth[$week][$currentDay] = null;
                        }
                    }
                } else {

                    $calendarMonth[$week][$currentDay] = null;
                }
                    $currentDay ++;
                    if($currentDay > $monthLength - 1 ) break;
                }
               
                if($currentDay  > $monthLength - 1) break;
              } 
            
            return $calendarMonth;      
        }   

    public function selectedCalendarDate($date) { ?>

        <form action="http://yii2.loc/web/calendar/calendar" method="GET">
        <label for="">Год:</label>
        <select name="year" id="year" >
            <?php 
                for ($i = 2000; $i < 2026; $i++) {
                    if (isset($_GET['submit'])) {
                        if ($i == \Yii::$app->request->get('year')) {
                            echo '<option selected>' . $i . '</option>';
                            continue;
                        }
                    } elseif ($i == $date->format('Y')) {
                        echo '<option selected>' . $i . '</option>';
                        continue;
                    }
                    echo '<option>' . $i . '</option>';
                }
                  
            ?>
        </select>
        <label for="month" >Месяц: </label>
        <select name="month" id="month" >
            <?php 
                for ($i = 1; $i < 13; $i++) {
                    if (isset($_GET['submit'])) {
                        if ($i == \Yii::$app->request->get('month')) {
                            echo '<option selected>' . $i . '</option>';
                            continue;
                        }
                    } elseif ($i == $date->format('n')) {
                        echo '<option selected>' . $i . '</option>';
                        continue;
                    }
                    echo '<option>' . $i . '</option>';
                }
            ?>
        </select>
        <input type="submit" name="submit" id="select_calendar_date" value="Выбрать дату">
        </form>
    <?php
    }    


    public function getWeekOfThisMonth($date) {
        if ($date->format('w') == 0) {
            return 7;
        }
        if ($date->format('w') == 1) {
            return 1;
        }
        if ($date->format('w') == 2) {
            return 2;
        }
        if ($date->format('w') == 3) {
            return 3;
        }
        if ($date->format('w') == 4) {
            return 4;
        }
        if ($date->format('w') == 5) {
            return 5;
        }
        if ($date->format('w') == 6) {
            return 6;
        }
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
    

    public function getAuthor() {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getAccess() {
        return $this->hasOne(Access::class, ['note_id' => 'id']); 
    }

}   
