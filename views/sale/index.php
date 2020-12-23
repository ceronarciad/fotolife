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
                            [
                                'label' => 'Cliente',
                                'value' => function ($model) {
                                    $customer = $model::getCustomerName($model->id_customer);
                                    return(!IS_NULL($customer)) ? $customer->name :'Sin cliente';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                            ], 
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>      
        </div>
    </div>
</div>
