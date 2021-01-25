<?php
session_start();
require_once 'clases/Atleta_cls.php';
include_once 'funciones/funciones_bootstrap.php';
require_once 'clases/Noticias_cls.php';
require_once "clases/Empresa_cls.php";
require_once "clases/Torneos_cls.php";
require_once 'sql/ConexionPDO.php';

//echo 'Hello ' . htmlspecialchars(isset($_GET["asociacion"])? $_GET["asociacion"]:"nada") . '!';
//echo "</br>".$_SERVER['HTTP_HOST']; //   localhost 

//Viene metodo GET y se contruye un url virtual

if (isset($_GET['s1'])){
    $asociacion=htmlspecialchars($_GET['s1']);
    $host =htmlspecialchars($_SERVER['HTTP_HOST']); //   localhost 
    $servername=$asociacion.".".$host;
    $serveNameArray=explode(".",$servername);
    $sn=strtoupper($serveNameArray[0]);
     $_SESSION['asociacion']=$sn;
//    echo 'dominio ' . htmlspecialchars(isset($_SESSION["asociacion"])? $_SESSION["asociacion"]:"nada") . '!';
//    echo "</br>".$sn; //   localhost 
//    exit;
   
}else{
    //Viene la URL virtual directamente del browser
    $serverName =htmlspecialchars($_SERVER['SERVER_NAME']); //   localhost 
    $serveNameArray=explode(".",$serverName);
    $sn=strtoupper($serveNameArray[0]);
    $_SESSION['asociacion']=$sn; // ASOCIACION 
//    echo "subdominio</br>".$sn; //   localhost 
//    exit;

   
}
//Instanciamos el objeto empresa para traer los datos

$objEmpresa = new Empresa();
$objEmpresa->Fetch($_SESSION['asociacion']);
$_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
$_SESSION['empresa_nombre']=$objEmpresa->getNombre();
$_SESSION['home']=MODO_DE_PRUEBA ? 'bsindex.php?s1='.strtolower($_SESSION['asociacion']): $objEmpresa->getURL();
//$url=$objEmpresa->getURL();

if (!$objEmpresa->Operacion_Exitosa()) {
    $_SESSION['asociacion']='fvt'; // ASOCIACION 
    $objEmpresa->Fetch($_SESSION['asociacion']);
    $_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
 
}
 $_SESSION['ano_afiliacion']=date("Y");

 $_SESSION['url_fotos']="slide/" .strtolower($_SESSION['asociacion']);
 $_SESSION['url_fotos_portal']="uploadFotos/portal/" .strtolower($_SESSION['asociacion']).'/';
 $_SESSION['url_foto_perfil']="uploadFotos/perfil/";
 $_SESSION['url_fotos_torneos']="uploadFotos/torneos/";
 
 $_SESSION['url_logo']="images/logo/" .strtolower($_SESSION['asociacion']);
 $_SESSION['color_jumbotron']=$objEmpresa->getColorJumbotron();
 $_SESSION['bgcolor_jumbotron']=$objEmpresa->getbgColorJumbotron();
 $_SESSION['bgcolor_navbar']=$objEmpresa->getColorNavbar();
 $_SESSION['favicon']="images/logo/" .strtolower($_SESSION['asociacion']).'/favico.ico';
 

 // Buscamos los torneos vigentes
$empresa_id=$_SESSION['empresa_id'];

$array_meses = array(1, 2, 3, 4,5,6,7,8,9,10,11,12);
foreach ($array_meses as $valor_mes){
    //para que busque todos los torneos sin importar la empresa
    $empresa_id=0; 
    //Mes valor
    $mes = $valor_mes ;
    //La Funcion estatica de la clase torneo devuelve numero de torneos abiertos
    //por mes del calendario
    //$nr= Torneo::Count_Open_Mes($empresa_id, $mes);
    $nr=0;
//    $nr += Torneo::Count_Open_Mes($empresa_id, $mes,'G1');
//    $nr += Torneo::Count_Open_Mes($empresa_id, $mes,'G2');
//    $nr += Torneo::Count_Open_Mes($empresa_id, $mes,'G3');
//    $nr += Torneo::Count_Open_Mes($empresa_id, $mes,'G4');
//    $nr += Torneo::Count_Open_Mes($empresa_id, $mes,'G5');
    $nr= Torneo::Count_Open_Mes($empresa_id, $mes);
    if ($nr>0){
        switch ($mes) {
            case 1:
               $bage1 =$nr;
                break;
            case 2:
                $bage2 =$nr;
               
                break;
            case 3:
                $bage3 =$nr;
                break;
            case 4:
                $bage4 =$nr;
                break;
            case 5:
                $bage5 =$nr;
                break;
            case 6:
                $bage6 =$nr;
                break;
            case 7:
                $bage7 =$nr;
                break;
            case 8:
                $bage8 =$nr;
                break;

            case 9:
                $bage9 =$nr;
                break;
            case 10:
                $bage10 =$nr;
                break;
            case 11:
                $bage11 =$nr;
                break;
            case 12:
                $bage12 =$nr;
                break;
            default:
                break;
        }
    }
    
}

