<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */

$this->title = $model->country_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('indexPage', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('indexPage', 'Update'), ['update', 'id' => $model->country_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('indexPage', 'Delete'), ['delete', 'id' => $model->country_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('indexPage', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'country_id',
            'code',
            'en',
            'seo_active',
            'is_active',
            'flag',
            'paypal',
            'credit_card',
            'multiply_to_dollar'
        ],
    ]) ?>

</div>
