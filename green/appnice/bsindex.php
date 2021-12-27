<?php
session_start();
require_once 'clases/Atleta_cls.php';
include_once 'funciones/funciones_bootstrap.php';
require_once 'clases/Noticias_cls.php';
require_once "clases/Empresa_cls.php";
require_once "clases/Torneos_cls.php";
require_once 'clases/Afiliacion_cls.php';
require_once 'clases/Afiliaciones_cls.php';
require_once 'sql/ConexionPDO.php';
require_once 'clases/Html_cls.php';

if (isset($_GET['s1'])){
    $asociacion=htmlspecialchars($_GET['s1']);
    $host =htmlspecialchars($_SERVER['HTTP_HOST']); //   localhost 
    $servername=$asociacion.".".$host;
    $serveNameArray=explode(".",$servername);
    $sn=strtoupper($serveNameArray[0]);
     $_SESSION['asociacion']=$sn;
}else{
    //Viene la URL virtual directamente del browser
    $serverName =htmlspecialchars($_SERVER['SERVER_NAME']); //   localhost 
    $serveNameArray=explode(".",$serverName);
    $sn=strtoupper($serveNameArray[0]);
    $_SESSION['asociacion']=$sn; // ASOCIACION 

}
//header('Location: Login.php');
    
$objEmpresa = new Empresa();
$objEmpresa->Fetch($_SESSION['asociacion']);
$_SESSION['empresa_id']=$objEmpresa->get_Empresa_id();
$_SESSION['empresa_nombre']=$objEmpresa->getNombre();
$_SESSION['home']='bsindex.php?s1='.strtolower($_SESSION['asociacion']);
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
    $nr= Torneo::Count_Open_Mes($empresa_id, $mes,null);
    $bage1 = $bage2= $bage3 = $bage4 = $bage5 = $bage6 = $bage7 = $bage8 = $bage9 = $bage10= $bage11= $bage12=0;
    
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
echo HTML_SET::html_head("Asociaciones",
'Sitio  Web Oficial para Afiliaciones e Inscripciones onLine de Torneos de Tenis de Campo, Tenis de Playa y Tenis Adaptado' );
echo HTML_SET::style_content();
echo HTML_SET::html_body_open();

?>

<!-- Header -->
<header>
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
     <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbartenis"  aria-controls="navbar">
            <span class="sr-only"><?PHP echo $objEmpresa->getAsociacion() ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <!-- <a class="navbar-brand" href="#"><?PHP echo $objEmpresa->getAsociacion() ?></a> -->
            <a class="navbar-brand" href="#"><img src="<?php echo 'images/logo/logo.png"' ?> width='70px'class="img-responsive"></img></a>
        </div>
        <div id="navbartenis" class="collapse navbar-collapse">
          <ul class="nav navbar-nav ">
