<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TopSearch $searchModel */
/** @var yii\data\ArrayDataProvider $dataProvider */

$this->title = 'Top 10';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'release_year') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Name',
                'format' => 'html',
                'value' => fn($value) => Html::a($value['first_name'] . ' ' . $value['last_name'], ['author/view', 'id' => $value['id']])
            ],
            'number:text:Number of books',
        ],
    ]);
    ?>
</div>
