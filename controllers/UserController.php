<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use app\models\User;
use app\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\forms\UserForm;
use app\models\forms\CalendarUploadedForm;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'delete', 'create', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        $userData = User::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userData' => $userData,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
       // $searchModel = new UserSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = UserForm::findOne(['id' => $id]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionRegistration() {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['calendar/index', 'id' => $model->id]);
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $userData = $this->findModel($id);

        $model = new CalendarUploadedForm();

        if (Yii::$app->request->post()) {         

            $file = UploadedFile::getInstance($userData, 'image');

            $model->uploadFile($file, $model->image);
            
            $userData->saveImage($model->uploadFile($file, $userData->image)); 
   
            if ($userData->load(Yii::$app->request->post()) && $userData->save()) {
                return $this->redirect(['calendar/index']);
            }
        }

        return $this->render('update', [
            'model' => $userData,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
