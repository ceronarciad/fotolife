<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = Yii::t('app', 'Crear venta');
?>

<div class="service-create">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">
                <?= Html::encode($this->title) ?>
            </h2>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'products' => $products
            ]) ?>
        </div>
    </div>
    
</div>
