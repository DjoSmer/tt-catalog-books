<?php

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Author $model */
/** @var app\models\SubscribeForm $subscribeForm */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
    <div class="author-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php
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

        echo Html::beginTag('div');
        echo Html::tag('h3', 'Subscribe to the author');

        $form = ActiveForm::begin([
            'id' => 'form-author-subscribe',
            'action' => 'subscribe',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
        ]);

        echo $form->field($subscribeForm, 'author_id')->hiddenInput()->label(false);
        echo $form->field($subscribeForm, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => '71112223344']);

        echo Html::beginTag('div', ['class' => 'form-group']);
        echo Html::submitButton('Subscribe', ['class' => 'btn btn-success']);
        echo Html::endTag('div');

        ActiveForm::end();

        echo Html::endTag('div');
        ?>

    </div>

<?php
$this->registerJsFile('@web/js/subscribe.js', ['depends' => [JqueryAsset::class]]);
