<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'en')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'multiply_to_dollar')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'paypal')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'credit_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_active')->textInput() ?>

    <?= $form->field($model, 'is_active')->dropDownList([ 'true' => 'True', 'false' => "False"], ['prompt' => '']) ?>

    <?=
     \kartik\file\FileInput::widget([
        'model' => $model,
        'attribute' => 'flag',
        'name' => 'flag',
        'id' => 'registration-user-photo-front',
        'options' => [
        'multiple' => false,
        'accept' => 'image/*',
        ],
        'pluginOptions' => [
        'showUpload' => true,
        'initialPreview' => ($model->flag) ? [
        Html::img($model->flag, ['width' => 50, 'maxHeight' => 50, 'id' => 'fl-upld__inp', 'class' => "upload-photo__item circle"] )
        ] : false,
        'initialCaption' => (!$model->flag) ? "Select photo ..." : null,
        'overwriteInitial' => true,
        'showRemove' => false,
        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'],
        'browseLabel' => 'Select'
        ]
     ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('indexPage', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
