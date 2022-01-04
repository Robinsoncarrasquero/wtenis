<?php
session_start();
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

require_once 'appnice/clases/Nacionalidad_cls.php';
require_once 'appnice/clases/Empresa_cls.php';
require_once 'appnice/sql/ConexionPDO.php';

$nacionalidad=1;
$rsNaciones= Nacionalidad::ReadAll();
$rsEntidades = Empresa::Entidades();

?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<title>Registro de Afiliados</title>
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
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />`
    <style type="text/css">
      #register-form fieldset:not(:first-of-type) {
      display: none;
    }
    </style>

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
<div class="col-sm-12">
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
      <div class="col-sm-12 size-img back-img">
          <div class="effect-cover">
              <h3 class="txt-advert animated">Registro de nuevos afiliados</h3>
              <p class="txt-advert-sub animated">Tu membresia de acceso para afiliarte a la federacion de tenis</p>
          </div>
      </div>

      <section id="login" class="container secondary-page">  
        <div class="general general-results players">
                <!-- REGISTER BOX -->
           <div class="top-score-title right-score col-sm-12">
            <h3>Register <span>Now</span><span class="point-int"> !</span></h3>
                
                <div class="col-md-12 login-page">
                  <div id="results" class="alert alert-danger results hide"></div>
                             
                      <form method="post" name="register-form" id="register-form" class="register-form" novalidate  action="register_save.php">         
   
                          <fieldset>
                              <h5>Paso 1: Cuenta de Usuario</h5>
                              <div class="email">
                                <label for="email">* Email:</label><div class="clear"></div>
                                <input id="email" name="email" type="text" maxlength="50" placeholder="example@domain.com" 
                                required=""/>
                              </div>
                              <div class="email">
                                <label for="confirm_email">* Confirmar Email:</label><div class="clear"></div>
                                <input id="confirm_email" name="confirm_email" type="text" maxlength="50" placeholder="example@domain.com" 
                                required=""/>
                              <required=""/>
                              </div>
                              <div class="name">
                                <label for="password">* Password:</label><div class="clear"></div>
                                <input id="password" name="password" maxlength="12" type="password" placeholder="********" required=""/>
                              </div>
                              <div class="confirm_password">
                                <label for="confirm_password">* Confirm Password:</label><div class="clear"></div>
                                <input id="confirm_password" name="confirm_password" maxlength="12" type="password" placeholder="********" required=""/>
                              </div>
                              <input type="button" class="next-form btn btn-info" value="Siguiente" />
                          </fieldset>
                          <fieldset>
                            <h5>Paso 2: Datos Personales</h5>
                            <div class="name">
                              <label for="txt_nombre">* Nombre:</label><div class="clear"></div>
                              <input id="txt_nombre" name="txt_nombre" type="text" maxlength="50" placeholder="ej. Jose Antonio" required=""/>
                            </div>
                            <div class="name">
                              <label for="txt_apellido">* Apellido:</label><div class="clear"></div>
                              <input id="txt_apellido" name="txt_apellido" type="text" maxlength="50" placeholder="ej. Rodriguez Moreno" required=""/>
                            </div>
                            <div class="sexo">
                              <label for="txt_sexo">Sexo</label><div class="clear"></div>
                                <select name="txt_sexo">
                                    <option  value="F">Femenino
                                    <option  value="M">Masculino
                                </select>
                            </div>
                            
                            <input type="button" name="previous" class="previous-form btn btn-default" value="Regresar" />
                            <input type="button" name="next" class="next-form btn btn-info" value="Siguiente" />
                          </fieldset>
                          <fieldset>
                            <h5>Paso 3: Datos Personales</h5>
                            <div class="fecha">
                              <label for="txt_fecha_nac">Fecha Nacimiento</label><div class="clear"></div>
                              <input type="date"   id="txt_fecha_nac" name="txt_fecha_nac" value="<?php echo date_format(date_create(),"Y-m-d") ?>">
                            </div>      
                            <div class="name">
                                <label for="txt_nacionalidad">Nacionalidad</label><div class="clear"></div>
                                <select name="txt_nacionalidad">
                                <?php
                                // Imprimos las nacionalidades
                                foreach ($rsNaciones as $record) {
                                   echo  '<option  value="'.$record['id'].'">'.$record['pais'].'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <div class="name">
                              <label for="name">* Cedula:</label><div class="clear"></div>
                              <input id="txt_cedula" name="txt_cedula" maxlength="12" type="text" placeholder=" Cedula" required=""/>
                            </div>
                            
                            <input type="button" name="previous" class="previous-form btn btn-default" value="Regresar" />
                            <input type="button" name="next" class="next-form btn btn-info" value="Siguiente" />
                          </fieldset>
                          
                          <fieldset>
                              <h5>Paso 4: Informacion de Contacto</h5>
                              <div class="name">
                                <label for="txt_celular">* Celular</label><div class="clear"></div>
                                <input type="text"  name="txt_celular" maxlength="20" id="txt_celular" placeholder="Celular">
                              </div>
                              <div class="name">
                                <label for="txt_telefonos"> Telefono</label><div class="clear"></div>
                                <input type="text"  name="txt_telefonos" maxlength="20" id="txt_telefonos" placeholder="Telefono">
                              </div>
                              <div class="name">
                                <label for="txt_direccion">* Direccion</label><div class="clear"></div>
                                <textarea  rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"></textarea>
                              </div>
                              <div class="name">
                                <label for="txt_lugar_trabajo">Lugar de Trabajo</label><div class="clear"></div>
                                <input type="text"  name="txt_lugar_trabajo" maxlength="30" id="txt_lugar_trabajo" placeholder="Lugar de Trabajo">
                              </div>
                              <input type="button" name="previous" class="previous-form btn btn-default" value="Regresar " />
                              <input type="button" name="next" class="next-form btn btn-info" value="Siguiente" />
                          </fieldset>
                          
                          <fieldset>
                            <h5>Paso 5: Datos Asociativos</h5>
                            <div class="name">
                                  <label for="txt_asociacion">Asociacion</label><div class="clear"></div>
                                  <select name="txt_asociacion">
                                    <?php
                                    // Imprimos las entidades
                                    foreach ($rsEntidades as $record) {
                                      echo  '<option value="'.$record['estado'].'">'.ucwords($record['entidad']).'</option>'; 
                                    }
                                    ?>
                                    ?>
                                  </select>
                              </div>
                              <div class="disciplina">
                              <label for="txt_disciplina">Disciplina</label> <div class="clear"></div>
                                <select name="txt_disciplina">
                                    <option  value="TDC">Tenis de Campo
                                    <option  value="TDP">Tenis de Playa
                                </select>
                            </div>

                              <input type="button" name="previous" class="previous-form btn btn-default" value="Regresar" />
                              <input type="submit" id="btn-submit" name="submit" class="btn btn-default" value="Registrar" />
                          </fieldset>
                          
                        
                    
                        <div id="mensaje"></div>

                      </form>
                      <div class="ctn-img">
                              <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <img src="images/federer.png" />
                      </div><!--Close Images-->
               
                       <div class="clear"></div>
           
                </div>

                
                
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
$(document).ready(function(){
  
  var form_count = 1, previous_form, next_form, total_forms;
  total_forms = $("fieldset").length;
  $(".next-form").click(function(){
    if (val_data(form_count)){
      previous_form = $(this).parent();
      next_form = $(this).parent().next();
      next_form.show();
      previous_form.hide();
      setProgressBarValue(++form_count);
    }
      
  });
  $(".previous-form").click(function(){
    previous_form = $(this).parent();
    next_form = $(this).parent().prev();
    next_form.show();
    previous_form.hide();
    setProgressBarValue(--form_count);
  });
  setProgressBarValue(form_count);
  
  function setProgressBarValue(value){
    var percent = parseFloat(100 / total_forms) * value;
    percent = percent.toFixed();
    $(".progress-bar")
      .css("width",percent+"%")
      .html(percent+"%");
  }

function ValidateEmail(email)
  {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(inputText.value.match(mailformat))
  {
    alert("You have entered an valido email address!");
    return true;
  }
  else
  {
    alert("You have entered an invalid email address!");
    return false;
  }
}
function ValidateEmail (valor){
  
  re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
  if(!re.exec(valor))
  {
		return false;
	}
  else 
    return true;
  
}



  function val_data(paso){
    
    var error_message ='';
    $('#results').addClass('hide').html("");
    $('#mensaje').removeClass('alert alert-danger').html("");
    if (paso==1){
      if(!$("#email").val() || !ValidateEmail($("#email").val())) {
        error_message+="<br>Debe indicar un Email Valido";
      }
      if($("#confirm_email").val()!==$("#email").val()) {
        error_message+="<br>El Email no coincide con el Email de Confirmacion";
      }
      
      if(!$("#password").val()) {
        error_message+="<br>Debe indicar un Password";
      }
      if(!$("#confirm_password").val()) {
        error_message+="<br>Debe Confirmar el Password";
      }
      if($("#confirm_password").val()!==$("#password").val() ) {
        error_message+="<br>El Password no coincide con el Password de Confirmacion";
      }
      
    }

    if (paso==2){
      if(!$("#txt_nombre").val()) {
        error_message+="<br>Debe indicar un Nombre";
      }
      if(!$("#txt_apellido").val()) {
        error_message+="<br>Debe indicar un Apellido";
      }
    
    }
    if (paso==3){
      if(!$("#txt_cedula").val()) {
        error_message+="<br>Debe indicar una Cedula";
      }
     
    }
    if (paso==4){
      if(!$("#txt_celular").val()) {
        error_message+="<br>Debe indicar un Celular";
      }
      if(!$("#txt_direccion").val()) {
        error_message+="<br>Debe indicar una direccion";
      }
     
    }
   
    // Display error if any else submit form
    if(error_message) {
      //$('#results').removeClass('hide').html(error_message);
      $('#mensaje').addClass('alert alert-danger').html(error_message);
      return false;
    }else{
      
      if(!$("#txt_nombre").val()) {
        error_message+="<br>Debe indicar un Nombre";
      }
      if(!$("#txt_apellido").val()) {
        error_message+="<br>Debe indicar un Apellido";
      }
       
      return true;
    }
  }
    
  $( "#register-form" ).submit(function(event) {
    
    var data=$("#register-form").serialize();
    $.ajax({
      url:"register_save.php",
      type:"POST",  
      data:data,
      success : function(data){
        if (data.Success){
      //    $('#results').removeClass('alert alert-danger hide').addClass('alert alert-success').html(data.msg);
         
          swal({
              title: "Registrado con exito. Será redirigido al Login para continuar con el proceso afiliativo",
              text: "Esta pantalla se cerrará en 5 segundos.",
              timer: 5000,
              showConfirmButton: false
          });

          $('#mensaje').removeClass('alert alert-danger').addClass('alert alert-success').html(data.msg);
          setTimeout(go_link, 1000);

        }else{
      //    $('#results').removeClass('alert alert-success hide').addClass('alert alert-danger').html(data.msg);
          $('#mensaje').removeClass('alert alert-success').addClass('alert alert-danger').html(data.msg);
          swal('Error','Registrado no fue realizado con exito','warning');
        }   

        
      }

    });
    //Fin ajax
    return false;


  });

function go_link(){
    window.location.replace("login.php");
 };


});


</script>
</body>
</html>
