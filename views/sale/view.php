<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $ticket->id;
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
                    <h2>Ticket <?= Html::encode($this->title) ?></h2>
                    <hr>
                    <h4>Detalle de venta</h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                        
                        <table class="table table-condensed table-hover">
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
                        </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</div>
