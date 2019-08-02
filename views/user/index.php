<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'pager' => [
            'firstPageLabel' => 'first',
            'lastPageLabel' => 'last',
            'prevPageLabel' => 'previous',
            'nextPageLabel' => 'next',
        ],
    ]); ?>

</div>
