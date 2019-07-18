<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Access;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Access */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Access', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'note.name',
            'user.username',
            [
                'value' => function (Access $model) {
                    return Html::a($model->user->username, ['user/view', 'id' => $model->id]);
                },
                'format' => 'raw',

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
