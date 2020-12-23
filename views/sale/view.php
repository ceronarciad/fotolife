<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use miloschuman\highcharts\Highcharts;

$this->title = 'Venta '.$ticket->id;
\yii\web\YiiAsset::register($this);
?>

<style>
    .modal {
        height: 600px; 
        margin: 0 auto; 
    }

</style>

<div class="sale-view">

        <?php
            \conquer\modal\ModalForm::widget([
                'selector' => '.modal-form',
            ]);
        ?>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Ticket de <?= Html::encode($this->title) ?></h2>
                    <hr>
                    <h4>Detalle de venta</h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                        <table class="table table-condensed table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($ticketDetails as $key => $value) {
                                            echo "<tr>";
                                            $counter = 0;
                                                    foreach ($value as $item) {
                                                        $counter ++;
                                                        echo "<td>";
                                                        echo ($counter == 3 || $counter == 4) ? '$': '';
                                                        echo $item;
                                                        echo "</td>";
                                                    }
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total</b></td>
                                        <td><?php echo $ticket->total; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Cliente</h4>
                            <p>
                                <?php 
                                    echo (IS_NULL($modelcustomer)) ? "Venta al mostrador" : $modelcustomer->name;
                                ?>
                            </p>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Pagos</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-info">
                                                            <div class="panel-body">
                                                                <div class="col-sm-8">
                                                                    <?php
                                                                        echo Highcharts::widget([
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
                                                                                                $difference = $ticket->total - $totalAmount;
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
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="btn-group btn-group-justified">
                                        <a href="../sale/index" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i>Regresar</a>
                                        <a href="<?php echo "/sale/ticket?id=".$ticket->id; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Imprimir ticket</a>
                                        <a href="<?php echo "/payment/create?id=".$ticket->id; ?>" class="btn btn-success modal-form"><i class="glyphicon glyphicon-usd"></i>
                                        </a>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
