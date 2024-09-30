<?php

use app\models\Author;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    if (!Yii::$app->user->isGuest) {
        echo Html::tag('p', Html::a('Create Author', ['create'], ['class' => 'btn btn-success']));
    }

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'first_name',
            'last_name',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
                'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
