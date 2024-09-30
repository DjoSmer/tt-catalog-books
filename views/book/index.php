<?php

use app\models\Book;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    if (!Yii::$app->user->isGuest) {
        echo Html::tag('p', Html::a('Create Book', ['create'], ['class' => 'btn btn-success']));
    }

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'description:ntext',
            'release_year',
            'isbn',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
                'urlCreator' => function ($action, Book $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]);
    ?>
</div>
