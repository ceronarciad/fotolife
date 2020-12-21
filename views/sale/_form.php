<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
<style>
    td{
        text-align:center;
        vertical-align:middle;
    }

    th{
        text-align:center;
        vertical-align:middle;
    }

</style>


    <?php $form = ActiveForm::begin(); ?>

    <h4 class="text-primary">Agrege los articulos que desea incluir en la compra</h4>
    <br>
    
    <div class="row">

        <div class="col-sm-12"> 

            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h4 class="panel-title">Resumen de compra
                        &nbsp;
                        <button id="shownextrow" type="button" class="btn btn-info btn-xs" aria-label="Left Align">
                            <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        </h4>
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
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyid">
                                <?php
                                    for ($i=1; $i <= 5 ; $i++) {
                                        echo "<tr id=row_$i><td>".$i."</td><td id='col_name_'>";

                                        echo Select2::widget([
                                                'name' => 'select_product_id_'.$i,
                                                'id' => 'select_product_id_'.$i,
                                                'data' => $products,
                                                'size' => Select2::MEDIUM,
                                                'options' => ['placeholder' => 'Seleccionar producto...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                            
                                        echo "</td>
                                            <td id='col_description_'><p id=description_$i>NA</p></td>
                                            <td id='col_price_'> <input size='8' type='text' id=price_$i readonly value='' > </p></td>
                                            <td id='col_quantity_'>
                                                <input size='4' type='number' id=input_quantity_$i name=input_quantity_$i min='1' max='50' value='' readonly>
                                            </td>
                                            <td id='col_subtotal_'>
                                                <input size='12' type='text' id=input_subtotal_$i name=input_subtotal_$i value='' readonly>
                                            </td>
                                            <td>
                                            <button id='hiddenrow_$i' type='button' class='btn btn-warning btn-xs' aria-label='Left Align'>
                                                <span class='glyphicon glyphicon glyphicon-remove' aria-hidden='true'></span>
                                            </button>
                                            </td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                            <tfoot id="tfootid">
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td><input size='12' type='text' id='total' name='total' value='' readonly></td>
                                <td></td>
                                </tr>
                                
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total a pagar</td>
                                <td><input size='12' type='text' id='total_payment' name='total_payment' value='' readonly></td>
                                <td></td>
                                </tr>
                                
                            </tfoot>
                        </table>
                        
                  </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Guardar'), ['id' => 'boton-save','class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <script>

        $(document).ready(function () {
            countRow = 1;
            var jsonStr = '{"products":[]}';
            var obj = JSON.parse(jsonStr);
            //jsonStr = JSON.stringify(obj);

            jQuery.fn.ForceNumericOnly =
            function()
            {
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
                        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                        // home, end, period, and numpad decimal
                        return (
                            key == 8 || 
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 110 ||
                            key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };
                        
            $('#row_2').hide();
            $('#row_3').hide();
            $('#row_4').hide();
            $('#row_5').hide();
            $("#input_quantity_1").ForceNumericOnly();

            $("#boton-save").hide();
            
            $("input").change(function(e){
                const id = e.currentTarget.attributes.id.nodeValue;
                var id_number = id.split("_");
                var quantity = $("#input_quantity_"+id_number[2]).val();
                var price = $("#price_"+id_number[2]).val(); 
                var product_id = $("#select_product_id_"+id_number[2]).val();
                $( "#input_subtotal_"+id_number[2]).val(quantity*price);
                totalear();
                addProduct(product_id, quantity);
            }); 

            function addProduct(id, quantity){
                var update = false;
                var index = 0

                var response = obj.products.find(function(item, i){
                    if(item.id === id){
                        update = true;
                        index = i;
                    }
                });

                if(update){
                   obj['products'][index]['quantity'] = quantity;
                }else{
                   obj['products'].push({"id": id,"quantity":quantity});
                }

                //console.log(obj);
            }
            

            function removeProduct(id){

                var response = obj.products.find(function(item, i){
                    if(item.id === id){
                        console.log("eliminar posicion", i);
                        obj.products.splice(i, i+1);   
                    }
                });

                //console.log(obj);
            }
            
            $("#shownextrow").click(function(e){
                if(countRow < 5){
                    countRow++;
                    $('#row_'+countRow).show();
                }
            });

            $('#hiddenrow_1').click(function(e){
                clearRow(1);
                $('#row_1').hide();
                $('#select_product_id_1').val(null).trigger('change');
            });
            
            $('#hiddenrow_2').click(function(e){
                clearRow(2);
                $('#row_2').hide();
                $('#select_product_id_2').val(null).trigger('change');
            });
            
            $('#hiddenrow_3').click(function(e){
                clearRow(3);
                $('#row_3').hide();
                $('#select_product_id_3').val(null).trigger('change');
            });

            $('#hiddenrow_4').click(function(e){
                clearRow(4);
                $('#row_4').hide();
                $('#select_product_id_4').val(null).trigger('change');
            });

            $('#hiddenrow_5').click(function(e){
                clearRow(5);
                $('#row_5').hide();
                $('#select_product_id_5').val(null).trigger('change');
            });
            
            $('#select_product_id_1').on('select2:select', function (e) {
                recoveryItem(e.params.data.id, 1);
            });

            $('#select_product_id_2').on('select2:select', function (e) {
                recoveryItem(e.params.data.id, 2);
            });

            $('#select_product_id_3').on('select2:select', function (e) {
                recoveryItem(e.params.data.id, 3);
            });
            
            $('#select_product_id_4').on('select2:select', function (e) {
                recoveryItem(e.params.data.id, 4);
            });
            
            $('#select_product_id_5').on('select2:select', function (e) {
                recoveryItem(e.params.data.id, 5);
            });
            
            $('#select_product_id_1').on('select2:clear', function (e) {
                clearRow(1);
            });
                        
            $('#select_product_id_2').on('select2:clear', function (e) {
                clearRow(2);
            });
                        
            $('#select_product_id_3').on('select2:clear', function (e) {
                clearRow(3);
            });
                        
            $('#select_product_id_4').on('select2:clear', function (e) {
                clearRow(4);
            });
                        
            $('#select_product_id_5').on('select2:clear', function (e) {
                clearRow(5);
            });

            function clearRow(position){
                countRow--;
                $( "#description_"+position).text('NA');
                $( "#price_"+position).val('');
                $( "#input_quantity_"+position).prop('readonly', true);
                $( "#input_quantity_"+position).val('');
                $( "#input_subtotal_"+position).val('');
                id = $('#select_product_id_'+position).val();
                totalear();
                removeProduct(id);
            }

            function recoveryItem(str,position) {
                const id = str;
                $.ajax({
                    type: "POST",
                        url: "<?php echo Yii::$app->getUrlManager()->createUrl('sale/item')  ; ?>",
                        data: {str: str},
                        success: function (str) {
                            $( "#description_"+position).text(str.description);
                            $( "#price_"+position).val(str.price);
                            $( "#input_quantity_"+position).prop('readonly', false);
                            $( "#input_quantity_"+position).val(1);
                            $( "#input_subtotal_"+position).val(1*str.price);
                            totalear();
                            addProduct(id, '1');
                        },
                        error: function (exception) {
                            console.log(exception);
                        }
                });
            }

            function totalear(){
                var total = 0;

                for (let index = 1; index < 6; index++) {
                    const element = index;
                    subtotal = $("#input_subtotal_"+element).val();
 
                    if (subtotal) {
                        total = total + parseInt(subtotal);
                    }
                }

                $( "#total").val(total);
                
                if(total > 0){
                    $( "#total_payment").prop('readonly', false);
                }else{
                    $( "#total_payment").prop('readonly', true);
                }

               var total_payment = $( "#total_payment").val();
                
                if(total_payment > 0){
                    $("#boton-save").show();
                }else{
                    $("#boton-save").hide();
                }
            }

        });

    </script>

</div>