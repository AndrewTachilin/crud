<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Trainings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trainings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'training_photo')->fileInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::className(), [
        'name' => 'date',
        'value' => date('Y-m-d', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select issue date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-m-d',
            'todayHighlight' => true
        ]
    ]); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'text_before')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text_after')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'speaker')->dropDownList(\app\models\Speaker::find()->select('name')->where(['>','id',0 ])->asArray()->all()) ?>

    <?= $form->field($model, 'feedback_video')->fileInput() ?>

    <?= $form->field($model, 'status')->dropDownList(['disable' => 'Disable', 'enable' => 'Enable', 'held' => 'Held',], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitInput(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
