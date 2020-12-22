<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use kartik\icons\Icon;
use kartik\widgets\SwitchInput;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

        <?php 
        $form = ActiveForm::begin([
            'id' => 'login-form-vertical', 
            'type' => ActiveForm::TYPE_VERTICAL,
            'formConfig' => ['labelSpan' => 1, 'deviceSize' => ActiveForm::SIZE_MEDIUM]
        ]); 
        ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php
        echo $form->field($model, 'phone', [
            'addon' => ['prepend' => ['content'=>'<i class="fas fa-mobile-alt"></i>']]
        ]);
    ?>
    <?php
        echo $form->field($model, 'email', [
            'addon' => ['prepend' => ['content'=>'@']]
        ]);
    ?>

    <?php
    echo '<label class="control-label has-star" for="meeting-start">Fecha de nacimiento</label>';
    echo DatePicker::widget([
        'model' => $model, 
        'attribute' => 'birthday',
        'name' => 'birthday', 
        'value' => date('d-M-Y', strtotime('-20 years')),
        'options' => ['placeholder' => 'Elegir fecha ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
    ?>
    <br><br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
