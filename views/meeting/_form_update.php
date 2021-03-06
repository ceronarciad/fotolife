<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use kartik\icons\Icon;
use kartik\spinner\Spinner;

//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
    textarea {
        resize: none;
    }

    .spinner{
        position: absolute;
        width: 0px;
        z-index: 2000000000;
        left: 50%;
        top: 500% !important;
    }

</style>

<div class="panel panel-default">
      <div class="panel-heading">
            <h2 class="panel-title"><?php echo $model->title; ?> </h2>
      </div>
      <div class="panel-body">
                <?php 
                    use kartik\form\ActiveForm; // or kartik\widgets\ActiveForm
                    $form = ActiveForm::begin([
                        'id' => 'login-form-vertical', 
                        'type' => ActiveForm::TYPE_VERTICAL,
                        'formConfig' => ['labelSpan' => 1, 'deviceSize' => ActiveForm::SIZE_MEDIUM]
                    ]); 
                ?>
                    <div class="row">
                        <div class="col-sm-9">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                            </div>
                            
                            <div class="col-sm-3">
                            <?php
                                    echo '<label class="control-label">Estatus</label>';
                                    echo Select2::widget([
                                        'model' => $model,
                                        'attribute' => 'status',
                                        'data' => Yii::$app->params['status'],
                                        'options' => ['placeholder' => 'Elegir una opción...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                            echo '<label class="control-label has-star" for="meeting-start">Fecha</label>';
                            echo DatePicker::widget([
                                'model' => $model, 
                                'attribute' => 'start',
                                'language' => 'es',
                                'name' => 'start', 
                                'value' => date('d-M-Y', strtotime('+2 days')),
                                'options' => ['placeholder' => 'Elegir fecha ...'],
                                'pluginOptions' => [
                                    'orientation' => 'bottom left',
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                                echo '<label class="control-label has-star" for="meeting-time_init">Hora</label>';
                                echo TimePicker::widget([
                                    'model' => $model, 
                                    'attribute' => 'time_init',
                                    'name' => 'event-time', 
                                    'pluginOptions' => [
                                        'minuteStep' => 1,
                                        'showSeconds' => true,
                                        'showMeridian' => false
                                    ]
                                ]);
                            ?>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'description')->textarea(['rows' => 9]) ?> 
                        </div>
                    </div>
     
                    <div class="row">    
                        <div class="col-sm-12">
                            <?php echo '<label class="control-label">Ubicación</label><br>'; ?>
            
                                <div class="input-group">
                                    <input type="text" class="form-control" autocomplete="off" name="meeting-location-text" id="meeting-location-text" placeholder="Escribe un lugar...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="findLocation()">Buscar!</button>
                                    </span>
                                </div>

                            <?php echo $form->field($model, 'location')->hiddenInput()->label(false); ?>
                            <?php echo $form->field($model, 'latitude')->hiddenInput()->label(false); ?>
                            <?php echo $form->field($model, 'longitude')->hiddenInput()->label(false);?>
                                                       
                            <select name="meeting-places" id="meeting-places">
                                <option value="0" selected="selected">Seleccionar un lugar</option>
                            </select>
                            <?php
                                echo '<div class="border border-secondary p-3 rounded" id="spinner">';
                                echo Spinner::widget(['preset' => 'large', 'align' => 'center']);
                                echo '<div class="clearfix"></div>';
                                echo '</div>';
                            ?>
                            <div style="width: auto; height: 180px; border-style: dotted;" id="mapContainer"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-6">
                            <p class="h4">Datos de cliente</p>
                            <br>
                                <?php
                                    echo '<label class="control-label">Clientes</label>';
                                    echo Select2::widget([
                                        'model' => $modelcustomer,
                                        'attribute' => 'id',
                                        'data' => $datacustomer,
                                        'options' => [
                                            'placeholder' => 'Elegir una opción...',
                                            'class' => 'form-control',
                                            'disabled' => true
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                ?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <p class="h4">Datos de servicio</p>

                            <div class="row">
                                <div class="col-sm-12">
                                <br>
                                <?php
                                        echo '<label class="control-label">Servicio</label>';
                                        echo Select2::widget([
                                            'model' => $model,
                                            'attribute' => 'id_service',
                                            'data' => $dataservice,
                                            'options' => [
                                                'placeholder' => 'Elegir una opción...',
                                                'class' => 'form-control',
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ]);
                                ?>
                                </div>
                            </div>
                            <div class="row">
                            <br><br>
                            <div class="col-sm-12">
                                <h4>
                                    <div id="demo-title">
                                    </div>
                                </h4>
                            </div>
                            <div class="col-sm-12">
                                <?php 
                                    echo "<div id='demo-description'>
                                    </div>";
                                ?>
                            </div>
                            <div class="col-sm-12">
                                <?php 
                                    echo "<br><div id='demo-working_time'>
                                    </div>";
                                ?>
                            </div>
                            <div class="col-sm-12">
                                <b>
                                    <div id="demo-price">
                                    </div>
                                </b>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <?= Html::submitButton('Guardar', ['id' => 'button-save','class' => 'btn btn-success mr-1']) ?>
                            <?= Html::resetButton('Limpiar', ['class' => 'btn btn-secondary']) ?>
                        </div>
                    </div>

            <script>
                    $(document).ready(function () {
                        
                        var responseJson = null;
                        var str = $("#meeting-id_service").val();

                        choosePlaceDefault();
                        var locationDefault = "<?php echo $model->location; ?>"
                        $("#meeting-location-text").attr("placeholder", locationDefault);
                        //$( "#meeting-location-text").val(locationDefault);                    
                        
                        $("#button-save").hide();
                        $("#spinner").hide();

                        $("input").change(function(e){
                            validation();
                        }); 

                        $('#meeting-status').on('select2:select', function (e) {
                            validation();
                        });

                        $('#meeting-id_service').on('select2:select', function (e) {
                            validation();
                        });
            
                        $('#customer-id').on('select2:select', function (e) {
                            validation();
                            $("#customer-name").val('');
                            $("#customer-phone").val('');
                            $("#customer-email").val('');
                        });

                        $('#meeting-status').on('select2:clear', function (e) {
                            validation();
                        });

                        $('#meeting-id_service').on('select2:clear', function (e) {
                            validation();

                        });
            
                        $('#customer-id').on('select2:clear', function (e) {
                            validation();
                        });
            
                        
                        function validation(){
                            var meeting_title = $("#meeting-title").val();
                            var meeting_start = $("#meeting-start").val();
                            var meeting_description = $("#meeting-description").val();
                            var meeting_time_init = $("#meeting-time_init").val();
                            var meeting_location_text = $("#meeting-location-text").val();
                            var meeting_id_service = (parseInt($("#meeting-id_service").val()) > 0) ? parseInt($("#meeting-id_service").val()): 0;
                            var meeting_status = (parseInt($("#meeting-status").val()) > 0) ? parseInt($("#meeting-status").val()) : 0;
                            var customer_id = (parseInt($("#customer-id").val()) > 0) ? parseInt($("#customer-id").val()) : 0;

                            if (customer_id > 0 && meeting_title.length > 0 && meeting_start.length > 0 && meeting_time_init.length > 0 && meeting_id_service > 0 && meeting_status > 0) {
                                $("#button-save").show();
                            }else{
                                $("#button-save").hide();
                            }
                            
                            
                        }
                        
                        $("#meeting-places").hide();
                        $('#meeting-id_service').on('select2:select', function (e) {
                            var str = e.params.data.id;
                            $.ajax({
                                type: "POST",
                                    url: "<?php echo Yii::$app->getUrlManager()->createUrl('meeting/service')  ; ?>",
                                    data: {str: str},
                                    success: function (str) {
                                        $( "#demo-title" ).text(str.title);
                                        $( "#demo-description" ).html(str.description);
                                        $( "#demo-price" ).text("$"+str.price);
                                        $( "#demo-working_time" ).text("Duración máxima de hasta "+str.working_time+" horas.");
                                    },
                                    error: function (exception) {
                                        console.log(exception);
                                    }
                            });
                        });                      

                    });

                    function findLocation() {
                            var str = $("#meeting-location-text").val();
                            $("#spinner").show();

                            if(str.length >= 10){
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo Yii::$app->getUrlManager()->createUrl('meeting/ajax')  ; ?>",
                                    data: {str: str},
                                    success: function (str) {   
                                        var n = str.indexOf("Response");
                                        var m = str.length;
                                        var jsonString = str.substring(n-2, m); 
                                        responseJson = $.parseJSON(jsonString);
                                        var countPosition = responseJson.Response.View[0].Result.length;
                                        var myCount = 0;
                                        document.getElementById("mapContainer").innerHTML = '';

                                        if(countPosition > 0){
                                            $("#meeting-places").show();
                                            $('#meeting-places').empty().append('<option>Seleccionar opción</option>');

                                            responseJson.Response.View[0].Result.forEach(element => {
                                                var label = element.Location.Address.Label;
                                                $('#meeting-places').append(`<option value="${myCount}" onclick="choosePlace(${myCount})">${label}</option>`);
                                                myCount = myCount + 1;
                                            });

                                            $("#spinner").hide();
                                            
                                        }else{
                                            $("#meeting-places").hide();
                                            $("#spinner").hide();
                                        }

                                    },
                                    error: function (exception) {
                                        console.log(exception);
                                    $("#spinner").hide();
                                    }
                                });
                            }else{
                                $("#meeting-places").hide();
                                $("#spinner").hide();
                            }
                    }

                    function choosePlace(position){

                            document.getElementById("mapContainer").innerHTML = '';

                            var latitude = responseJson.Response.View[0].Result[0].Location.DisplayPosition.Latitude;
                            var longitude = responseJson.Response.View[0].Result[0].Location.DisplayPosition.Longitude;
                            var address = responseJson.Response.View[0].Result[0].Location.Address.Label;
                            
                            $('#meeting-latitude').val(latitude);
                            $('#meeting-longitude').val(longitude);
                            $('#meeting-location').val(address);
                            
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

                    function choosePlaceDefault(){

                        document.getElementById("mapContainer").innerHTML = '';

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

        <?php ActiveForm::end(); ?>
        
    </div>
</div>
