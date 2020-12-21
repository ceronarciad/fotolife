<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\icons\FontAwesomeAsset;
use kartik\grid\GridView;
use lo\widgets\modal\ModalAjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MeetingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Agenda');
?>

<style>
    
</style>

<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>
<div class="meeting-index">


<?php Pjax::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                <h3>Agenda de eventos
                    
                    <?php

                        //echo ModalAjax::widget([
                            //'id' => 'create',
                            //'header' => 'Agendar evento',
                            //'toggleButton' => [
                            //    'label' => 'Agendar nuevo evento',
                            //    'class' => 'btn btn-primary pull-right'
                            //],
                            //'url' => Url::to(['/meeting/create']), 
                            //'ajaxSubmit' => true, 
                            //'size' => ModalAjax::SIZE_LARGE,
                            //'options' => ['class' => 'header-primary'],
                            //'autoClose' => true,
                            //'pjaxContainer' => '#grid-company-pjax',
                        //]);

                    ?>&nbsp;
                     <?= Html::a(Yii::t('app', 'Agendar evento'), ['create'], ['class' => 'btn btn-primary'])?>
                </h3>
                <br><br>
                    <?= edofre\fullcalendar\Fullcalendar::widget([
                            'events' => $events,
                            'options'       => [ 
                                'id'       => 'calendar',
                                'language' => 'es',
                            ],
                            'clientOptions' => [
                                'selectable'  => true,
                                'defaultView' => 'month',     
                                'contentHeight' => 400,
                            ],
                        ]);
                    ?>
                </div>
                <div class="col-sm-12">
                <br>
                    <h3>Tabla de datos</h3>
                    <br>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'title',
                            'start',
                            'time_init',
                            [
                                'attribute' => 'status', 
                                'value' => function ($model, $key, $index, $widget) { 
                                    return Yii::$app->params['status'][$model->status];
                                },
                                'filter' => Yii::$app->params['status'], 
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Seleccionar filtro'],
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>

</div>

<script>
    $(document).ready(function() {
        
    });
</script>