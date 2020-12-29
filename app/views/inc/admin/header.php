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
        <!--<li class="list-box hidden-xs dropdown"><a id="drop2" href="#" role="button" class="dropdown-toggle"
                                                   data-toggle="dropdown"><i class="icon-warning2"></i> </a><span
                    class="info-label blue-bg">5</span>
            <ul class="dropdown-menu imp-notify">
                <li class="dropdown-header">You have 3 notifications</li>
                <li>
                    <div class="icon"><img src="img/thumbs/user10.png" alt="Arise Admin"></div>
                    <div class="details"><strong class="text-danger">Rogie King</strong> <span>Firefox is a free, open-source web browser from Mozilla.</span>
                    </div>
                </li>
                <li>
                    <div class="icon"><img src="img/thumbs/user6.png" alt="Arise Admin"></div>
                    <div class="details"><strong class="text-success">Dan Cederholm</strong> <span>IE is a free web browser from Microsoft.</span>
                    </div>
                </li>
                <li>
                    <div class="icon"><img src="img/thumbs/user1.png" alt="Arise Admin"></div>
                    <div class="details"><strong class="text-info">Justin Mezzell</strong> <span>Safari is known for its sleek design and ease of use.</span>
                    </div>
                </li>
                <li class="dropdown-footer">See all the notifications</li>
            </ul>
        </li>
        <li class="list-box hidden-xs dropdown"><a id="drop3" href="#" role="button" class="dropdown-toggle"
                                                   data-toggle="dropdown"><i class="icon-archive2"></i> </a><span
                    class="info-label red-bg">3</span>
            <ul class="dropdown-menu progress-info">
                <li class="dropdown-header">You have 7 pending tasks</li>
                <li>
                    <div class="progress-info"><strong class="text-danger">Critical</strong>
                        <span>New Dashboard Design</span> <span class="pull-right text-danger">20%</span></div>
                    <div class="progress progress-md no-margin">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                             aria-valuemin="0" aria-valuemax="100" style="width: 20%"><span class="sr-only">20% Complete (success)</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="progress-info"><strong class="text-info">Primary</strong> <span>UI Changes in V2</span>
                        <span class="pull-right">90%</span></div>
                    <div class="progress progress-sm no-margin">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="90"
                             aria-valuemin="0" aria-valuemax="100" style="width: 90%"><span
                                    class="sr-only">90% Complete</span></div>
                    </div>
                </li>
                <li>
                    <div class="progress-info"><strong class="text-warning">Urgent</strong> <span>Bug Fix #123</span>
                        <span class="pull-right">60%</span></div>
                    <div class="progress progress-xs no-margin">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                             aria-valuemin="0" aria-valuemax="100" style="width: 60%"><span class="sr-only">60% Complete (warning)</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="progress-info"><span>Bug Fix #111</span> <span
                                class="pull-right text-success">Complete</span></div>
                    <div class="progress progress-xs no-margin">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100"
                             aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete (warning)</span>
                        </div>
                    </div>
                </li>
                <li class="dropdown-footer">See all the tasks</li>
            </ul>
        </li>-->
        <li class="list-box user-admin dropdown">
            <div class="admin-details">
                <div class="name"><?=Session::get('usuario')?></div>
                <div class="designation">System Admin</div>
            </div>
            <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="icon-account_circle"></i></a>
            <ul class="dropdown-menu sm">
                <li class="dropdown-content">
                    <!--<a href="profile.html">Edit Profile</a> 
                    <a href="forgot-pwd.html">Change Password</a> <a href="styled-inputs.html">Settings</a>--> 
                    <a href="#">Salir</a>
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
                        <li><a href="<?=BASE_URL?>lecturas">Actualizar Lecturas</a></li>
                        <li><a href="<?=BASE_URL?>eliminardescuentos">Eliminar descuentos desabastecimientos</a></li>
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