<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sweet Alert con jQuery</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Scroll Menu -->
    <link href="css/sweetalert.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom functions file -->
    <script src="js/functions.js"></script>
    <!-- Sweet Alert Script -->
    <script src="js/sweetalert.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <!-- NAV BAR -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-inner">
        <div class="container">
          <p class="navbar-text navbar-left nombre-plugin">Sweet Alert con jQuery</p>
          <p class="navbar-text navbar-left link-post"><a href="http://blog.endeos.com/notificaciones-al-usuario-con-jquery-sweet-alert/" class="navbar-link">Volver al artículo</a></p>
        </div>
      </div>
    </nav>
    <!-- /NAV BAR -->




    <!-- MAIN CONTENT -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <!-- the content -->

          <div class="row demo">
            <div class="codigo col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <span>Declara la variable GET <i>condicion</i> con valor <i>php</i> poniendo al final de la URL "?condicion=php"</span>
            </div>
          </div>

          <?php 
            if ( isset($_GET["condicion"]) && $_GET["condicion"] == "php" ) {
              echo "<script>jQuery(function(){swal(\"¡Bien!\", \"Condición cumplida\", \"success\");});</script>";
            }
          ?>



        </div>
      </div>
    </div>
    <!-- /MAIN CONTENT -->

  </body>
</html>