<!--            <li class="active "><a href="#"  ><span class="glyphicon glyphicon-home"></span></a></li>-->
            <li><a href="#calendario">Calendario</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="Preafiliacion/Preafiliacion.php" target="_blank">Pre-Afiliacion</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >Ranking<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li id="ranking1"><a href="ARankingNacional/RankingByDate.php">Ranking Fecha</a></li>
                    <li class="divider"></li>
                    <li id="ranking2"><a href="ARankingNacional/RankingByJugador.php">Ranking Individual</a></li>
                </ul>
            </li>
            <li><a href="#banco">Datos Banco</a></li>
            <li><a href="Asociaciones/Asociaciones.php" >Asociaciones</a></li>
          </ul>
        
        <?php
    

        
        if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']==10){
             
            echo ' <ul class="nav navbar-nav navbar-right">';
            echo '   <li class="dropdown">';
            echo '   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >Administrador<span class="caret"></span></a>';
            echo '   <ul class="dropdown-menu">';
            echo '     <li><a href="AEstadisticas/AfiliacionesFederadas.php" >Afiliaciones Federadas</a></li>';
            echo '     <li><a href="AEstadisticas/AfiliacionesEnTransito.php">Afiliaciones Transito</a></li>';
            echo '    <li><a href="sesion_cerrar.php">Cerrar</a></li>';
            echo '   </ul>';
            
            echo ' </ul>'; 
             
        }elseif (isset($_SESSION['niveluser']) && $_SESSION['niveluser']==8){
             
            echo ' <ul class="nav navbar-nav navbar-right">';
            echo '   <li class="dropdown">';
            echo '   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >Arbitro<span class="caret"></span></a>';
            echo '   <ul class="dropdown-menu">';
            echo '   <li><a href="Torneo/bsTorneo_Read_Arbitro.php" >Torneos</a></li>';
            echo '    <li><a href="sesion_cerrar.php">Cerrar</a></li>';
            echo '   </ul>';
            echo ' </ul>'; 
           
        }elseif (isset($_SESSION['niveluser']) and $_SESSION['niveluser']>8){?>;
            <!-- Administrator -->   
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >Administrador<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php
                    
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                        echo ' <li><a href="bsPanel.php">Inicio</a></li>';
                        echo ' <li><a href="Torneo/bsTorneo_Read.php" >Torneos</a></li>';
                        echo ' <li><a href="Noticias/NoticiasModal.php" >Noticias</a></li>';
                        echo ' <li><a href="Atleta/atletaRead.php" >Atleta</a></li>';
                        echo ' <li><a href="Afiliados/AfiliadosAFI.php" >Afiliados</a></li>';
                        echo ' <li><a href="Afiliacion/bsAfiliacionesFormalizacion.php">Afiliaciones</a></li>';
                        echo ' <li><a href="Configurar/ConfigModal.php" >Configuracion</a></li>';
                        echo ' <li><a href="sesion_cerrar.php">Cerrar</a></li>';
                         
                    }else{
                       // echo '<li><a href="Login.php">Login</a></li>';
                         echo '<li><a href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                
                    }
                    ?>
                </ul>
                </li>
            </ul>
            
            
        
        <?php }else{?>
            
            <!-- User -->   
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                   <?php
                    if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                       echo ' <li><a href="bsPanel.php">Inicio</a></li>';
                       echo ' <li><a href="sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                    }else{
                       echo '<li><a  href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                    }
                    ?>
                  </ul>
                </li>
            </ul>
        
         <?php }?>;

        </div>
      </div>
        
    </nav>
    
   
</header>

	<div class="social">
		<ul>
			<li><a href="http://www.facebook.com/MyTenis" target="_blank" class="icon-facebook"></a></li>
			<li><a href="http://www.twitter.com/MyTenis" target="_blank" class="icon-twitter"></a></li>
			
			<li><a href="http://www.instagram.com/MyTenis" target="_blank" class="icon-instagram"></a></li>
			<li><a href="mailto:<?php echo $objEmpresa->getEmail()?>" class="icon-mail"></a></li>
		</ul>
	</div>

<!-- Fin de Header -->

<!-- Section Jumbotron -->
<?php
//Instanciamos el objeto empresa
echo '<div class="container">';

echo (JJJumbotron($objEmpresa->getNombre(), $objEmpresa->getDescripcion()));

