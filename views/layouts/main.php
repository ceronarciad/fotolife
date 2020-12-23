<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
    type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
    type="text/javascript" charset="utf-8"></script>
    <?php $this->head() ?>
</head>
<body>
<style>

</style>

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo-navbar-white.png',
        ['alt'=>Yii::$app->name,
        'width' => '128px',
        //'height' => '64px'
        ]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
    
            !Yii::$app->user->isGuest ? (
                ['label' => 'Agenda', 'url' => ['/meeting/index']]
            ): ['label' => '', 'url' => null],

            !Yii::$app->user->isGuest ? (
                ['label' => 'Ventas', 'url' => ['/sale/index']]
            ): ['label' => '', 'url' => null],

            !Yii::$app->user->isGuest ? (
                [
                    'label' => 'Gestionar',
                    'items' => [
                        '<li class="divider"></li>',
                         ['label' => 'Servicios', 'url' => '/service/index'],
                         '<li class="divider"></li>',
                         ['label' => 'Productos', 'url' => '/product/index'],
                         '<li class="divider"></li>',
                         ['label' => 'Clientes', 'url' => '/customer/index'],
                         '<li class="divider"></li>',
                         //'<li class="dropdown-header">Dropdown Header</li>',
                    ],
                ]
            ): ['label' => '', 'url' => null],

            Yii::$app->user->isGuest ? (
                ['label' => 'Entrar', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Salir (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
                ),
        ],
    ]);
    NavBar::end();
    ?>
<br>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; FotoLife <?= date('Y') ?></p>
        <p class="pull-right">By DevProjects</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
