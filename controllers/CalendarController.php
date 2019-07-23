<?php

namespace app\controllers;

use Yii;
use app\models\Calendar;
use app\models\search\CalendarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\objects\ViewModels\AccessCreateView;
use app\models\forms\CalendarForm;
use yii\web\ForbiddenHttpException;
use app\models\Access;
use app\objects\ViewModels\CalendarView;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
                'class' => AccessControl::class,
                'only'  => ['create', 'index', 'update', 'delete', 'calendar'],
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
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCalendar() {

       $calendar = new Calendar();
       $MonthNotes = $calendar->getNotesForCalendar();
      
        return $this->render('calendar', ['monthNotes' => $MonthNotes]);

    }

    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $note = $this->findModel($id);

        if (!$this->checkAccess($note)) {
            throw new ForbiddenHttpException('У вас нет доступа к текущей заметке');
        }

        $author = $note->author;
        $note = $author->notes;  

        $viewModel = new CalendarView();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'viewModel' => $viewModel,
        ]);
    }

    protected function checkAccess($note) {
        $currentId = \Yii::$app->getUser()->getId();

        if ($note->author_id == $currentId) {
            return true;
        } elseif (Access::find()->andWhere(['note_id' => $note->id, 'user_id' => $currentId])->count()) {
            return true;
        } 

        return false;
        
    }

    protected function checkWriteAccess($note) {
        return $note->author_id == \Yii::$app->getUser()->getId();
    } 

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $viewModel = new AccessCreateView;

        $model = new CalendarForm();

        $model->author_id = \Yii::$app->getUser()->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $viewModel = new AccessCreateView;

        
        $model = $this->findModel($id);

        if (!$this->checkWriteAccess($model)) {
            throw new ForbiddenHttpException('Вы не можете удалить данную заметку');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $note = $this->findModel($id);

        if (!$this->checkWriteAccess($note)) {
            throw new ForbiddenHttpException('Вы не можете удалить данную заметку');
        }

        $note->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CalendarForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
