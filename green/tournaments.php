<?php
//require_once 'appnice/clases/Atleta_cls.php';
require_once 'appnice/clases/Torneos_cls.php';
require_once 'appnice/sql/ConexionPDO.php';
require_once 'appnice/clases/Funciones_cls.php';
//require_once 'appnice/clases/Encriptar_cls.php';
//require_once 'appnice/clases/Ranking_cls.php';
//require_once 'appnice/clases/Paginacion_cls.php';
require_once 'tournament_direct_cls.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>
<title>Torneos | Calendario</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="author" content="MyTenis"/>
<meta name="keywords" content="Asociaciones, Tenis, club, eventos deportivos,MyTenis, non-profit, junior, tennis, sport, deporte, magazine, non profit" />
<meta name="description" content="Asociaciones!">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="copyright" content="(c)  System Enrollment" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="Torneos de la Asociaciones">

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href="css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--Video Porfolio-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" />

    <link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />
    <link href="css/component.css" rel="stylesheet" type="text/css" />
    <link href="css/style_dir.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />
</head>
<body>
<section class="content-top-login">
    <div class="container">
<div class="col-md-12">
    <div class="box-support"> 
      <p class="support-info"><i class="fa fa-envelope-o"></i> info@example.com</p>
   </div>
    <div class="box-login"> 
     <!-- <i class="fa fa-shopping-cart"></i>-->
      <a href='login.php'>Login</a>
      <a href='login.php'>Sign Up</a>
   </div>
<!-- Carrito	
   <div class="cart-prod hiddenbox">
      <div class="sec-prod">
       <div class="content-cart-prod">
         <i class="fa fa-times"></i>
         <img src="http://placehold.it/160x160" alt="" />
         <p>FIVE BLX</p>
         <p>1 X $55.00</p>
       </div>
       <div class="content-cart-prod">
         <i class="fa fa-times"></i>
         <img class="racket-img" src="http://placehold.it/160x160" alt="" />
         <p>FIVE BLX</p>
         <p>1 X $125.00</p>
       </div>
        <div class="content-cart-prod">
         <p class="cart-tot-price">Total: $180.00</p>
         <a href="#" class="btn-cart">Go to cart</a>
         <a href="#" class="btn-cart">Checkout</a>
       </div>
      </div>
   </div>
 </div>
fin carrito-->
</div>
</section>
<!--SECTION MENU -->
<section class="container box-logo">
  
<?php require_once 'menu.php' ?>

</section>

  <section class="drawer">
    <div class="col-md-12 size-img back-img">
        <div class="effect-cover">
        <h3 class="txt-advert animated">El circuito esta activo</h3>
        <p class="txt-advert-sub animated">Los competidores y competidoras demuestran su talento en la cancha</p>
        </div>
    </div>
    <section id="summary" class="container secondary-page">
      <div class="general general-results tournaments">
           
           <div id="c-calend" class="top-score-title right-score col-md-9">
                <h3><?php echo date("Y");?> <span>CALENDARIO</span><span class="point-little">.</span></h3>
                <p class="txt-right">Torneos del Circuito estan en accion a nivel nacional, cumpliendose el calendario establecido.</p>
                <p class="txt-right txt-dd-second">Revisando cada evento en cada ciudad o lugar anfitrion</p>
                
                 <?php
                 
                 for ($i=1; $i <= 12; $i++) {
                      $badge=Torneo::Count_Open_Mes(0, $i,null);
                      $torneo = new Torneos_Directos($i);
                      $data = $torneo->data();
                      
                      $linea='
                      <div class="accordion" id="section'.$i.'"><i class="fa fa-calendar-o"></i>'
                      .Funciones::MesLiteral($i).' 
                      <mark class="badge">'.($badge> 0 ? $badge : "").'</mark>
                      <span ></span>
                      </div>

                      <div class="acc-content">' 
                      .$data .
                      '                   
                      </div>';
                      echo $linea;
                        
                  }    
                     
                      
                  ?>
      
           </div><!--Close Top Match-->
           <div class="col-md-3 right-column">
            <div class="top-score-title col-md-12 right-title">
                  <h3>Noticias Recientes</h3>
                  <!-- <div class="right-content">
                      <p class="news-title-right">Serie 6-7 Marzo 2020</p>
                      <p class="txt-right">
                        Portugal peleará en los play-offs del Grupo Mundial I en marzo 2020 contra Nueva Zelanda. En el primer choque, 1960, los americanos ganaron a los kiwis.
                      </p>
                      <a href="#single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                  </div>
                  <div class="right-content">
                      <p class="news-title-right">Portugal Salva Un Punto Ante Nueva Zelanda</p>
                      <p class="txt-right">Muñoz-Abreu perdió con Tearney, pero Martínez igualó la serie al vencer en tres sets al 1 neocelandés. Victorias parciales de China Taipei, Noruega y Portugal.
                      </p>
                      <a href="#single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                  </div>
                  <div class="right-content">
                      <p class="news-title-right">Ultima Serie 14-15 Septiembre 2019</p>
                      <p class="txt-right">Portugal cayó 4-0 ante Ecuador en Florida, Estados Unidos, gracias a Emilio Gómez, Roberto Quiroz, los doblistas Gonzalo Escobar y Diego Hidalgo, y el debutante Antonio Cayetano March, que desarmaron al equipo liderado por Jordi Muñoz y Luis David Martínez. Fue el encuentro número 12 de las naciones.
                      </p>
                      <a href="#single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                  </div> -->
            </div>
          <div class="top-score-title col-md-12">
            <img src="img/img_descargadas/cancha.png" alt="" />
          </div>
          <div class="top-score-title col-md-12 right-title">
                <h3>Photos</h3> 
                <ul class="right-last-photo">
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img1.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img2.jpg" alt="320x213" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img6.jpg" alt="320x213" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img6.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img5.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
                      <img src="img/img_descargadas/cdavis/img4.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                
                </ul>
          </div>
         </div>
        </section>

        <section id="sponsor" class="container">
            <!--SECTION SPONSOR-->
           <div class="client-sport client-sport-nomargin">
               <div class="content-banner">
                   <?php require_once 'sponsor.php'?>
                  
                </div>
          </div>
        </section>
       
       <?php require_once 'footer.php'?>

</section>
<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!--MENU-->
<script src="js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!-- Button Anchor Top-->
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>

<script src="js/jquery.accordion.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                "use strict";
                $('.accordion').accordion({ defaultOpen: 'section_x' }); //some_id section1 in demo
            });
        });
</script>

<script src="js/custom.js" type="text/javascript"></script>  
<script type="text/javascript">
    $(document).ready(function(){
    $( "#SexoM" ).click();
  })  
  
  $(".aaaaccordion").click(function(e){
      
      e.preventDefault();
      mes = $(this).attr('id');   
      id = $(this).attr('id').substr(7,2);
      $.ajax({
        method: "POST",
        url: "tournamentLoad.php",
        dataType:"json", 
        data:  {mes:mes}
      })
      
      .done(function( data) {
        if (data.Success){
          $('#results'+id).html(data.html);
          $('.acc-content').html(data.html);
        }
        
      });
  });
  

   </script>     
</body>
</html>
