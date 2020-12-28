<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="img/fav.png">
    <title><?=$date['titulo']?></title>
    <link href="css/login.css" rel="stylesheet" media="screen">
    <link href="css/animate.css" rel="stylesheet" media="screen">
    <link href="fonts/icomoon/icomoon.css" rel="stylesheet">
    <link rel="stylesheet" href="alertify/alertify.min.css"/>
    <link rel="stylesheet" href="alertify/default.min.css"/>

    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>pagejs/funciones.js"></script>

    <?php if(count($js)>=1){
        for ($i=0; $i < count($js); $i++) {?>
            <script src="<?=BASE_URL?>pagejs/<?=$js[$i]?>"></script>
        <?php }
    }?>

    <script>
        var url = "<?=BASE_URL?>";
    </script>
</head>
<body>