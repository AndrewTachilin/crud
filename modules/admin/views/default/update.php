<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */

$this->title = Yii::t('indexPage', 'Update Countries: ' . $model->country_id, [
    'nameAttribute' => '' . $model->country_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('indexPage', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->country_id, 'url' => ['view', 'id' => $model->country_id]];
$this->params['breadcrumbs'][] = Yii::t('indexPage', 'Update');
?>
<div class="countries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
