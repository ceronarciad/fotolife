<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */
?>
<div class="meeting-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelcustomer' => $modelcustomer,
        'dataservice' => $dataservice,
        'datacustomer' => $datacustomer
    ]) ?>

</div>
