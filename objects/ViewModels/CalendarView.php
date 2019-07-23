<?php 

namespace app\objects\ViewModels;

class CalendarView {

    /**
     * @return  bool
     */
    public function canWrite($note) {
        
        return $note->author_id == \Yii::$app->getUser()->getId();
    }
}