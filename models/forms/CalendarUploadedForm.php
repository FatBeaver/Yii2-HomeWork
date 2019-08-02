<?php 

namespace app\models\forms;

use Yii;
use yii\base\Model;

class CalendarUploadedForm extends Model {

    public $image;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false],
        ];
    }

    public function uploadFile($file, $currentFile) {
        $this->image = $file;

        if ($this->validate()) {
            $this->deleteCurrentFile($currentFile);

            $filename = $file->baseName . time() . $file->extension;

            $file->saveAs(Yii::getAlias('@webroot/') . 'uploads/image/' . $filename);

            return $filename;
        }
    }

    public function deleteCurrentFile($currentFile) {
        if (file_exists(Yii::getAlias('@webroot/') . 'uploads/image/' . $currentFile)) {
            @unlink(Yii::getAlias('@webroot/') . 'uploads/image/' . $currentFile);
        } 
    }   
}