<?php
session_start();
require_once 'clases/Atleta_cls.php';
require_once 'sql/ConexionPDO.php';
require_once 'clases/Encriptar_cls.php';

 if(isset($_SESSION['logueado']) and !$_SESSION['logueado']){
    
    //Si el usuario no está logueado redireccionamos al login.
     header('Location: sesion_inicio.php');
    exit;
 }
$_SESSION['datos_completos']=TRUE;
if ( $_SESSION['niveluser']==0){
//    if ($_SESSION['niveluser']==0 && $_SESSION['clave_default']  ==NULL &&  $_SESSION['email']==NULL){
//       header('Location: Perfil/PerfilModal.php');
//       exit;
//    }
    if ($_SESSION['email']==NULL){
       header('Location: Perfil/ChangeEmail.php');
       exit;
    }
    if ($_SESSION['clave_default']==NULL){
       header('Location: Perfil/ChangeKey.php');
       exit;
    }
    //Actualizamos los datos del afiliado
    if ($_SESSION['niveluser']==0){
        $atleta_id=  htmlspecialchars($_SESSION['atleta_id']);
        $objAtleta= new Atleta();
        $objAtleta->Find($atleta_id);
        if ($objAtleta->Operacion_Exitosa()){
            if ($objAtleta->edad()<19){
                 if ($objAtleta->getLugarNacimiento()==NULL 
                    || $objAtleta->getCelular()==NULL 
                    || $objAtleta->getCedulaRepresentante()==NULL 
                    || $objAtleta->getNombreRepresentante()==NULL 
                    || $objAtleta->getDireccion()==NULL){
                    $_SESSION['datos_completos']=FALSE;
                   
                    header('Location: Ficha/FichaDatosBasicos2.php');
                    exit;
                }  
            }
        }  
        //Si viene de link de inscripciones
    }
    if ( $_SESSION['niveluser']==0){
      header('Location: MisTorneos/MisTorneos.php');
      exit;
    }
 
}
$urlHome=$_SESSION['home'];

 ?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta  charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio</title>
        <meta name="description" content="Sitio web para Inscripciones onLine de Torneos de Tenis de Campo, Tenis de Playa">
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
           /* background-color: <?php //echo $_SESSION['bgcolor_navbar']?>; */
        }
        .jumbotron{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        iframe{
            width: 100%;
        }
        
        
        alert.alert-server {
            margin-bottom: 0;
            border-radius: 0;
        }
        
         nav.navbar .navbar-inverse {
             background-color:  #1b6d85;
         }
               
    </style>
<body>


<header>
     
<!--    <div class="alert alert-danger alert-server" role="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Moving Servers</strong>Update finish in the new server. This move should be finished on 12/2019.
</div>-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarcpanel" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
             
            <?php
             if ($_SESSION['datos_completos']){
               echo '<a id="navbar-brand-panel" class="navbar-brand glyphicon glyphicon-home" href="'.$urlHome.'"></a>';
             }else{
               echo '<a id="navbar-brand-panel" class="navbar-brand alert alert-danger"  href="Ficha/FichaDatosBasicos.php">Ficha X</a>';
             }

            ?>
        </div>
         <!-- Opciones en el dispositivo -->
        <div id="navbarcpanel" class="collapse navbar-collapse">
         <?PHP
         if ($_SESSION['niveluser']==10){
             
             
            // Menu Gerencial
                echo ' <ul class="nav navbar-nav">';
                echo '<li class="dropdown">';
                    echo ' <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                        echo '<li><a href="AEstadisticas/AfiliacionesFederadas.php" >Afiliaciones Federadas</a></li>';
                        echo '<li><a href="AEstadisticas/AfiliacionesEnTransito.php">Afiliaciones Transito</a></li>';
                        echo '<li><a href="AEstadisticas/AfiliacionesEntidad.php" >Afiliaciones Entidad</a></li>';
                    echo '</ul>';
                echo '</ul>';
                
                echo ' 
                    <ul class="nav navbar-nav">
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliaciones<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="Afiliacion/ConsultaAfiliacionesFederadas.php" >Consulta Afiliaciones</a></li>
                        </ul>
                    </ul>';
                
         }elseif ($_SESSION['niveluser']==8){
             //Opciones de Arbitro
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                          <li><a href="Torneo/bsTorneo_Read.php" >Torneos</a></li>
                          <li><a href="Logout.php" class="glyphicon glyphicon-log-out" ></a></li>
                        </ul>
                    </li>
                </ul> ';
           
         }elseif ($_SESSION['niveluser']<8){?>
          <!-- Opciones para el usuario -->   
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mis Torneos<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="Inscripcion/bsInscripcion.php" >Inscripcion</a></li>
                      <li><a href="Inscripcion/bsInscripcion_Retiros.php">Retiros</a></li>
                      <li><a href="MisTorneos/MisTorneos.php" >Mis Torneos</a></li>
                      <li><a href="ARankingNacional/RankingByAtleta.php" >Ranking</a></li>  
           
                  </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="Ficha/FichaDatosBasicos.php">Datos Basicos</a></li>
<!--                      <li><a href="Perfil/PerfilModal.php" >Mis Datos</a></li>-->
                      <li><a href="Perfil/bsChangeKey.php" >Cambiar Clave</a></li>
                      <li><a href="Perfil/bsChangeEmail.php" >Cambiar Correo</a></li>
                  </ul>
                </li>
            </ul>
                
            <!-- Opciones para el usuario -->   
          <ul class="nav navbar-nav">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliacion<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="Afiliacion/bsAfiliacionWebAfiliacion.php">Afiliacion</a></li>
                    <li><a href="Afiliacion/bsAfiliacionWebServicio.php" >Afiliaciones</a></li>
                  
                </ul>
              </li>
          </ul>
           <?PHP
           $key=Encrypter::encrypt($_SESSION['atleta_id']);
           if ($_SESSION['deshabilitado']==FALSE){?>
            
           <ul class="nav navbar-nav">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Constancia<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a target="_blank" href="Constancias/ConstanciaFederado.php?<?PHP echo $key?>">Federativa</a></li>
<!--                    <li><a  href="Afiliacion/bsAfiliacionWebServicio.php" >Afiliacion Web</a></li>-->
                  
                </ul>
              </li>
          </ul>
          <?PHP }?>
         <ul class="nav navbar-nav navbar-right">

              <li class="dropdown">
<!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuario<span class="caret"></span></a>
                -->
<!--                <ul class="dropdown-menu">-->
<!--                    <li><a href="sesion_cerrar.php">Cerrar</a></li>-->
                     <?php
                    
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                    }else{
                        echo '<li><a  href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
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
                      <li><a href="Administrado/AdministradoAFI.php" >Administrado</a></li>
                      <li><a href="Afiliados/AfiliadosAFI.php" >Afiliados</a></li>
                      <li><a href="Atleta/atletaRead.php" >Atleta</a></li>
                      <li><a href="Afiliacion/bsAfiliacionesFormalizacion.php">Formalizacion</a></li>
                     
                      <?php
                        if ($_SESSION['niveluser']>9){
                          echo ' <li><a href="Afiliacion/bsAfiliacionesFederar.php">Formalizacion Federar</a></li>';
                          echo ' <li><a href="Exportacion/ExportacionXML.php">Exportacion a XML</a></li>';
                        }
                     ?>
<!--                      <li><a href="Afiliacion/bsAfiliacionesFormalizacionWeb.php">Formalizacion Web</a></li>-->
                   </ul>
                </li>
            </ul>

           


            
            <ul class="nav navbar-nav">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuracion<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <!-- <li><a href="SubirFotos/index.php" >Subir Fotos al Portal</a></li> -->
                      <li><a href="Configurar/ConfigModal.php" >Configuracion</a></li>
                      <?php
                        if ($_SESSION['niveluser']>9){
                          echo ' <li><a href="Constancias/ConfigModal.php" >Constancia</a></li>';
                        }
                     ?>
                   
                  </ul>
                </li>
            </ul>
            
            <?php
            // Menu Gerencial
                if ($_SESSION['niveluser']>9){
                    
                echo ' <ul class="nav navbar-nav">';
       
                echo '<li class="dropdown">';
                    echo ' <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                        echo '<li><a href="AEstadisticas/AfiliacionesFederadas.php" >Afiliaciones Federadas</a></li>';
                        echo '<li><a href="AEstadisticas/AfiliacionesEnTransito.php">Afiliaciones Transito</a></li>';
                        echo '<li><a href="AEstadisticas/AfiliacionesEntidad.php">Afiliaciones Entidad</a></li>';
                    echo '</ul>';
                echo '</ul>';


                echo '
                    
                <ul class="nav navbar-nav">
       
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliacion<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="Afiliacion/AbrirAfiliacion.php" >Abrir nuevo periodo</a></li>
                      </ul>
                  </li>
              </ul>';
                  
                }
            
            // Menu Gerencial
                if ($_SESSION['niveluser']==9){
                    
                echo ' <ul class="nav navbar-nav">';
       
                echo '<li class="dropdown">';
                    echo ' <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu">';
                        echo '<li><a href="AEstadisticas/AfiliacionesEntidad.php">Afiliaciones Entidad</a></li>';
                    echo '</ul>';
                echo '</ul>';
                  
                }
            ?>       
            
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
<!--                      <li><a href="Draw/TorneoCreaDrawMenu.php">Draw</a></li>-->
                  </ul>
                </li>
            </ul>
             <?php
            if ($_SESSION['niveluser']>=9){
              echo '<ul class="nav navbar-nav">';
              echo '<li class="dropdown">';
              echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ranking<span class="caret"></span></a>';
              echo '<ul class="dropdown-menu">';
              if ($_SESSION['niveluser']>9){
                echo '<li><a href="ARankingUpload/RankingAFI.php" >Actualizar Ranking</a></li>'; 
              }
              echo '<li><a href="ARankingNacional/RankingByDate.php">Consulta Ranking Por Fecha</a></li>'; 
              echo '<li><a href="ARankingNacional/RankingByJugador.php">Consulta Ranking Individual</a></li>';  
                   
              echo '</ul>';
              echo '</li>';
              echo '</ul>';
            }
             ?>
            
             <ul class="nav navbar-nav navbar-right">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acceso<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                        echo ' <li><a href="sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                    }else{
                        echo '<li><a href="Login.php"><span class="glyphicon glyphicon-log-in">Login</span></a></li>';
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
 