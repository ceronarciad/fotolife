<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-2">
        </div>
        
        <div class="col-sm-8">
            <h4>¿Que monto desea abonar?</h4>
            <br>

            <?php
               if(!$error){
                echo $form->field($model, 'amount')->textInput(['maxlength' => true]);
               }else{
                echo "<label class='text-danger'>No se pueden agregar más pagos. El monto máximo a pagar ha sido alcanzado</label><br><br>";
               }
            ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="col-sm-2">
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
