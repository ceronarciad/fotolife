<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">
    
    <div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <h2><?= Html::encode($this->title) ?>
                    &nbsp;
                        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', '¿Desea eliminar este elemento?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </h2>
                </div>
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Correo electrónico</th>
                                    <th>Fecha de nacimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $model->name ?></td>
                                    <td><?php echo $model->phone ?></td>
                                    <td><?php echo $model->email ?></td>
                                    <td><?php echo ($model->birthday == '') ? '<p style="color:red">No registrada</p>': $model->birthday ?></td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
