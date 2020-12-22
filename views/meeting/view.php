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

    thead{

        background-color: #5c285d;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%236e2f64' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%2380356b' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23933c72' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23a5447a' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23b84b81' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%23a64881' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23934580' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%2380427f' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%236c3f7f' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23573c7e' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            background-size: cover;
        color: #fff;
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