?>

   
<!-- Carrusel de fotos -->

        <!--  DIVISION 1 CON 9 GRILLAS COMPLETA CON LA DIVISION 2 CON 3 GRILLAS-->
        <div class="col-xs-12 col-md-7">   
            
        
            <div id="Carrusel-Portal" class="carousel slide" data-ride="carousel" data-interval="2000" data-pause="hover">
                <?php
        //        fotos_portal_v3();
                //fotos_portal2();

                ?>
        
                <a class="left carousel-control" href="#Carrusel-Portal" role="button" data-slide="prev">
    		        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    	        <span class="sr-only">Previous</span>
		        </a>
		        <a class="right carousel-control" href="#Carrusel-Portal" role="button" data-slide="next">
		            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		            <span class="sr-only">Next</span>
	    	    </a>
            </div>
            <hr>
            <!-- Renovacion de Afiliacion -->
           <?php 
            if (isset($_SESSION['logueado']) && $_SESSION['logueado']){
                $empresa_id=$_SESSION['empresa_id'];
                $atleta_id=$_SESSION['atleta_id'];
                //Instanciamos la clase empresa para obtener la empresa_id
                //de la asociacion registrada
                $objEmpresa= new Empresa();
                $objEmpresa->Find($empresa_id);
                if ($objEmpresa->Operacion_Exitosa()){
                    $objAfiliacion = new Afiliacion();
                    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
                    //Aqui colocamos el ano de afiliacion que cambiara cada ano
                    $ano_afiliacion=$objAfiliacion->getAno();
                    $Afiliacion_id=$objAfiliacion->get_ID();
                    //Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
                    $objAfiliado = new Afiliaciones();
                    $objAfiliado->Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion);
                    if ($objAfiliado->getAceptado()==0){
                        echo 
                        '<div>
                        <h5  id="titulo-renovacion" class="alert-danger"><a href ="#">Ya puedes solicitar la Renovacion de Afiliacion, Haciendo Click en este Enlace</a></h5>
                        </div>';
                    }                  
                }
            }else{
                    echo 
                    '<div>
                     <h5  id="titulo-renovacion" class="alert-danger"><a href ="#">Ya puedes solicitar la Renovacion de Afiliacion 2019, Haciendo Click en este Enlace</a></h5>
                    </div>';
            }
            //Calendario
           ?>
           <hr>
           <h5 id="calendario" class="calendario-titulo">Torneos</h5>
           <hr>
             <ul class="row nav nav-pills nav-pills-meses tab-calendario "> 
                <li role="presentation"><a href="#" role="tab" data-toggle="tab"   class="edit-record" id="1" data-id="<?PHP echo $objEmpresa->get_Empresa_id()?>">Ene<b class="badge"><?PHP echo $bage1 ?></b></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="2">Feb<span class="badge"><?PHP echo $bage2 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="3">Mar<span class="badge"><?PHP echo $bage3 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="4">Abr<span class="badge"><?PHP echo $bage4 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="5">May<span class="badge"><?PHP echo $bage5 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab" class="edit-record" id="6">Jun<span class="badge"><?PHP echo $bage6 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="7">Jul<span class="badge"><?PHP echo $bage7 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="8">Ago<span class="badge"><?PHP echo $bage8 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab"  class="edit-record" id="9">Sep<span class="badge"><?PHP echo $bage9 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab" class="edit-record" id="10">Oct<span class="badge"><?PHP echo $bage10 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab" class="edit-record" id="11">Nov<span class="badge"><?PHP echo $bage11 ?></span></a></li>
                <li role="presentation"><a href="#"  role="tab" data-toggle="tab" class="edit-record" id="12">Dic<span class="badge"><?PHP echo $bage12 ?></span></a></li>
             </ul>
            
             <div class="calendario "> 
             </div>
            <hr></hr>
            <div class="tabular row col-sm-12 tab-status">
                <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabopen" aria-controls="tabopen" role="tab" data-toggle="tab">Open</a></li>
                <li role="presentation" ><a href="#tabclosed" aria-controls="tabclosed" role="tab" data-toggle="tab">Closed</a></li>
                <li role="presentation" ><a href="#tabrun" aria-controls="tabrun" role="tab" data-toggle="tab">Run</a></li>
                <li role="presentation" ><a href="#tabend" aria-controls="tabend" role="tab" data-toggle="tab">End</a></li>
                <li role="presentation" ><a href="#tabnext" aria-controls="tabnext" role="tab" data-toggle="tab">Next</a></li>
                </ul>
            </div>
            
            <!-- Tab panes -->
            <div class="tab-content row col-sm-12 col-md-12">
                <!--Tab open --->
                <div role="tabpanel" class="row tab-pane fade in active" id="tabopen">
                    <div id="div_tabOpen" class="col-sm-12 col-md-12">

                    </div> 
                </div>
                <!--Tab run --->
                <div role="tabpanel" class="row tab-pane fade" id="tabrun">
                    <div id="div_tabRun" class="col-sm-12 col-md-12 ">

                    </div>
                </div> 
                
                <!--Tab next --->
                <div role="tabpanel" class="row tab-pane fade" id="tabnext">
                    <div id="div_tabNext" class="col-sm-12 col-md-12 ">

                    </div>
                </div> 
                
                <!--Tab closed --->
                <div role="tabpanel" class="row tab-pane fade" id="tabclosed">
                    <div id="div_tabClosed" class="col-sm-12 col-md-12 ">

                    </div>
                </div> 
                
                <!--Tab End --->
                <div role="tabpanel" class="row tab-pane fade" id="tabend">
                    <div id="div_tabEnd" class="col-sm-12 col-md-12 ">

                    </div>
                </div> 
            </div>
            
            
            
                        
        </div>
        
       
        <!-- FIN DE DIVISION 1 DE POST -->
        
            
        <div class="col-xs-12 col-md-5">
            <!-- Noticias -->
           
               <h5  class="twitter-titulo">Noticias</h5>
                <div class="noticias">
                    <?php
                        // Buscamos los articulos mediante la clase Noticias en el metodo ReadAll
                        $objNoticias = new Noticias();
                        $rsColeccion=$objNoticias->ReadAll($objEmpresa->get_Empresa_id(),8);
                        foreach ($rsColeccion as $row) {
                            if ($row['estatus']!='N'){
                                echo "<nr>";
                                echo (Post_Titulares($row['noticia_id'],$row['titulo'], $row['mininoticia'],$row['autor'],  $row['fecha']));
                            }
                        }
                    ?>
                </div>
            
             <h5  class="twitter-titulo">Desde Twitter</h5>
            <?php
            //Twiiter
           
            echo TTTwitter($objEmpresa->getTwitter());

            ?>
             
           
        </div> 
        <!-- FIN DE DIVISION 2 LADO DERECHO-->
                
 <?php

 
 

