<?php
date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html>

<html>
<head>
<title>System online </title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="author" content="mytenis"/>
<meta name="keywords" content="Tenis, club, eventos, deportivos,deporte, juniors, junior, tennis, sport, magazine" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="copyright" content="(c)  System Enrollment" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="Juega Tenis">
   
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'/>-->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

    <link href="css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--Clients-->
    <link href="css/own/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="css/own/owl.theme.css" rel="stylesheet" type="text/css" />


    <link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />
    
    <link href="css/minislide/flexslider.css" rel="stylesheet" type="text/css" />
    <link href="css/component.css" rel="stylesheet" type="text/css" />
    <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
    <link href="css/style_dir.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="css/animate.css" rel="stylesheet" type="text/css" />

</head>
<body>
<!--SECTION TOP LOGIN-->
     <section class="content-top-login">
           <div class="container">
      <div class="col-md-12">
           <div class="box-support"> 
             <p class="support-info"><i class="fa fa-envelope-o"></i> info@example</p>
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
        <header>
          <div class="content-logo col-md-12">
            <div class="logo"> 
              <img src="img/logo3.png" alt="" />
            </div>
            
            <div class="bt-menu"><a href="#" class="menu"><span>&equiv;</span> Menu</a></div>

            <div class="box-menu">
                <nav id="cbp-hrmenu" class="cbp-hrmenu">
                  <ul id="menu">    
                    <li><a class="lnk-menu active" href="index.php">Home</a></li>
                    <li><a class="lnk-menu" href="register.php">Afiliarme</a></li>
                    <li><a class="lnk-menu" href="tournaments.php">Torneos</a></li>
                    <li><a class="lnk-menu" href="players.php">Players</a></li>
                    <li><a class="lnk-menu" href="ranking.php">Ranking</a></li>
                  </ul>
                </nav>
            </div>
          
        </div>
	    </header>
     </section>
          <!--SECTION CONTAINER SLIDER-->
    <section id="summary-slider">
           <div class="general">
              <div class="content-result content-result-news col-md-12">
                <div id="textslide" class="effect-backcolor">
                  <div class="container">
                      <div class="col-md-12 slide-txt">
                          <p class='sub-result aft-little welcome linetheme-left'>Bienvenidos</p>
                          <p class='sub-result aft-little linetheme-right'><span class="point-big">.</span></p>
                      </div>
                  </div>
                </div>
              </div>
              <div id="slidematch" class="col-xs-12 col-md-12">
                  <div class="content-match-team-wrapper">
                     <span class="gdlr-left">Portugal</span>
                     <span class="gdlr-upcoming-match-versus">VS</span>
                     <span class="gdlr-right">New Zealand</span>
                  </div>
                  <div class="content-match-team-time">
                     <span class="gdlr-left"><?php echo date_format(date_create("2020-03-06 12:00:00"),"M-d-Y H:i:s");?></span>
                     <span class="gdlr-right">DAVIS CUP</span>
                  </div>
				  
               </div>
         </div>
    </section>
          <!-- SECTION NEWS SLIDER -->
     <section class="news_slide-over-color">
          <div class="news_slide-over"></div>
           <div class="container">
             <div class="col-xs-12 col-md-12 top-first-info">
               <div class="col-md-4">
                     <section class="slider">
                            <div id="slider" class="flexslider flexslider-attachments">
                                <ul class="slides">
                                  <li data-thumb="images/slider/mini-slider/thumb1.jpg"><img src="img/img_descargadas/cdavis/img3.jpg" alt=""/></li>
  	    	                        <li data-thumb="images/slider/mini-slider/thumb3.jpg"><img src="img/img_descargadas/cdavis/img5.jpg" alt=""/></li>
                                  <li data-thumb="images/slider/mini-slider/thumb4.jpg"><img src="img/img_descargadas/cdavis/img6.jpg" alt=""/></li>
                                </ul>
                            </div>
                            <div class="slide-news-bottom"><a href="#">Recibimiento</a><a class="i-ico" href="#"><i class="fa fa-angle-double-right"></i></a></div>
                     </section>
                </div>
                <div class="col-md-4">
                     <!-- <img src="http://placehold.it/1024x700" alt=""/> -->
                     <img src="img/img_descargadas/cdavis/img2.jpg" alt=""/>
  	    	                     
                     <div class="slide-news-bottom"><a href="#">Juegos Programados</a><a class="i-ico" href="#"><i class="fa fa-angle-double-right"></i></a></div>
                </div>
                <div class="col-md-4">
                     <!-- <img src="http://placehold.it/1024x700" alt=""/> -->
                     <img src="img/img_descargadas/cdavis/img1.jpg" alt=""/>
  	    	                     
                     <div class="slide-news-bottom"><a href="#">Nuestro Equipo</a><a class="i-ico" href="#"><i class="fa fa-angle-double-right"></i></a></div>
                </div>
             </div>
             <div class="col-xs-12 col-md-12 top-slide-info">
              <!-- <div class="col-xs-6 col-md-6">
                <div class="col-md-4 slide-cont-img"><a href="single_news.html"><img class="scale_image" src="http://placehold.it/614x428" alt=""/><i class="fa fa-video-camera"></i></a></div>
                <div class="event_date dd-date">May 01, 2014 5:50 am <div class="post_theme">Exlusive</div></div><h4> Stay Ahead of the curve</h4>
                <p>Quisque gravida libero sodales augue luctus elementum. In tristique faucibus diam, sit amet ultrices erat porttitor ut. Phasellus sit amet lorem sit amet orci lobortis mattis. Nulla venenatis, quam vitae pellentesque sollicitudin.</p>
              </div>
              <div class="col-xs-6 col-md-6">
                <div class="col-md-4 slide-cont-img"><a href="single_news.html"><img class="scale_image" src="http://placehold.it/614x428" alt=""/><i class="fa fa-picture-o"></i></a></div>
                <div class="event_date dd-date">May 01, 2014 5:50 am <div class="post_theme">Interview</div></div><h4> Stay Ahead of the curve</h4>
                <p>Quisque gravida libero sodales augue luctus elementum. In tristique faucibus diam, sit amet ultrices erat porttitor ut. Phasellus sit amet lorem sit amet orci lobortis mattis. Nulla venenatis, quam vitae pellentesque sollicitudin.</p>
                
              </div>
              <div class="col-xs-6 col-md-6 box-top-txt">
                <div class="col-md-4 slide-cont-img"><a href="single_news.html"><img class="scale_image" src="http://placehold.it/614x428" alt=""/><i class="fa fa-picture-o"></i></a></div>
                <div class="event_date dd-date">May 01, 2014 5:50 am</div><h4> Stay Ahead of the curve</h4>
                <p>Quisque gravida libero sodales augue luctus elementum. In tristique faucibus diam, sit amet ultrices erat porttitor ut. Phasellus sit amet lorem sit amet orci lobortis mattis. Nulla venenatis, quam vitae pellentesque sollicitudin.</p>
                
              </div>
              <div class="col-xs-6 col-md-6 box-top-txt">
                <div class="col-md-4 slide-cont-img"><a href="single_news.html"><img class="scale_image" src="http://placehold.it/614x428" alt=""/><i class="fa fa-video-camera"></i></a></div>
                <div class="event_date dd-date">May 01, 2014 5:50 am</div><h4> Stay Ahead of the curve</h4>
                <p>Quisque gravida libero sodales augue luctus elementum. In tristique faucibus diam, sit amet ultrices erat porttitor ut. Phasellus sit amet lorem sit amet orci lobortis mattis. Nulla venenatis, quam vitae pellentesque sollicitudin.</p>
                
              </div> -->
             </div>
           </div>
     </section>

     <section id="parallaxTraining">
        <div class="black-shad">
        <div class="container">
            <div class="col-md-12">
                <div class="txt-training">
                  <p>comienza a jugar</p>
                  <h2>ENTRENA HOY</h2>
                  <a href="#">Basic</a><a href="#">Medium</a><a href="#">Expert</a>
                </div>
            </div>
        </div>
      </div>
     </section>
    <!--SECTION Match TOP SCORE-->
    <section id="atp-match">
     
    </section>
    
    <!--SECTION NEXT MATCH-->
     <section id="next-match">
    
     </section>

     
     <!-- PARALLAX BLACK TENNIS-->
     <section class="bbtxt-content">

             
     </section>
     <!--SECTION STATISTIC RESULTS-->
     <section id="resultsPoint">
     
     </section>

     <section id="parallax-info">
    
     </section>
     
     <!-- SECTION SUBSCRIPTIONS-->
     <section class="bbtxt-content-subscription">
     
     </section>
     
     <!--SECTION LAST PHOTO-->
     <section id="news-section">
              
     </section>
     <!--SECTION CLIENTS-->
     <!-- <section class="container">
     
     </section>
      -->
     <!--SECTION TOP PRODUCTS-->
     <section class="top-product top-product-news">
        
     
     </section>
     <!--SECTION SPONSOR-->
     <section class="container">
           
     </section>
     <section id="sponsor" class="container">
            <!--SECTION SPONSOR-->
           <div class="client-sport client-sport-nomargin">
               <div class="content-banner">
                     <ul class="sponsor second">
                        
                    </ul>
                    <ul class="sponsor second">
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                      <li><img src="http://placehold.it/273x133" alt="" /></li>
                    </ul>
                </div>
          </div>
       </section>  
    <!--SECTION FOOTER--> 
    <section id="footer-tag">
           <div class="container">
             <div class="col-md-12">
             <div class="col-md-3">
            <h3>Sobre Nosotros</h3>
                <p>Gracias por visitar nuesto portal, nuestra mision es fomentar y administrar 
                el tenis de competencia estadal. Planificar, coordinar y ejecutar el plan anual de
                torneos para dar cumplimiento al calendario oficial establecido. Brindar informacion sobre el tenis
                del estado.
                
            </div>
              <div class="col-md-3 cat-footer">
                <div class="footer-map"></div>
                <h3 class='last-cat '>Categorias</h3>
                <ul class="last-tips">
                  <li><a href="register.php">Afiliarme</a></li>
                  <li><a href="tournaments.php">Torneos</a></li>
                  <li><a href="players.php">Players</a></li>
                  <li><a href="ranking.php">Ranking</a></li>
                </ul>
              </div>
              <div class="col-md-3">
              <h3>Noticias</h3>
              <ul class="footer-last-news">
                <li><img src="img/img_descargadas/cdavis/game1.jpg" alt="Foto" />
                  <p>El resto de las series del Grupo Mundial I han celebrado sus sorteos en la jornada del viernes.</p>
                </li>
                <li><img src="img/img_descargadas/cdavis/game1.jpg" alt="Doble" />
                  <p>Muñoz-Abreu perdió con Tearney, pero Martínez igualó la serie al vencer en tres sets al 1 neocelandés.</p>
                </li>
                <li><img src="img/img_descargadas/cdavis/game1.jpg" alt="Lorem isum" />
                  <p>Fusce risus metus, placerat in consectetur eu...</p>
                </li>
                </ul>
             </div>
              <div class="col-md-3 footer-newsletters">
                <h3>Newsletters</h3>
                <form method="post">     
                    <div class="name">
                        <label for="name">* Nombre:</label><div class="clear"></div>
                        <input id="name" name="name" type="text" placeholder=" Nombre " required=""/>
                    </div>
                    <div class="email">
                        <label for="email">* Email:</label><div class="clear"></div>
                        <input id="email" name="email" type="text" placeholder="example@domain.com" required=""/>
                    </div>
                    <div id="loader">
                                <input type="submit" value="Submit"/>
                        </div>
                </form>
              </div>
              <div class="col-xs-12">
                <ul class="social">
                      <li><a href=""><i class="fa fa-facebook"></i></a></li>
                      <li><a href=""><i class="fa fa-twitter"></i></a></li>
                      <li><a href=""><i class="fa fa-instagram"></i></a></li>
                      <li><a href=""><i class="fa fa-youtube"></i></a></li>
                      <!--
					  <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                      <li><a href=""><i class="fa fa-digg"></i></a></li> 
					  <li><a href=""><i class="fa fa-rss"></i></a></li>
                      <li><a href=""><i class="fa fa-tumblr"></i></a></li> 
					  -->

                    </ul>
              </div>
             </div>
           </div>
    </section>
    <footer>
    <div class="col-md-12 content-footer">
		<p>© 2020 mytenis All rights reserved. </p>
      </div>
	</footer>



<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="js/jquery.transit.min.js" type="text/javascript"></script>

<!--MENU-->
<script src="js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!--Mini Flexslide-->
<script src="js/minislide/jquery.flexslider.js" type="text/javascript"></script>

<!-- Percentace circolar -->
<script src="js/circle/jquery-asPieProgress.js" type="text/javascript"></script>
<script src="js/circle/rainbow.min.js" type="text/javascript"></script>

<!--Gallery-->
<script src="js/gallery/jquery.prettyPhoto.js" type="text/javascript"></script>
<script src="js/gallery/isotope.js" type="text/javascript"></script>

<!-- Button Anchor Top-->
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script src="js/jquery.bxslider.js" type="text/javascript"></script>

<!--Carousel News-->
<script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="js/jquery.mousewheel.js" type="text/javascript"></script>

<!--Carousel Clients-->
<script src="js/own/owl.carousel.js" type="text/javascript"></script>

<!--Count down-->
<script src="js/jquery.countdown.js" type="text/javascript"></script>

<script src="js/custom_ini.js" type="text/javascript"></script> 
 
</body>
</html>
