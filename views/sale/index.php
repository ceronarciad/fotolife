<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ventas');
?>
<div class="service-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3><?= Html::encode($this->title) ?> &nbsp;
                        <?= Html::a(Yii::t('app', 'Nueva venta'), ['create'], ['class' => 'btn btn-primary'])?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'total',
                            'date_ticket',
                            //'id_customer',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'delete' => function($url, $model){
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                            'class' => '',
                                            'data' => [
                                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    }
                                ]
                            ], 
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>      
        </div>
    </div>
</div>
