<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use wdmg\widgets\Editor;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6"> 
            <?php
                echo $form->field($model, 'price')->widget(MaskMoney::classname(), [
                    'pluginOptions' => [
                        'prefix' => '$ ',
                        'allowNegative' => false
                    ]
                ]);
            ?>
        </div>
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
