<?php

namespace app\controllers;

use app\models\Project;
use yii\data\ActiveDataProvider;
use app\models\ManagerAccessFilter;
class ManagerController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => ManagerAccessFilter::class,
                ],
            ],

        );
    }
    public function actionIndex()
    {
        $projects = new ActiveDataProvider([
            'query' => Project::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);
         return $this->render('index', [
            'projects' => $projects,
        ]);
    }

}
