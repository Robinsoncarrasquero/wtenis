<?php
date_default_timezone_set('America/La_Paz');

?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<title>Login de Acceso</title>
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

    <!-- Bootstrap SWEETALERT-->
      <!-- <link href="../../sweetalert/css/bootstrap.min.css" rel="stylesheet"> -->
      <!-- Custom CSS -->
      <link href="sweetalert/css/main.css" rel="stylesheet">
      <!-- Scroll Menu -->
      <link href="sweetalert/css/sweetalert.css" rel="stylesheet">
      <!-- Bootstrap SWEETALERT-->
      <!-- <link href="../../sweetalert/css/bootstrap.min.css" rel="stylesheet"> -->
      <!-- jQuery (necessary for Bootstrap JavaScript plugins) -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <!-- <script src="../../sweetalert/js/bootstrap.min.js"></script> -->

      <!-- Custom functions file -->
      <script src="../../sweetalert/js/functions.js"></script>
      <!-- Sweet Alert Script -->
      <script src="../../sweetalert/js/sweetalert.min.js"></script>
        
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
 <header>
   <?php require_once 'menu.php' ?>
</header>
</section>

    <section class="drawer">
            <div class="col-md-12 size-img back-img">
             <div class="effect-cover">
                    <h3 class="txt-advert animated">Tenis Tour Credenciales</h3>
                    <p class="txt-advert-sub animated">Tu pase de acceso para experimentar la accion en el tour</p>
                 </div>
             </div>
      
    <section id="login" class="container secondary-page">  
      <div class="general general-results players">
           <div class="top-score-title right-score col-md-6">
                <h3>Bienvenido<span class="point-int"> !</span></h3>
                <div class="col-md-12 login-page login-w-page">
                   <p class="logiin-w-title">Tenis Tour necesitas una membresía de afiliacion para participar en el circuito.</p>
                   <p>Son numerosos torneos para cada categoria y distintos lugares para jugar, crea la experiencia que se adapta a ti.
                   </p>
                   <h3><img class="ball-tennis" src="images/ball.png" alt=""/>Tenis informacion actualizada de los juegos</h3>
                   <p>Salga de la cancha y participe en los eventos de la gira nacional.</p>
                   <h3><img class="ball-tennis" src="images/ball.png" alt=""/>Tenis Tour</h3>
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
                            <input id="name_login" name="name_login" type="text" placeholder="Cedula " required=""/>
                        </div>
                        <div class="pwd">
                            <label for="password_login">Password:</label><div class="clear"></div>
                            <input id="password_login" name="password_login" type="password" placeholder="********" />
                        </div>
                        
                        <div id="login-submit">
                            <input type="submit" value="Login" class="btn-login-submit"/>
                          
                        </div>
                        
                                  
                  </form>

                  <div id="myerrors" class="my-errors">

                  </div>
                  <div class="col-md-12 login-page">
                  <form method="post" class="remember-form" id="remember-form" > 
                        <div id="remember-submit">
                            <input type="submit" class=" btn-remember-key " value="Recordar la clave"/>
                          
                        </div>
                              
                        <div id="msg-remember-form" class="alert-remember-form">
                        
                        </div>
                        
                  </form>
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
<script>
$(document).ready(function (){

  const btnRememberKey = document.querySelector(".btn-remember-key");
  btnRememberKey.addEventListener('click',clear_msg);
  
  const btnLoginSubmit = document.querySelector(".btn-login-submit");
  btnLoginSubmit.addEventListener('click',clear_msg);
  
  const name_login = document.getElementsByName("name_login");

  //name_login.addEventListener('focus',clear_msg);
  
  $('#login-form').on('submit',function(e){
    
    let nameLogin = document.getElementById("name_login");
    if (nameLogin.value!='')
    {
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
              swal('Error','Debe especificar un usuario y clave valida','warning');
        
            }
          }
      })
    }else{
      swal('Error','Debe especificar un usuario y clave valida','warning');
     
     document.getElementById("name_login").focus();
     
   }
    return false;
  })
   
  $('#remember-form').on('submit',function(e){
    
    let nameLogin = document.getElementById("name_login");
    let msgRememberForm = document.querySelector(".alert-remember-form");
    if (nameLogin.value!='')
    {
      let data = $("#login-form").serialize();
      $.ajax({
          url: "login_remember_key.php",
          type: "POST",
          data:data,
          success : function( data)
          {
            if (data.success){
              
              msgRememberForm.textContent=data.msg;
              msgRememberForm.style.backgroundColor="black";
              msgRememberForm.style.color="white";
              msgRememberForm.classList.add('alert','alert-success');
              swal({
                title: "Un correo con la clave fue enviado a su cuenta de correo",
                text: "Se cerrará en 5 segundos.",
                timer: 5000,
                showConfirmButton: false
              });
            }else{
              msgRememberForm.textContent=data.msg;
              msgRememberForm.style.backgroundColor="red";
              msgRememberForm.style.color="white";
              msgRememberForm.classList.add('alert','alert-danger');
             
              swal("Error ", "Debe indicar una cuenta de usuario valida", "warning");
            }
        
            
          }
      })
    
    }else{
     
      document.getElementById("name_login").focus();
      
    }
    return false;
  })
  
  function clear_msg() {
    $("#msg-remember-form").html("");
    $("#msg-remember-form").removeClass("alert alert-success").removeClass('alert alert-danger');
    $("#myerrors").html("");
    $("#myerrors").removeClass("alert alert-success").removeClass('alert alert-danger');

    let msgRememberForm = document.querySelector(".alert-remember-form");
    msgRememberForm.classList.remove ('alert','alert-success');
    msgRememberForm.classList.remove('alert','alert-success');
    

       
  }
  
});

</script>

                

</body>
</html>
