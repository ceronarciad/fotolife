<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MeetingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meeting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'start') ?>

    <?= $form->field($model, 'time_init') ?>

    <?php
        echo '<label class="control-label">Estatus</label>';
        echo Select2::widget([
            'model' => $model,
            'attribute' => 'status',
            'data' => Yii::$app->params['status'],
            'options' => ['placeholder' => 'Elegir una opción...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    <br>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Limpiar'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
