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
    //->andWhere("MONTH(date_of_create) = MONTH('" . $dateSql->format('Y-m-d') . "') 
      //                              and YEAR(date_of_create) = YEAR('" . $dateSql->format('Y-m-d') . "')")
    public function getData($id) { 
        $notes =  Calendar::find()->where('author_id = :id', [':id' => $id])
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


    /**
     * @return array 
     */
    public function getNotesForCalendar() {
        
        $id = \Yii::$app->user->identity->id;
        
        $date = new \DateTime('01-01-2015');

        $sqlData = $this->getData($id, $date);  


        while ($date->format('Ynj') < 2026121)  {

            $monthLength = $this->getMonthLength ($date);

            for($i = 1; $i < $monthLength; $i++) {  
                foreach ($sqlData as $note) {

                    $dateNote = date_create($note['date_of_create']);
                    $dateNote = date_format($dateNote, 'ynj');
        
                    if ($date->format('yn' . $i) == $dateNote) {
                        $calendarMonth[$date->format('y')][$date->format('n')][$i][] = $note;
        
                    } else {
                        if ($calendarMonth[$date->format('y')][$date->format('n')][$i] != null) {
                            continue;
                        }
                        $calendarMonth[$date->format('y')][$date->format('n')][$i] = null;
                    }
                }   
            }   
            $date->modify('+1 month');
        }

        return $calendarMonth;
    }


    public function getMonthLength ($date) {
        if ($date->format('n') == 2) {
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
