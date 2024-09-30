<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo Html::beginTag('p');
    foreach ($model->bookImages as $image) {
        echo Html::img('/uploads/' . $image->filename, ['class' => 'img-thumbnail', 'style' => 'width: 200px;']);
    }
    echo Html::endTag('p');

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'release_year',
            'isbn',
            'created_at',
            [
                'label' => 'Authors',
                'format' => 'html',
                'value' => Html::ul(
                    ArrayHelper::map(
                        $model->authors,
                        'id',
                        fn($author) => Html::a($author->first_name . ' ' . $author->last_name, ['author/view', 'id' => $author->id])
                    ),
                    ['class' => 'list-group', 'encode' => false, 'itemOptions' => ['class' => 'list-group-item']]
                )
            ],
        ],
    ]);

    if (!Yii::$app->user->isGuest) {
        $updateButton = Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        $deleteButton = Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
        echo Html::tag('p', $updateButton . ' ' . $deleteButton);
    }
    ?>

</div>
