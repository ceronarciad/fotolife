<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
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
                                        <th>Descripción</th>
                                        <th>Duración</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $model->title ?></td>
                                        <td><?php echo $model->description ?></td>
                                        <td><?php echo $model->working_time ?></td>
                                        <td>$ <?php echo $model->price ?></td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
