<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */

$this->title = Yii::t('app', 'Actualizar Evento: {name}', [
    'name' => $model->title,
]);
?>
<div class="meeting-update">

    <?= $this->render('_form_update', [
        'model' => $model,
        'modelcustomer' => $modelcustomer,
        'dataservice' => $dataservice,
        'datacustomer' => $datacustomer
    ]) ?>

</div>
