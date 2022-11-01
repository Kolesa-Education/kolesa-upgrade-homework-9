<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdvertsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adverts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--    --><?//= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>
<!---->
<!--    --><?//= $form->field($model, 'desc') ?>
<!---->
<!--    --><?//= $form->field($model, 'cat_id') ?>
<!---->
<!--    --><?//= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить', ['/adverts/index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
