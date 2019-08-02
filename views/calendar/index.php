<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\data\Pagination; 

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ваша главная страница';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user_profile_data">
        <?= Html::img($userData->getImage(), ['width' => 350], ['alt' => 'img']) ?>

        <p class="string_data"><span class="index_span">Имя  :</span> <?= Html::encode($userData->first_name) ?></p>
        <p class="string_data"><span class="index_span">Фамилия :</span> <?= Html::encode($userData->last_name) ?></p>
        <p class="string_data"><span class="index_span">Email :</span> <?= Html::encode($userData->email) ?></p>

        <?= Html::a('Изменить профиль',['user/update', 'id' => $userData->id], ['class' => 'edit_user_profile']) ?>

    </div>  
    <div class="user_profile_data_body">
        <h2>Список активных и доступных вам событий</h2>
        <p>
            <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success create_action']) ?>
        </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'emptyText' => 'Заметок нет',
            'emptyTextOptions' => ['tag' => 'p'],
            'pager' => [
                'nextPageLabel' => '>>>',
                'prevPageLabel' => '<<<',
            ], 
        ]); ?>
    </div>

</div>
