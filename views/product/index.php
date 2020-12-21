<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Producto');
?>
<div class="service-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3><?= Html::encode($this->title) ?> &nbsp;
                        <?= Html::a(Yii::t('app', 'Nuevo producto'), ['create'], ['class' => 'btn btn-primary'])?>
                    </h3>
<br>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            array(   
                'header' => 'Description',  
                'attribute' => 'description',    
                'format' => 'raw',
                'value' => 'description',
            ),
            'price',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
            </div>
        </div>
    </div>
    
</div>
