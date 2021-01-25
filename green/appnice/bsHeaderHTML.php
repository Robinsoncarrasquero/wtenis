<!--

Programa para manejar el HLML comun de incio de la pagina

-->

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta title="Sistema de Tenis de Campo">
        <meta description="Sistema de Gestion de Tenis">
        <meta keywords="IPIN,Tenis,G1,G2,G3,G4,G5,ITF,Sistema,Tenis,Inscripciones, OnLine, on line, Draw, Ranking, Pagos, Afiliacion, Afiliaciones, Asociaciones,Estadales,Regionales, Deporte, Zonales, zonales">
  <!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
  <link rel="stylesheet" href="Normalize.css">
        <link rel="stylesheet" href="css/tenis_estilos.css">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
           
    </head>
    <style>
        
        .loader{

            background-image: url("images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }
        nav.navbar {
            background-color:    #000;
        }
        .jumbotron{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        iframe{
            width: 100%;
        }
                // Use as-is
        
       
    </style>
<body>

