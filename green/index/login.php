<?php
date_default_timezone_set('America/La_Paz');


?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<title>mytenis Login de Acceso</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta name="author" content="mytenis"/>
<meta name="keywords" content="Asociaciones, Tenis, club, eventos deportivos,MyTenis, non-profit, junior, tennis, sport, deporte, magazine, non profit" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="copyright" content="(c)  System Enrollment" />
<meta name="robots" content="index,follow" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="Acceso al sistema de inscripciones online de clubes">
    
    
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href="css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

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

    <section class="drawer">
            <div class="col-md-12 size-img back-img">
             <div class="effect-cover">
                    <h3 class="txt-advert animated">mytenis Tour Credenciales</h3>
                    <p class="txt-advert-sub animated">Tu pase de acceso para experimentar la accion en el tour</p>
                 </div>
             </div>
      
    <section id="login" class="container secondary-page">  
      <div class="general general-results players">
           <div class="top-score-title right-score col-md-6">
                <h3>Bienvenido<span class="point-int"> !</span></h3>
                <div class="col-md-12 login-page login-w-page">
                   <p class="logiin-w-title">mytenis Tour necesitas una membresía de afiliacion para participar en el circuito de Tenis.</p>
                   <p>Son numerosos torneos para cada categoria y distintos lugares para visitar, crea la experiencia que se adapta a ti.
                   </p>
                   <h3><img class="ball-tennis" src="images/ball.png" alt=""/>mytenis informacion privilegiada del Tour</h3>
                   <p>Salga de la cancha y participe en los eventos de la gira nacional.</p>
                   <h3><img class="ball-tennis" src="images/ball.png" alt=""/>mytenis Tour Semanal</h3>
                   <p>Informe oficial del
                    calendario incluyendo los resultados</p>
                </div>
           </div><!--Close welcome-->
           <!-- LOGIN BOX -->
           <div class="top-score-title right-score col-md-6">
               <h3>Login<span> Now</span><span class="point-int"> !</span></h3>
                <div class="col-md-12 login-page">
                  <form method="post" class="login-form" id="login-form" >            
                        <div class="name">
                            <label for="name_login">Usuario:</label><div class="clear"></div>
                            <input id="name_login" name="name_login" type="text" placeholder="usuario" required=""/>
                        </div>
                        <div class="pwd">
                            <label for="password_login">Password:</label><div class="clear"></div>
                            <input id="password_login" name="password_login" type="password" placeholder="********" required=""/>
                        </div>
                        <div id="login-submit">
                            <input type="submit" value="Login"/>
                          
                        </div>
                                  
                  </form>
                    <div id="myerrors">
                    
                    </div>
      
                  
              </div>
                
           </div><!--Close Login-->
           <!-- REGISTER BOX -->
           <div class="top-score-title right-score col-md-12">
                
           </div><!--Close REgistration-->
          </div> 
        </section>
        <section id="sponsor" class="container">
            <!--SECTION SPONSOR-->
           <div class="client-sport client-sport-nomargin">
               <div class="content-banner">
                     <ul class="sponsor second">
                        <li><img src="img/img_descargadas/sponsor/img1.jpg" alt="273x133" /></li>
                        <li><img src="img/img_descargadas/sponsor/img2.png" alt="" /></li>
                        <li><img src="img/img_descargadas/sponsor/img3.png" alt="" /></li>
                        <li><img src="img/img_descargadas/sponsor/img1.jpg" alt="273x133" /></li>
                        <li><img src="img/img_descargadas/sponsor/img2.png" alt="" /></li>
                        <li><img src="img/img_descargadas/sponsor/img3.png" alt="" /></li>
                    </ul>
                </div>
          </div>
       </section>

        <!--FOOTER-->   
    <!--SECTION FOOTER--> 
    <section id="footer-tag">
      <div class="container">
        <div class="col-md-12">
         <div class="col-md-3">
            <h3>Sobre Nosotros</h3>
            <p>Gracias por visitar mytenis, nuestra mision es fomentar y reglamentar 
            el tenis de competencia nacional e internacional. Crear, Planificar, coordinar y ejecutar el plan anual de
             torneos oficiales para dar cumplimiento al calendario establecido. Brindar informacion y recursos sobre el tenis
             Federado.
         </div>
         <div class="col-md-3 cat-footer">
           <div class="footer-map"></div>
           <h3 class='last-cat '>Categorias</h3>
           <ul class="last-tips">
            <li><a href="register.php">Afiliarme</a></li>
            <li><a  href="tournaments.php">Torneos</a></li>
            <li><a  href="players.php">Players</a></li>
            <li><a  href="ranking.php">Ranking</a></li>
           </ul>
         </div>
         <div class="col-md-3">
            <h3>Noticias Recientes</h3>
            <ul class="footer-last-news">
               <li><img src="img/img_descargadas/cdavis/game1.jpg" alt="" /><p>El resto de las series del Grupo Mundial I han celebrado sus sorteos en la jornada del viernes.</p>
              </li>
              <li><img src="img/img_descargadas/cdavis/game1.jpg" alt "" /><p>Muñoz-Abreu perdió con Tearney, pero Martínez igualó la serie al vencer en tres sets al 1 neocelandés.
                  Victorias parciales de China Taipei, Noruega y Portugal.</p></li>
                  <li><img src="img/img_descargadas/cdavis/game1.jpg" alt="" /><p>Fusce risus metus, placerat in consectetur eu...</p></li>
            </ul>
         </div>
         <div class="col-md-3 footer-newsletters">
           <h3>Newsletters</h3>
           <form method="post" >     
               <div class="name">
                   <label for="name">* Nombre:</label><div class="clear"></div>
                   <input id="name" name="name" type="text" placeholder=" Nombre " required=""/>
               </div>
               <div class="email">
                   <label for="email">* Email:</label><div class="clear"></div>
                   <input id="email" name="email" type="text" placeholder="example@domain.com" required=""/>
               </div>
               <div id="loader">
                           <input type="submit" value="submit"/>
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
<script>
$(document).ready(function (){

  $('#login-form').on('submit',function(e){
    $("#myerrors").removeClass("alert alert-danger");
    $('#myerrors').html("");    
    var data = $("#login-form").serialize();
    $.ajax({
        url: "login_submit.php",
        type: "POST",
        data:data,
        success : function( data)
        {
          if (data.Success){
            location.href ="appnice/sesion_usuario.php";
          }else{
            $("#myerrors").addClass("alert alert-danger");
            $('#myerrors').html(data.msg);
      
          }
        }
    })
    return false;
  })

});

</script>
</body>
</html>
