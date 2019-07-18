<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'content',
            [
                'attribute'  => 
                    'date_of_create',
                'format' => [
                    'date',
                    'php:d.m.Y H:i',
                ]
            ],
            [
                'attribute'  => 'date_of_change',
                'format' => [
                    'date',
                    'php:d.m.Y H:i',
                ]
            ],
            [
                'attribute'  => 'expiration_date',
                'format' => [
                    'date',
                    'php:d.m.Y H:i',
                ]
            ],                      
            'author.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
