<?php

namespace app\models;


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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'author_id'], 'required'],
            [['content'], 'string'],
            [['date_of_create', 'expiration_date'], 'safe'],
            [['author_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
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

    public function getNotesForCalendar() {
        $id = \Yii::$app->user->identity->id;
        $notes =  Calendar::find()->where('author_id = :id', [':id' => $id])
                                ->andWhere('MONTH(date_of_create) = MONTH(NOW()) and YEAR(date_of_create) = YEAR(NOW())')
                                ->all();

     
        $calendarMonth = array( 'week1' => array(
                                        'day1' => array(),
                                        'day2' => array(),
                                        'day3' => array(),
                                        'day4' => array(),
                                        'day5' => array(),
                                        'day6' => array(),
                                        'day7' => array(),
                                ),
                                'week2' => array(
                                        'day8' =>  array(),
                                        'day9' =>  array(),
                                        'day10' => array(),
                                        'day11' => array(),
                                        'day12' => array(),
                                        'day13' => array(),
                                        'day14' => array(),
                                ), 
                                'week3' => array(
                                        'day15' => array(),
                                        'day16' => array(),
                                        'day17' => array(),
                                        'day18' => array(),
                                        'day19' => array(),
                                        'day20' => array(),
                                        'day21' => array(),
                                ),
                                'week4' => array(
                                        'day22' => array(),
                                        'day23' => array(),
                                        'day24' => array(),
                                        'day25' => array(),
                                        'day26' => array(),
                                        'day27' => array(),
                                        'day28' => array(),
                                ),
                                'week5' => array(
                                        'day29' => array(),
                                        'day30' => array(),
                                        'day31' => array(),
                                ));
        
        $day = 1;                        
        for ($week = 1; $week < 5; $week++) {

            for ($j = 1; $j < 7; $j++) {
                $calendarMonth['week' . $week]['day' . $day];
                $day++;
                foreach ($notes as $note) {

                    $event = substr($note->date_of_create, 8, -9);
                    if ($day == $event) {
                        $calendarMonth['week' . $week]['day' .  $day][] = $note;
                    } 

                }
            } 
        }
        return $calendarMonth;
    }
     
    public function getAuthor() {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}
