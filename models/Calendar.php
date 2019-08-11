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
     * @return string
     */
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
    public static function getNotesForCalendar($id, $date) {
        
        $sqlData =  Calendar::find()->where('author_id = :id', [':id' => $id])
            ->andWhere('MONTH(date_of_create) = MONTH("' . $date->format('Y-m-d') . '")
            and YEAR(date_of_create) = YEAR("' . $date->format('Y-m-d') . '")')
            ->asArray()->all(); // Получение заметок из бд на выбранный пользователем месяц; 

        for ($i = 1; $i < ($date->format('t') + 1); $i++) {

            $calendarMonth[$i] = null;
        }

        foreach ($sqlData as $note) {

            $dateNoteCreate = date_create($note['date_of_create']); 
            $dateNoteCreate = date_format($dateNoteCreate, 'j');

            $calendarMonth[$dateNoteCreate][] = $note;
        }
        
        return $calendarMonth;
    }        


    /**
     * @return array    
     */
    public function setIdInArray($day) { // Получение ID заметок для ссылки
        
        foreach($day as $note) {
            $id[] = $note['id'];
        } 

        return $id;
    }


    /**
     * @return array
     */
    public function getOptoinsDate($date) {
        if ($date == 'years') {
            for ($i = 2012; $i < 2026; $i++) {
                $years[$i] = $i;
            }

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
