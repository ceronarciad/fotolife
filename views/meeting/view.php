<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .modal {
    height: 600px; 
    margin: 0 auto; 
    }

    p{
        font-size: 15px; 
    }
    
    hr.style-two {
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
    }

    td{
        text-align:center;
        vertical-align:middle;
    }

    th{
        text-align:center;
        vertical-align:middle;
    }

</style>

<div class="meeting-view">

    <div class="row">
        <div class="jumbotron">
            <div class="container text-center">
                <h1><?php echo $model->title ?></h1>
                <p><?php echo Yii::$app->params['status'][$model->status] ?></p>
                <hr class="style-two">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="panel panel-info">
                    <div class="panel-body">
                    <h4>Datos</h4>
                    <br>
                        <p><b>Descripción:</b> <?php echo $model->description ?></p>
                        <p><b>Fecha:</b> <?php echo $model->start . " " . $model->time_init?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-danger">
                    <div class="panel-body">
                    <h4>Cliente</h4>
                    <br>
                        <i class="glyphicon glyphicon-user"> </i> &nbsp;<?php echo $modelcustomer->name ?> 
                        <br>
                        <i class="glyphicon glyphicon-envelope"> </i> &nbsp;<?php echo $modelcustomer->email ?> 
                        <br>
                        <i class="glyphicon glyphicon-phone"> </i>&nbsp; <?php echo $modelcustomer->phone ?> 
                    </div>
                </div>
            </div>
        </div>
        <?php
            \conquer\modal\ModalForm::widget([
                'selector' => '.modal-form',
            ]);
        ?>

        <div class='row'>
            <div class='col-md-12'>
                <div class='panel panel-default'>
                <br>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumen de pedido</h4>
                    <div class='panel-body'>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <td class='text-left'><strong>Nombre de servicio</strong></td>
                                        <td class='text-left'><strong>Detalle</strong></td>
                                        <td class='text-right'><strong>Precio</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $service->title; ?></td>
                                        <td class='text-left'><?php echo $service->description; ?> con una duración de <?php echo $service->working_time; ?> horas.</td>
                                        <td class='text-right'>$ <?php echo $service->price; ?></td>
                                    </tr>
                                    <tr>
                                        <td class='emptyrow'></td>
                                        <td class='emptyrow text-left'><strong>Total</strong></td>
                                        <td class='emptyrow text-right'>$ <?php echo $service->price; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                    <div class="col-sm-8">
                        <?php
                            echo 
                            Highcharts::widget([
                            'scripts' => [
                                'highcharts-pie',
                            ],
                            'options' => [
                                'credits' => ['enabled' => false],
                                'chart' => ['type' => 'pie'
                                ],
                                'plotOptions' => [ // it is important here is code for change depth and use pie as donut
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'innerSize' => 100,
                                        'depth' => 45,
                                        'showInLegend' => true
                                    ]
                                ],
                                'title' => ['text' => 'Liquidación actual'],
                                'series' => [[
                                    'type' => 'pie',
                                    'name' => 'Pago',
                                    'data' => $char,
                                    ]],
                            ]

                            ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
                    <h4><b>Historial de pagos</b></h4>
                    <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(sizeof($payment_summary)==0){
                                        echo "<tr>
                                                <td><p class='text-danger'</p></td>
                                                <td><p class='text-danger'>RESTANTE</td>
                                                <td><p class='text-danger'>$ ".$service->price."
                                                </p></td></tr>";
                                    }else{
                                        $difference = $service->price - $totalAmount;
                                        foreach ($payment_summary as $key => $value) {
                                            echo "<tr>";
                                                foreach ($value as $item) {
                                                    echo "<td>".$item."</td>";
                                                }
                                            echo "</tr>";
                                        }
                                        if($difference>0){
                                            echo "<tr><td></td><td><p class='text-danger'><b>RESTANTE<b></p></td><td><p class='text-danger'>$".$difference."</p></td></tr>";
                                        }else{
                                            echo "<tr>
                                            <td colspan=3>
                                            <p class='text-success'><b><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 
                                                &nbsp; PAGADO<b></p>
                                            </td>
                                            </tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                 </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                    <h4>Ubicación</h4>
                    <h5><?php echo $model->location; ?></h5>
                        <div style="width: auto; height: 180px" id="mapContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group btn-group-justified">
                    <a href="#" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i>Regresar</a>
                    <a href="<?php echo "/meeting/ticket?id=".$model->id; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Imprimir ticket</a>
                    <a href="<?php echo "/payment/create?id=".$ticket->id; ?>" class="btn btn-success modal-form"><i class="glyphicon glyphicon-usd"></i>
                    </a>
                </div> 
            </div> 
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        choosePlace();
    });

    function choosePlace(){

        var latitude = "<?php echo $model->latitude; ?>"
        var longitude = "<?php echo $model->longitude; ?>"
        var address = "<?php echo $model->location; ?>"

        var platform = new H.service.Platform({
        'apikey': 'POODzP5bCT1UlFq0aEvMHWAs1PX0QHE539FeGjkTs8k'
        });

        var defaultLayers = platform.createDefaultLayers();

        var map = new H.Map(
            document.getElementById('mapContainer'),
            defaultLayers.vector.normal.map,
            {
            zoom: 15,
            center: { lat: latitude, lng: longitude}
            });
    }

</script>