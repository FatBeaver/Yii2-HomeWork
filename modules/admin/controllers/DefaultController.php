<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\User;
use yii\web\HttpException;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {   
        $id = \Yii::$app->getUser()->getId();
        $model = User::find()->where(['id' => $id])->one();
       
        if ($model->password != a0b6ebd494448984de947aa1526bbb77 ) {
            throw new HttpException(404 ,'User not found');
        }
        return $this->render('index');
    }
}
