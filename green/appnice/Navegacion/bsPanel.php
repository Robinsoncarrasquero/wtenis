<?php
session_start();


 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $email =$_SESSION['email'];
   
       
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: sesion_inicio.php');
    exit;
 }
if ( $_SESSION['niveluser']==0){
    if ($email==NULL){
       header('Location: Perfil/bsChangeEmail.php');
       exit;
    }
    if ($_SESSION['clave_default']  ==NULL){
       header('Location: Perfil/bsChangeKey.php');
       exit;
    }
}
$urlHome=$_SESSION['home'];

 ?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/tenis_estilos.css">
    <meta title="Sistema de Tenis de Campo">
    <meta description="Sistema de Gestion de Tenis">
    <meta keywords="IPIN,Tenis,G1,G2,G3,G4,G5,ITF,Sistema de Tenis, Inscripciones, OnLine, Draw, Ranking, Pagos, Afiliacion, Afiliaciones, Asociaciones,Estadales,Regionales, Deporte">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
           
    </head>
    <style>
        nav.navbar {
            background-color: #222;
            
        }
        .jumbotron{
            background:    #67b168;
        }
        iframe{
            width: 100%;
        }
                // Use as-is
        
       
    </style>
<body>


<header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarcpanel" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            
             <a class="navbar-brand" href="<?php echo $urlHome ?>">HOME PAGE</a>
              
        </div>
        
        <!-- Opciones en el dispositivo -->
        <div id="navbarcpanel" class="collapse navbar-collapse">
         <?PHP
         if ($_SESSION['niveluser']<8){?>
          <!-- Opciones para el usuario -->   
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
<!--                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mis Torneos<span class="caret"></span></a>-->
<!--                  <ul class="dropdown-menu">-->
                      <li><a href="Inscripcion/bsInscripcion.php" >Inscripcion</a></li>
                      <li><a href="Inscripcion/bsInscripcion_Retiros.php">Retiros</a></li>
                      <li><a href="MisTorneos/MisTorneos.php" >Mis Torneos</a></li>
<!--                  </ul>-->
                </li>
            </ul>
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
<!--                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil<span class="caret"></span></a>-->
<!--                  <ul class="dropdown-menu">-->
                      <li><a href="Perfil/PerfilModal.php" >Mis Datos</a></li>
                      <li><a href="Perfil/bsChangeKey.php" >Cambiar Clave</a></li>
                      <li><a href="Perfil/bsChangeEmail.php" >Cambiar Correo</a></li>
<!--                  </ul>-->
                </li>
            </ul>
                
            <!-- Opciones para el usuario -->   
          <ul class="nav navbar-nav">

              <li class="dropdown">
<!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliacion<span class="caret"></span></a>-->
<!--                <ul class="dropdown-menu">-->
                    <li><a href="Afiliacion/bsAfiliacionWebAfiliacion.php">Afiliacion(Renovar)</a></li>
                    <li><a href="Afiliacion/bsAfiliacionWebServicio.php" >Afiliacion Web</a></li>
                  
<!--                </ul>-->
              </li>
          </ul>
            
         <ul class="nav navbar-nav navbar-right">

              <li class="dropdown">
<!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuario<span class="caret"></span></a>
                -->
<!--                <ul class="dropdown-menu">-->
<!--                    <li><a href="sesion_cerrar.php">Cerrar</a></li>-->
                     <?php
                    
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="sesion_cerrar.php">Cerrar Sesion</a></li>';
                    }else{
                       echo ' <li><a href="Login.php">Login</a></li>';
                    }
                    ?>
                  
<!--                </ul>-->
                
               
              </li>
          </ul>
         <?php } else{ ?>
            
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliados<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="Atleta/atletaRead.php" >Afiliados</a></li>
                      <li><a href="Afiliacion/bsAfiliacionesFormalizacion.php">Formalizacion Afiliacion</a></li>
                      <li><a href="Afiliacion/bsAfiliacionesFormalizacionWeb.php">Formalizacion Web</a></li>
                   </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuracion<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="Configurar/ConfigModal.php" >Configuracion</a></li>
                   
                  </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Noticias<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="Noticias/NoticiasModal.php" >Noticias</a></li>
                   
                  </ul>
                </li>
            </ul>
             <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Torneos<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="Torneo/bsTorneo_Read.php" >Torneos</a></li>
                      <li><a href="Draw/TorneoCreaDrawMenu.php">Draw</a></li>
                     
                     
                   
                  </ul>
                </li>
            </ul>
             <ul class="nav navbar-nav navbar-right">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                        //Menu de web Master
                        if ($_SESSION['niveluser']!=9){
                            
                            echo ' <li><a href="Afiliacion/bsAfiliacionesFormalizacionWeb.php">Formalizar Web</a></li>';
                            echo ' <li><a href="Afiliacion/bsAfiliacionesFormalizacionWebConciliar.php">Conciliar Web</a></li>';
                            echo ' <li><a href="sesion_cerrar.php">Cerrar Sesion</a></li>';
                            
                            
                        }else{
                            //Menu de administrador del sistema
                            echo ' <li><a href="Torneo/bsTorneo_Read.php" >Torneos</a></li>';
                            echo ' <li><a href="Noticias/NoticiasModal.php" >Noticias</a></li>';
                            echo ' <li><a href="Atleta/atletaRead.php" >Afiliados</a></li>';
                            echo ' <li><a href="Afiliacion/bsAfiliacionesFormalizacion.php">Formalizacion Afiliaciones</a></li>';
                            echo ' <li><a href="sesion_cerrar.php">Cerrar Sesion</a></li>';
                            echo ' <li><a href="Configurar/ConfigModal.php" >Configuracion</a></li>';
                            echo ' <li><a href="Draw/TorneoCreaDrawMenu.php">Draw</a></li>';
                            
                        }
                        
                    }else{
                      
                         echo '<li><a href="Login.php">Login</a></li>';
                        
                    }
                    ?>
                    
                   



                  </ul>
                </li>
            </ul>
             
        <?php } ?>
          
          
        </div><!--/.nav-collapse -->
    </div>
        
    </nav>
    
   
</header>

    
 </body>
 
</html>
<!--
 