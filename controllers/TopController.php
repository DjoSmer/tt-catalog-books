<?php

namespace app\controllers;

use app\models\TopSearch;
use yii\web\Controller;

class TopController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new TopSearch([
            'release_year' => date('Y')
        ]);
        $dataProvider = $searchModel->top10($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
