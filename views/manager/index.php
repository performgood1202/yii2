<?php

use app\models\Project;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Projects';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table td{
        max-width: 128px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Project', ['project/create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $projects,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Project $model, $key, $index, $column) {
                    return Url::toRoute(["project/".$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
