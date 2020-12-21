<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\TimePicker;
use wdmg\widgets\Editor;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?php
                echo '<label class="control-label has-star" for="event-working_time">Duración</label>';
                echo TimePicker::widget([
                    'model' => $model, 
                    'attribute' => 'working_time',
                    'name' => 'working_time', 
                    'pluginOptions' => [
                        'minuteStep' => 1,
                        'showSeconds' => true,
                        'showMeridian' => false
                    ]
                ]);
            ?>
        </div>
        <div class="col-sm-3">
            <?php
                echo $form->field($model, 'price')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => '$ ',
                        'allowNegative' => false
                    ]
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
                echo $form->field($model, 'description')->widget(Editor::class, [
                    'options' => [
                    ],
                    'pluginOptions' => [
                    ]
                ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
