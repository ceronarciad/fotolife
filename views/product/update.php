<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = Yii::t('app', 'Actualizar producto: {name}', [
    'name' => $model->title,
]);
?>
<div class="service-update">

    <div class="panel panel-default">
        <div class="panel-heading">
                <h2 class="panel-title">
                    <?= Html::encode($this->title) ?>
                </h2>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>


