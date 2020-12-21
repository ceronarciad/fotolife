<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <h4 class="text-primary">Agrege los articulos que desea incluir en la compra</h4>
    <br>
    
    <div class="row">
        <div class="col-sm-6">
            <?php
                echo '<label class="control-label">Porductos</label>';
                echo Select2::widget([
                    'name' => 'product_list',
                    'id' => 'product_list',
                    'data' => $products,
                    'size' => Select2::MEDIUM,
                    'options' => ['placeholder' => 'Seleccionar productos ...', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
            <br>
        </div>
        <div class="col-sm-6">
        </div>
        <div class="col-sm-12"> 
            
            <input type="text" id="as">

            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">Resumen de compra</h3>
                  </div>
                  <div class="panel-body">
                        
                        <table class="table table-condensed table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyid">
                            </tbody>
                        </table>
                        
                  </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <script>

        // function delete_item(id)
        // {
        //     var ids = id.split("_");
        //     $('#row_'+ids[2]).empty();///ids[2]
        // 

        $(document).ready(function () {  

            $(":input").bind('keyup mouseup', function () {
                alert("changed");            
            });

            $("input").change(function(){
                console.log("The text has been changed.");
            }); 

            var products = [];
            var productString = '';
            var deleteItem = document.getElementById('s2-togall-product_list');
            
            padre = deleteItem.parentNode;
            padre.removeChild(deleteItem);
            
            $('#product_list').on('select2:select', function (e) {
                var add_id = e.params.data.id;
                products.push(add_id);
                productString = '';
                product_length = products.length;
                product_count = 0;

                products.forEach(element => {
                    product_count++;
                    if(product_length == product_count){
                        productString = productString + element;
                    }else{
                        productString = productString + element + ",";
                    }
                });
                
                renderTable(productString);
            });

            $('#product_list').on('select2:unselecting', function (e) {
                var remove_id = e.params.args.data.id;
                const index = products.indexOf(remove_id);
                
                if (index > -1) {
                    products.splice(index, 1);
                }

                productString = '';
                product_length = products.length;
                product_count = 0;

                products.forEach(element => {
                    product_count++;
                    if(product_length == product_count){
                        productString = productString + element;
                    }else{
                        productString = productString + element + ",";
                    }
                });
                renderTable(productString);
            });  
            
            $('#product_list').on('select2:clear', function (e) {
                products = [];
                productString = '';
                renderTable(productString);
            });

            function renderTable(str) {
                $.ajax({
                    type: "POST",
                        url: "<?php echo Yii::$app->getUrlManager()->createUrl('sale/table')  ; ?>",
                        data: {str: str},
                        success: function (str) {
                            var counterStrike = 0;
                            var count = Object.keys(str).length;

                            if(count >= 1){
                                str.forEach(element => {
                                    if(element === null || element == undefined){
                                        $('#myTable tbody').empty();
                                    }else{
                                        counterStrike++;
                                        $('#myTable').find('tbody').append(
                                            "<tr id='row_"+counterStrike+"'><td id='col_index"+counterStrike+"'>"+counterStrike+"</td>"+
                                            "<td id='row_name_"+counterStrike+"'>"+element['name']+"</td>"+
                                            "<td id='row_description_"+counterStrike+"'>"+element['description']+"</td>"+
                                            "<td id='row_price_"+counterStrike+"'>$"+element['price']+"</td>"+
                                            "<td id='row_quantity_"+counterStrike+"'><input type='number' id='input_quantity_"+counterStrike+"' name='input_quantity_"+counterStrike+"'  min='1' max='20' value='1'></td>"+
                                            "<td id='row_subtotal_"+counterStrike+"'><input type='text' id='input_subtotal_"+counterStrike+"' name='input_subtotal_"+counterStrike+"' value='"+element['price']+"'  ></td>"+
                                            "</tr>");
                                            //"<td id='row_delete_"+counterStrike+"'><button id='button_delete_"+counterStrike+"' type='button' class='close' aria-label='Close' onClick='delete_item(this.id)'><span aria-hidden='true'>&times;</span></button></td>"+                                    
                                    }
                                });
                            }
                            
                        },
                        error: function (exception) {
                            console.log(exception);
                        }
                });
            }

        });
    </script>

</div>




public function actionTable(){
        $data = Yii::$app->request->post('str');
        $array = explode(",", $data);
        $response = [];

        foreach ($array as $key => $value) {
            $product = Product::find()->where(['id' => $value])->one();
            array_push($response, $product);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }