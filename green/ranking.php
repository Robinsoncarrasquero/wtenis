<?php
session_start();
require_once __DIR__.'/appnice/clases/Atleta_cls.php';
require_once __DIR__.'/appnice/sql/ConexionPDO.php';
require_once __DIR__.'/appnice/clases/Funciones_cls.php';
require_once __DIR__.'/appnice/clases/Encriptar_cls.php';
require_once __DIR__.'/appnice/clases/Ranking_cls.php';
require_once __DIR__.'/appnice/clases/Paginacion_cls.php';
 

?>

<!DOCTYPE html>

<head>
<title>Ranking | Posiciones</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="author" content="mytenis"/>
<meta name="keywords" content="Asociaciones, Tenis, club, eventos deportivos,MyTenis, non-profit, junior, tennis, sport, deporte, magazine, non profit" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="copyright" content="(c)  System Enrollment" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="Ranking y posiciones de los Jugadores de la Liga">
   
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
      <a href='appnice/sesion_cerrar.php'>Sign Up</a>
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
 <header>
   <?php require_once 'menu.php' ?>
</header>
</section>

<section class="drawer">
    <div class="col-md-12 size-img back-img">
        <div class="effect-cover">
            <h3 class="txt-advert animated">Tenis Ranking</h3>
            <p class="txt-advert-sub">Los tenistas y las tenistas se destacan cada dia</p>
        </div>
    </div>
    
    <section id="summary" class="container secondary-page">
      <div class="general general-results">
           <div id="Result" class="top-score-title right-score total-reslts col-md-9">
                <h3>Ranking <span>Nacional</span><span class="point-little">.</span></h3>
                <div class="cat-con-desc">
                <img src="images/cup1.jpg" alt="" /><p class="news-title-right">Ranking y resultados</p>
                <p class="txt-right">Los jugadores y Jugadoras con los resultados logrados en el Tour del circuito de Tenis, 
                   con la participacion de las mejores raquetas del pais.</p>
                <p class="txt-right">El respeto, la disciplina, la constancia, el entrenamiento diario nos demuestra
                 que solo con dedicacion diaria, podemos lograr nuestros objetivos en cualquier ambito de la vida.</p>
                </div>
                <div class="main">
                        <div class="tabs animated-slide-2">
                            <ul class="tab-links">
                                <li class="active"><a id='SexoM' href="#tab1111">CHICOS</a></li>
                                <li ><a id='SexoF' href="#tab2222">CHICAS</a></li>
                                <!-- <li ><a id='SexoN' href="#tab3333">DBL</a></li> -->
                                <li>Cat<a>
                                   <select  id="cmbcategoria"> 
                                        <option value="12">12</option>
                                        <option value="14">14</option>
                                        <option value="16">16</option>
                                        <option value="18">18</option>
                                        <option value="PV">PV</option>
                                        <option value="PN">PN</option>
                                    </select>
                                </a>
                               </li>

                            </ul>
                            
                            <div class="tab-content">
                                <div id="tab1111" class="tab active">
                                <table class="tab-score">
                                  <!-- <tr class="top-scrore-table"><td class="score-position">POS.</td><td>Jugadores</td><td>NAT.</td><td>POINTS</td></tr>
      -->
                                  <!-- <tr><td class="score-position">1.</td><td><a href="single_player.html">Rodak Noraky </a></td><td><img src="images/flags/serbia.png" alt="" /></td><td>12770</td></tr>
                                  <tr><td class="score-position">2.</td><td><a href="single_player.html">David Doe<span class="newrecord">New Record</span></a></td><td><img src="images/flags/argentina.png" alt="" /></td><td>10670</td></tr>
                                  <tr><td class="score-position">3.</td><td><a href="single_player.html">Richar Stay</a></td><td><img src="images/flags/uk.png" alt="" /></td><td>7490</td></tr>
                                  <tr><td class="score-position">4.</td><td><a href="single_player.html">Mirek Roy</a></td><td><img src="images/flags/brazil.png" alt="" /></td><td>5985</td></tr>
                                  <tr><td class="score-position">5.</td><td><a href="single_player.html">Rober Perrer</a></td><td><img src="images/flags/japan.png" alt="" /></td><td>4765</td></tr>
                                  <tr><td class="score-position">6.</td><td><a href="single_player.html">Milos Vigo</a></td><td><img src="images/flags/canada.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">7.</td><td><a href="single_player.html">Tomas Teddy<span class="fastball">Fast Ball</span></a></td><td><img src="images/flags/czech.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">8.</td><td><a href="single_player.html">Grigor Fred</a></td><td><img src="images/flags/bulgaria.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">9.</td><td><a href="single_player.html">Andy Murray</a></td><td><img src="images/flags/spain.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">10.</td><td><a href="single_player.html">Jfried Tsonga</a></td><td><img src="images/flags/france.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">11.</td><td><a href="single_player.html">Kei Milosh</a></td><td><img src="images/flags/japan.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">12.</td><td><a href="single_player.html">Ernests Gulbis</a></td><td><img src="images/flags/argentina.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">13.</td><td><a href="single_player.html">Martin Gotro</a></td><td><img src="images/flags/argentina.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">14.</td><td><a href="single_player.html">Riard Paquet</a></td><td><img src="images/flags/france.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">15.</td><td><a href="single_player.html">John Isner</a></td><td><img src="images/flags/serbia.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">16.</td><td><a href="single_player.html">Marin Cilic</a></td><td><img src="images/flags/italy.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">17.</td><td><a href="single_player.html">Fabio Bigot</a></td><td><img src="images/flags/canada.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">18.</td><td><a href="single_player.html">Tommy Rotmans</a></td><td><img src="images/flags/brazil.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">19.</td><td><a href="single_player.html">Paolo Bautista</a></td><td><img src="images/flags/italy.png" alt="" /></td><td>4225</td></tr>
                                  <tr><td class="score-position">20.</td><td><a href="single_player.html">Kevin Anderfig</a></td><td><img src="images/flags/germany.png" alt="" /></td><td>4225</td></tr> -->
                                  <div class="top-score-title col-md-12 right-title">
                                    <h3 id="results"></h3>
                                   
                                  </div>                    
                                </table>
                                </div>
                                
                            </div>
                            <div class="score-view-all">
                                <div class="pagination" id="score-view-all">

                                </div>
                            </div>
                        </div>
                    </div>
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

        <<section id="sponsor" class="container">
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

<script src="js/custom.js" type="text/javascript"></script>   
<script src="js/jsjs/ranking.js" type="text/javascript"></script>   

</body>
</html>
