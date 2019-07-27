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

        if (date_format($createDate, 'd') < date('d')) {

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

    
    public function getNotesForCalendar() {
        
        $id = \Yii::$app->user->identity->id;
        $notes =  Calendar::find()->where('author_id = :id', [':id' => $id])
                                ->andWhere('MONTH(date_of_create) = MONTH(NOW()) and YEAR(date_of_create) = YEAR(NOW())')
                                ->asArray()->all();

        
        $calendarMonth = array();
        
        $date = new \DateTime('first day of this month');                 
        for ($j = 1; $j < 32; $j++) {

            foreach( $notes as $note) {
            $timeNote = date_create($note['date_of_create']);
            $timeNote = date_format($timeNote, 'd');

                if ($date->format('d') == $timeNote) {
                   $calendarMonth[$j][] = $note;
                } else {
                    if($calendarMonth[$j] != null) {
                        continue;
                    }
                    $calendarMonth[$j] = null;
                }
            }
            $date = $date->modify('+1 day');
        }   

        return $calendarMonth;
    }
     

    public function getAuthor() {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getAccess() {
        return $this->hasOne(Access::class, ['note_id' => 'id']); 
    }
}   