//Parte I Calendario Anual
echo '<div class="calendario-fvt row">';

    echo '<div class="col-xs-12 col-sm-12 col-md-12">';
            echo '<hr>';
        echo '<div class="col-xs-12 col-sm-4 col-md-4">';
            echo '<div class="thumbnail">';
                echo '<div class="caption">';
                echo '<h5 class="text-center">Calendario Juvenil y Adultos 2019</h5>';
                echo '<a target="_blank" href ="reglamento/Calendario Juv y Adul Fvt 2019 .pdf" ><img  src="images/logo/fvt/tenis700x490.jpg"></a>';
              
                echo '</div>';
                
            echo '</div>';

        echo '</div>';

        echo '<div class="col-xs-12 col-sm-4 col-md-4">';
            echo '<div class="thumbnail">';
                echo '<div class="caption">';
                echo '<h5  class="text-center">Calendario Adpt y Capacitacion 2019</h5>';
                echo '<a  target="_blank" href ="reglamento/Calendario Adpt y Capacitacion Fvt 2019.pdf" ><img src="images/logo/fvt/net453x340.jpg"></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        echo '<div class="col-xs-12 col-sm-4 col-md-4 ">';
           echo '<div class="thumbnail">';
                echo '<div class="caption">';
                echo '<h5 class="text-center">Calendario Tenis de Playa 2019</h5>';
                echo '<a target="_blank" href ="reglamento/Calendario Tenis de Playa Fvt 2019 .pdf" ><img src="images/logo/fvt/pelotatenisdeplaya960x640.jpg"></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    echo '</div>';       
        
echo '</div>';

//Parte II Calendario Anual
echo '<div class="calendario-fvt row">';
    echo '<div class="col-xs-12 col-sm-12 col-md-12">';

        echo '<div class="col-xs-12 col-sm-4 col-md-4">';
            echo '<div class="thumbnail">';
                echo '<div class="caption">';
                echo '<h5 class="text-center">Reglamento rcnctnna 2019</h5>';
                echo '<a target="_blank" href ="reglamento/Reglamento RCNCTNNA 2019.pdf" ><img src="images/logo/fvt/woman500x352.jpg"></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        echo '<div class="col-xs-12 col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4">';
           echo '<div class="thumbnail">';
                echo '<div class="caption">';
                echo '<h5 class="text-center">Reglamento Tennis 10</h5>';
                echo '<a target="_blank" href ="reglamento/ReglamentoTenis10FVT2019.pdf" ><img src="images/logo/fvt/cancha500x372.jpeg"></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        
    echo '</div>';
     
