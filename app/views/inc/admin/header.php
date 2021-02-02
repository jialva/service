<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="img/fav.png">
    <title><?=$date['titulo']?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
    <link href="fonts/icomoon/icomoon.css" rel="stylesheet">

    <link href="css/estilos.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="alertify/alertify.min.css"/>
    <link rel="stylesheet" href="alertify/default.min.css"/>

    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>pagejs/funciones.js"></script>
    <?php if(count($js)>=1){
        for ($i=0; $i < count($js); $i++) {?>
            <script src="<?=BASE_URL?>pagejs/<?=$js[$i]?>?"></script>
        <?php }
    }?>

    <script>
        var url = "<?=BASE_URL?>";
    </script>
</head>
<body>
<header>
    <a href="index-2.html" class="logo">
        <img src="img/logo.jpg" alt="Arise Admin Dashboard Logo"></a>
    <ul id="header-actions" class="clearfix">
        <li class="list-box user-admin dropdown">
            <div class="admin-details">
                <div class="name"><?=Session::get('usuario')?></div>
                <div class="designation"><?=substr(Session::get('nombre'),0,15)?></div>
            </div>
            <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="icon-account_circle"></i></a>
            <ul class="dropdown-menu sm">
                <li class="dropdown-content">
                    <!--<a href="profile.html">Edit Profile</a> 
                    <a href="forgot-pwd.html">Change Password</a> <a href="styled-inputs.html">Settings</a>--> 
                    <a href="<?=BASE_URL?>validar_usuario/salir">Salir</a>
                </li>
            </ul>
        </li>
    </ul>
</header>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=BASE_URL?>inicio"><i class="icon-blur_on"></i>Inicio</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-local_atm"></i>Facturaci&oacute;n<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASE_URL?>tipofacturacion">Actualizar Tipo Facturaci&oacute;n</a></li>
                        <li><a href="<?=BASE_URL?>promedios">Actualizar Promedios</a></li>
                        <li><a href="<?=BASE_URL?>ciclos">Actualizar Ciclos</a></li>
                        <li><a href="<?=BASE_URL?>eliminardescuentos">Eliminar descuentos desabastecimientos</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-text"></i>Lecturas<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASE_URL?>lecturas">Actualizar Lecturas</a></li>
                        <li><a href="<?=BASE_URL?>criticalectura">Cr&iacute;tica de Lecturas</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-printer"></i>Impresi&oacute;n<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASE_URL?>fechas">Actualizar fechas</a></li>
                        <li><a href="<?=BASE_URL?>rutasecuencia">Actualizar ruta de secuencia</a></li>
                        <li><a href="<?=BASE_URL?>grupoimpresion">Actualizar grupo de impresi&oacute;n</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>