//include "bsHeaderHTML.php"
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta title="Federacion Venezolana de Tenis Venezuela">
        <meta description="Sistema de Gestion de Tenis">
        <meta keywords="IPIN,Tenis,G1,G2,G3,G4,G5,ITF,Sistema,Tenis, Tennis, Gestion, Inscripciones, OnLine, on line, Draw, Ranking, Pagos, Afiliacion, Afiliaciones, Asociaciones,Estadales,Regionales, Deporte, Zonales, zonales">
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
            background-color: <?php echo $_SESSION['bgcolor_navbar']?>;
        }
        .jumbotron{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        .title-table{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        .post-mininoticia-title-head{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        .twitter-title{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        iframe{
            width: 100%;
        }
        
                // Use as-is
        
       
    </style>
<body>




<!--<a data-toggle="modal" href="#example" class="btn btn-primary btn-large">Abrir ventana modal</a> 

<div id="example" class="modal hide fade in" style="display: none;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3>Cabecera de la ventana</h3>
     </div>
     <div class="modal-body">
         <h4>Texto de la ventana</h4>
        <p>Mas texto en la ventana.</p>                
    </div>
    <div class="modal-footer">
        <a href="index.html" class="btn btn-success">Guardar</a>
        <a href="#" data-dismiss="modal" class="btn">Cerrar</a>
    </div>
</div>-->

 
<!-- Header -->
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="containe-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbartenis" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"><?PHP echo $objEmpresa->getAsociacion() ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="#"><?PHP echo $objEmpresa->getAsociacion() ?></a>
        </div>
        
        <!-- Opciones en el dispositivo -->
        <div id="navbartenis" class="collapse navbar-collapse">
        
          <ul class="nav navbar-nav">
            <li class="active "><a href="#"  ><span class="glyphicon glyphicon-home"></span></a></li>
            
            <li><a href="#calendario">Calendario</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="Preafiliacion/Preafiliacion.php" target="_blank">Pre-Afiliacion</a></li>
            <li><a href="Atleta/bsranking_nacional.php" target="_blank">Ranking</a></li>
            <li><a href="#banco">Datos Banco</a></li>
            <li><a href="Asociaciones/Asociaciones.php" target="">Asociaciones</a></li>
            
          </ul>
       
        
        <?php 
        if (isset($_SESSION['niveluser']) and $_SESSION['niveluser']>8){?>;
            <!-- Opciones para el administrador -->   
            <ul class="nav navbar-nav navbar-right">
       
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <?php
                    
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       
                        
//                        echo ' <li><a href="afiliacionespago.php">Afiliaciones</a></li>';
//                        echo ' <li><a href="afiliacionesporpagar.php">Afiliaciones por pagar</a></li>';
                       
                       echo ' <li><a href="bsPanel.php">Inicio</a></li>';
                        echo ' <li><a href="Torneo/bsTorneo_Read.php" >Torneos</a></li>';
                        echo ' <li><a href="Noticias/NoticiasModal.php" >Noticias</a></li>';
                        echo ' <li><a href="Atleta/atletaRead.php" >Afiliados</a></li>';
                        echo ' <li><a href="Afiliacion/bsAfiliacionesFormalizacion.php">Afiliaciones</a></li>';
                        echo ' <li><a href="Configurar/ConfigModal.php" >Configuracion</a></li>';
                        echo ' <li><a href="sesion_cerrar.php">Logout</a></li>';
                      
                        
                        
                    }else{
                        echo '<li><a href="Login.php">Login</a></li>';
                        
                    }
                    ?>



                  </ul>
                </li>
            </ul>
          
        
        <?php }else{?>
            
            <!-- Opciones para el usuario -->   
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                  <a  href="#" class="dropdown-toggle glyphicon glyphicon-user alert-success" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php
                    
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="bsPanel.php">Inicio</a></li>';
                       echo ' <li><a href="sesion_cerrar.php">Logout</a></li>';
                    }else{
                       echo '<li><a href="Login.php">Login</a></li>';
                    }
                    ?>

                  </ul>
                </li>
            </ul>
        
       
       
        <?php }?>;
        
          
        </div><!--/.nav-collapse -->
      </div>
        
    </nav>
    
   
</header>





<!-- Fin de Header -->

<!-- Section Jumbotron -->
<?php
//Instanciamos el objeto empresa para traer los datos




echo (JJumbotron($objEmpresa->getNombre(), $objEmpresa->getDescripcion()));


// Creamos el Jumbotron
//echo (xjumbotron($objEmpresa->getNombre(), $objEmpresa->getDescripcion()));


?>
 
<!-- Fin Section Jumbotron -->




	
   
<!-- Carrusel de fotos -->
<div class="main container">
    <div class="row">
        <!--  DIVISION 1 CON 9 GRILLAS COMPLETA CON LA DIVISION 2 CON 3 GRILLAS-->
        <div class="img-portal-slide col-xs-12 col-md-8">
            
           
            <!-- INICIO DE CARRUSEL -->
        
            <div id="Carousel_galery" class="carousel slide" data-ride="carousel" data-interval="2000" data-pause="hover">
               
                <!-- <ol class="carousel-indicators">
                    <li data-target="#Carousel_galery" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel_galery" data-slide-to="1"></li>
                    <li data-target="#Carousel_galery" data-slide-to="2"></li>
                    <li data-target="#Carousel_galery" data-slide-to="3"></li>

                </ol> -->    
                
                <?php
                fotos_portal2();
//                fotos_portal_image();
                ?>
        
                <!--Left and right controls -->

                 
                <a class="left carousel-control" href="#Carousel_galery" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#Carousel_galery" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
            </div>
            
            
            <!-- FIN DE CARRUSEL-->
            
          
            <!-- POST-FIJO 2
            <!-- Section de Calendario de Torneos -->
            <h4 id="calendario" class="title-table">CALENDARIO</h4>
            
            <!-- <ul class="nav nav-tabs  nav-pills-meses" >-->
            <ul class="nav nav-pills nav-pills-meses "> 
           
                <li role="presentation"><a href="#"   class="edit-record" data-id="<?PHP echo $objEmpresa->get_Empresa_id()?>">Ene<span class="badge"><?PHP echo $bage1 ?></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Feb<span class="badge"><?PHP echo $bage2 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Mar<span class="badge"><?PHP echo $bage3 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record>">Abr<span class="badge"><?PHP echo $bage4 ?></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >May<span class="badge"><?PHP echo $bage5 ?></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Jun<span class="badge"><?PHP echo $bage6 ?></span></a></li>
<!--                     </ul>
            
            <ul class="nav nav-tabs  nav-pills-meses">-->
                <li role="presentation"><a href="#"   class="edit-record" >Jul<span class="badge"><?PHP echo $bage7 ?></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Ago<span class="badge"><?PHP echo $bage8 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Sep<span class="badge"><?PHP echo $bage9 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Oct<span class="badge"><?PHP echo $bage10 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Nov<span class="badge"><?PHP echo $bage11 ?></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Dic<span class="badge"><?PHP echo $bage12 ?></span></a></li>
            </ul>
            
            

            
            <div class="calendario">
            
            </div>
            
            <!-- FIN DE CALENDARIO-->
             <?php
            //echo (PubliJumbotron($objEmpresa->getNombre(), $objEmpresa->getDescripcion()));
            ?>
           
           
        </div> 
       
        <!-- FIN DE DIVISION 1 DE POST -->
        
        <!-- INICIO DIVISION 2 CON 3 GRILLAS  PARA TOTALIZAR 12 GRILLAS-->
        
        
       
        
        
        
         <div class="col-xs-12 col-md-4">
            
            <!-- Noticias list-group -->
            <div  class="post-articulos">
            
                <h4  class="post-mininoticia-title-head">NOTICIAS</h4>
                <div class="post-mininoticia-title">
                    <?php
                        // Buscamos los articulos mediante la clase Noticias en el metodo ReadAll
                        $objNoticias = new Noticias();
                        $rsColeccion=$objNoticias->ReadAll($objEmpresa->get_Empresa_id(),8);
                        foreach ($rsColeccion as $row) {
                            if ($row['estatus']!='N'){
                                echo (Post_Titulares($row['noticia_id'],$row['titulo'], $row['mininoticia'],$row['autor'],  $row['fecha']));
                            }
                        }
                    ?>
                </div>
            </div>
            
          
           
            <?php
            
            echo Twitter($objEmpresa->getTwitter());
            
            
            ?>
           
            
        </div>
        
    
        <!-- FIN DE DIVISION 2 POST AUTO -->
        
      </div> <!-- Fin de orw container Principal -->
    
 </div> <!-- Fin de section de container main
<!-- FIN DE CONTAINER MAIN -->




<?php

echo (footer($objEmpresa->getDireccion(), $objEmpresa->getTelefonos(), $objEmpresa->getEmail()));
?>

<!-- footer de banco -->
<?php

echo (DatosdeBanco($objEmpresa->getBanco(), $objEmpresa->getCuenta(),$objEmpresa->getNombre(),$objEmpresa->getRif()));
?>

<!-- Footer 2 -->  
 
<?php
echo (FooterCopyRT());
?>
   
<!--<script src="js/jquery-1-12-4.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>-->




<script>

$(function (){
    $('[data-toggle="tooltip"]').tooltip(); 
    
   //Ocultar las noticias
    //$( ".jumbotron" ).css({'background-color':'#8A2BE2','color':'white'});
    //$('.navbar').css({'background-color' :'  #555','color':'yellow'});
    //$('[data-toggle="tooltip"]').tooltip(); 
    //$('.Noticias').hide(600);
    //Manejamos para abrir o cerrar el calendario
   
    $( "hh4" ).on( "mouseover", function() {
        $( "#calendario" ).css( "background-color", "#f0000" );
    });
    $('#ccalendario').click(function(){
       //$('.calendario').toggle(300);
         //$( "#calendario" ).css('background-color','info').addClass('text text-success');
          $('.calendario').toggle(1200);
        
    });
    
    //Controlamos para movernos a los titulares de
    //la noticia en caso de tener alguna noticia activa
    $( "#NOPOST" )
        
        .on( "click", function() {
            location.href = '#titulares'; // ir al link  
          //$('.calendario').hide(1200);
          //$('.Noticias').hide(1200);
        });
    
//    $( "#ccalendario" )
//        .on( "mouseenter", function() {
//          $( this ).css({
//            "background-color": "yellow",
//            "font-weight": "bolder"
//          });
//          $('.calendario').toggle(300);
//        })
//        .on( "mouseleave", function() {
//          var styles = {
//            backgroundColor : "green",
//            fontWeight: "bolder"
//          };
//          $('.calendario').toggle(300);
//          $( this ).css( styles );
//        });

    $('.Titulares').click( function(e)  {
            e.preventDefault();
            //Cuando data-id es cero representa un nuevo registro y update debe ser mayor> 0 
            var id =$(this).attr('data-id');
           
            if (id==0){
                // Sirve para mostra la noticia en la misma pagina
                // en el area de noticias
                var href = $(this).attr('href');
                //$("#results").html('entro');
                $.post("bsindexLoadlaNoticia.php",
                    {id: $(this).attr('data-id')}, 
                    function(html){
                        //$('.modal-body').removeClass('loader');
                       //$('#results').html('SALIO ');
                       $('.listNoticia').html(html);

                       //$('#summernote').summernote({height: 300});
                    }
                );
            }else{
                    // Linkear la pagina en una ventana diferente
                    var url = $(this).attr('href');
                    var target = $(this).attr('target');

                    if(url) {
                        // # open in new window if "_blank" used
                        if(target == '_blank') { 
                            window.open(url, target);
                        } else {
                            window.location = url;
                        }
                    }          
            }
        
    });
    
    //Titulares
   
//    $("a[href=['Noticia*']]").click(function() {
//
//     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
//         && location.hostname == this.hostname) {
//
//             var $target = $(this.hash);
//
//             $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
//
//             if ($target.length) {
//
//                 var targetOffset = $target.offset().top;
//
//                 $('html,body').animate({scrollTop: targetOffset}, 1000);
//
//                 return false;
//
//            }
//
//       }
//
//   });

var hoy = new Date();
var dd = hoy.getDate();
var mm = hoy.getMonth()+1; //hoy es 0!
var yyyy = hoy.getFullYear();
if (mm === hoy.getMonth()+1)
{
   
    
    
    
}

    
  // Manejamos la tabla de meses tabuladas con pildoras 
  // Al seleccionar un mes disparamos un ajax para presentar
  // el calendario
    $('.nav-pills-meses li').click(function(e){
        
        
        e.preventDefault();
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            
           
            var mes = $(this).index() + 1;

            //alert("Mes : " + mes );

            var emp=$(".edit-record").attr('data-id');
            //  alert("Empresa : " + emp );
            
            
            
            $(".calendario").html('');
            $('.calendario').addClass('loader');

            $.post("bsindexLoadCalendario.php",
                {empresa_id:emp,mes: mes}, 
                function(html){
                        $('.calendario').removeClass('loader');
                        $('.calendario').html(html);
            });

            $('.calendario').show(100);
        }else{
            
            $('.calendario').toggle(100);

        }
       
    });    
    
     // Lanzamos un link referido 
    $('.Link').click(function(){
         //alert('Pulsaron salir');
        location.href = this.href; // ir al link    
            
    });
    
    
    
    
    //Ocultar las noticias
    
    
    //Editamos el registro nuevo o update
   
    
    
   
    
    

    
   
   
    
   
});



	
</script>



</body>
 




