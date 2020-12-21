<?php

/* @var $this yii\web\View */

$this->title = 'FotoLife';
?>
<div class="site-index">
<?php 
$array = array(
    "La mayor debilidad de una persona es rendirse. La manera más segura de tener suerte es intentar una vez más.",
    "Da siempre lo mejor. Cosecharás lo que siembras",
    "Conviértete en la persona que atraiga los resultados que buscas",
    "No mires el reloj. Imita lo que hace: nunca te detengas",
    "Todo lo que alguna vez deseaste está del otro lado del miedo",
    "El secreto de avanzar es comenzar",
    "El buen rendimiento comienza con una actitud positiva",
    "¿Quieres saber quién eres? No preguntes. Actúa. Las acciones te definirán",
    "Establecer objetivos es el primer paso para convertir lo invisible en visible",
    "Cuanto más difícil sea el conflicto, más glorioso será el triunfo",
    "Pastoreamos a las ovejas, dirigimos al ganado, lideramos a las personas. Lidérame, sígueme o quítate de mi camino",
    "La motivación casi siempre superará al mero talento",
    "Cambia antes de que debas hacerlo",
    "Los seres humanos tenemos un deseo innato de ser independientes y autónomos, y estar conectados con los demás. Y cuando ese deseo se libera, logramos más objetivos y vivimos vidas más ricas",
    "Atribuyo mi éxito a que nunca di ni acepté una excusa",
    "Tu actitud, no tu aptitud, determinará tu altitud",
    "Bien hecho es mejor que bien dicho",
    "Errarás el 100% de los disparos que no realices",
    "Siempre hay lugar en la cima",
    "No se trata solo de tener las oportunidades correctas, sino de aprovecharlas",
    "Un objetivo es un sueño con una fecha límite",
    "Si te ofrecen un asiento en un cohete, no preguntes qué asiento. Solo súbete",
    "Las personas extraordinarias tienen una cosa en común: un sentido de misión absoluto",
    "Si caes siete veces, levántate ocho",
    "Nunca podrás vencer a una persona que no se rinde",
    "Hagas lo que hagas, hazlo bien",
    "La suerte favorece a los valientes",
    "El éxito nunca es definitivo y los errores nunca son fatales. Lo que cuenta es el coraje",
    "Nunca es demasiado tarde para ser la persona que podrías haber sido",
    "El mejor guerrero es el hombre promedio con un enfoque extraordinario"
);
?>
    <div class="jumbotron">
        <h1>¡Bienvenido!</h1>
        <h2>
        <?php
            echo $array[rand(0,29)];
            echo "<br><br>";
            echo "<img src='../images/heros/".rand(1,30).".svg' alt='RECORDAR ES VOLVER A VIVIR' width='20%'>";
        ?>
        </h2>
        <br>
        <p><a class="btn btn-lg btn-info" href="../site/login">Comenzar</a></p>
    </div>

    <div class="body-content">

        <!-- <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div> -->

    </div>
</div>
