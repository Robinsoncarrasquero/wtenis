<?php

//header('Content-Type: text/html; charset=utf-8');

echo "<header>";
     
/*
 <!--    <div class="alert alert-danger alert-server" role="alert">
 
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Moving Servers</strong>Update finish in the new server. This move should be finished on 12/2019.
</div>-->
 
 */
    echo 
    '<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container-fluid">';
        echo '<div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-menu-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>';
                echo '<a id="navbar-brand-panel-user" class="navbar-brand glyphicon glyphicon-home" href="../bsindex.php?s1='.$_SESSION['asociacion'].'"></a>';
        echo '</div>';
        //Opciones en el dispositivo 
        echo '
            <div class="collapse navbar-collapse navbar-menu-collapse">
 
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mis Torneos<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="../Inscripcion/bsInscripcion.php" >Inscripcion</a></li>
                      <li><a href="../Inscripcion/bsInscripcion_Retiros.php">Retiros</a></li>
                      <li><a href="../MisTorneos/MisTorneos.php" >Mis Torneos</a></li>
                      <li><a href="../ARankingNacional/RankingByAtleta.php" >Ranking</a></li>  
                   </ul>
                </li>
            </ul>';
           
            echo ' 
            <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="../Ficha/FichaDatosBasicos.php">Datos Basicos</a></li>
<!--                      <li><a href="..Perfil/PerfilModal.php" >Mis Datos</a></li>-->
                      <li><a href="../Perfil/bsChangeKey.php" >Cambiar Clave</a></li>
                      <li><a href="../Perfil/bsChangeEmail.php" >Cambiar Correo</a></li>
                  </ul>
                </li>
            </ul>';
                
            //<!-- Opciones para el usuario -->   
            echo ' 
            <ul class="nav navbar-nav">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliacion<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../Afiliacion/bsAfiliacionWebAfiliacion.php">Afiliacion</a></li>
                    <li><a href="../Afiliacion/bsAfiliacionWebServicio.php" >Afiliaciones</a></li>
                  
                </ul>
              </li>
            </ul>';
            
            $key=Encrypter::encrypt($_SESSION['atleta_id']);
            if ($_SESSION['deshabilitado']==FALSE){
               
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Constancia<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a target="_blank" href="../Constancias/ConstanciaFederado.php?'.$key.'">Federativa</a></li>
                        </ul>
                    </li>
                </ul>';
          
                       
            }
            echo '
            <ul class="nav navbar-nav navbar-right">';
            echo ' 
                <li class="dropdown">';
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="../sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                    }else{
                        echo '<li><a  href="../Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                    }
            echo '
                </li>
            </ul>';
         
        echo '
        </div>
        </div> <!--/.nav-collapse -->
    
         
    </nav>
   
   
    </header>';
    echo '<br>';    


    $headhmtl='
    <html>
    <head>
    <style>
    .container-fluid {
        position: relative;
        padding-left: 5px;
        margin-bottom: 2px;
        cursor: pointer;
        font-size: 18px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .glyphicon  {
        font-size: 16px;
        margin-bottom: 2px;
        color: #f4511e;
    }
    td  {
        font-size: 12px;
    }
      
    </style>
    </head>
    <body>
    </body>
</hmtl>';