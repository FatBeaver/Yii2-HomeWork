<?php 

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\AccessLog;
use yii\helpers\Console;

class LogRotateController extends Controller {
    /**
     * @return int
     */

     public function actionAccess() {
        
        $total = AccessLog::find()->count();
        
        Console::startProgress(0, $total);
        foreach (AccessLog::find()->each() as $key => $model) {
            $model->delete();
            Console::updateProgress($key + 1,  $total);
        }
        Console::endProgress();

        return ExitCode::OK;
     }
}