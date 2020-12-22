<?php
    use yii\helpers\Html;
?>
<div class="row">
    <div class="col-sm-12">

        <h1>&nbsp;&nbsp;&nbsp;Pago exitoso!</h1>
            <p>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-block btn-success mr-1" onClick="refreshPage()">Continuar</button>
        </p>
        
    </div>
</div>
<script>
function refreshPage(){
    window.location.reload();
} 
</script>