echo '</div>';

                        
?>

<!-- footer de Empresa -->
<?php
echo (FFFooter($objEmpresa->getDireccion(), $objEmpresa->getTelefonos(), $objEmpresa->getEmail()));
?>

<!-- footer de banco -->
<?php

echo (DDDatosdeBanco($objEmpresa->getBanco(), $objEmpresa->getCuenta(),$objEmpresa->getNombre(),$objEmpresa->getRif()));
?>

<!-- Footer 2 -->  
<?php
echo (FFFooterCopyRT());
?>


</div> <!-- Fin de section de container main-->

<script>

$(document).ready(function(){
	 
    var f = new Date();
    mes =  f.getMonth()+1 ;
    
    emp=$(".edit-record").attr('data-id');
    $('.nav-pills-meses li').eq(mes-1).addClass("active");  
    //$(this).addClass("active");
    var loadTorneo = function(e) {
        if (e) {
            console.log(e);
        } else {
            loadtab("Open");
        }
    };
    $('.edit-record').click(loadTorneo);
    //loadTorneo(); // disparar
 
  
   $(window).on("load", ocultar);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target; 
        e.relatedTarget;
        e.preventDefault();
       
        loadtab($(e.target).text());
    });   

    function loadtab(status){
        
        
        $('#div_tab'+status).html('');
        $('#div_tab'+status).addClass('loader');
        $.post("bsindexLoadGroupCalendario.php",
        {emp:emp,mes: mes,status:status}, 
        function(data){
            $('#div_tab'+status).removeClass('loader');
            if (data.Success){
               $('#div_tab'+status).html(data.html);
               
            }else{
                $('#div_tab'+status).html(data.Mensaje);
                 
            }
            
        });
    }
    
    // Control calendario 
    $('.nav-pills-meses li').click(function(e){
        e.preventDefault();
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            mes = $(this).index() + 1;
            emp=$(".edit-record").attr('data-id');
            $(".calendario").html('');
            loadtab("Open");
            $('.nav-tabs a[href="#tabopen"]').tab('show');
            $('.calendario').show(100);
        }else{
            $('.calendario').toggle(100);
        }
       
       
    });    
    
    $('[data-toggle="tooltip"]').tooltip();  
    //Renovacion de Afiliacion Post
    $('#titulo-renovacion').click(function(){
        var d = new Date();
        var y = d.getFullYear();
        if (d.getMonth()>11){  
           y = d.getFullYear()+1;
        }
        if (d>0){
            var url = 'Afiliacion/bsRenovacionPost.php?id='+y;
            var target = '';
            if(url) {
                if(target === '_blank') { 
                    window.open(url, target);
                } else {
                    window.location = url;
                }
            }    
        }
    });
       
    //Control de titulares
    $( "#NOPOST" )
        .on( "click", function() {
        location.href = '#titulares'; 
    });
 
    $('.Titulares').click( function(e)  {
        e.preventDefault();
        var id =$(this).attr('data-id');
        if (id===0){
            var href = $(this).attr('href');
            $.post("bsindexLoadlaNoticia.php",
                {id: $(this).attr('data-id')}, 
                function(html){
                   $('.listNoticia').html(html);
                }
            );
        }else{
            var url = $(this).attr('href');
            var target = $(this).attr('target');
            if(url) {
                if(target === '_blank') { 
                    window.open(url, target);
                } else {
                    window.location = url;
                }
            }          
        }
        
    });
    //link referido 
    $('.Link').click(function(){
        location.href = this.href; 
    });
    
    $('#btnmostrarbanco').click(function(){
        $('#datosbanco').toggle(1000);
    });
    
   $(window).on("load", ocultar);

    function ocultar(){
        $("#datosbanco").hide();
   
    }
});

</script>

</body>
</html>
 




