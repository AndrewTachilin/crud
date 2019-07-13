<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trainings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'training_photo') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'text_before') ?>

    <?php // echo $form->field($model, 'text_after') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'speaker') ?>

    <?php // echo $form->field($model, 'feedback_video') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
