<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';

require_once '../funciones/funcion_fecha.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Atleta_cls.php';
if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $email =$_SESSION['email'];
    
       
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
 }
if ( $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}



$id=$_GET['id'];
//$id=1300;




//$id= 3;
//Obtenemos el jugador editado via ajax segun id
$objDraw1 = new Torneo_Draw();
$objDraw1->Fetch($id);
//Obtenemos el numero de la ronda representada como en la tabla R1,R2,R3,R4
$ronda= Torneo_Draw::Ronda($objDraw1->getCategoria_id(),$objDraw1->getRonda());

      

//Instanciamos el jugador contrincante y se ubica por la posicion del id del jugador
$objDraw2 = new Torneo_Draw();
$objDraw2->FindContrincante($objDraw1->getCategoria_id(),$objDraw1->getRonda(), $objDraw1->getPosicion());
if ($objDraw1->getPosicion() % 2==0){
    $objDrawJugador2 = $objDraw1;
    $objDrawJugador1 = $objDraw2;
}else{
    $objDrawJugador2 = $objDraw2;
    $objDrawJugador1 = $objDraw1;
}
$win=0;
$status=$objDrawJugador1->getStatus();
if ($objDrawJugador1->getWin()>0){
    $win=1;
    $status=$objDrawJugador1->getStatus();
}elseif($objDrawJugador2->getWin()>0){
    $win=2;
    $status=$objDrawJugador2->getStatus();
}
//Decodificamos el puntaje de los juegos para ajustalos a los input de los arbitros
//segun su argot de score que acostumbran a colocar, dando rapidez al cargar el
//score del juego finalizado.
if ($win>0){
    
     
    $s1 = Reglas_Juego::ScoreSet_Decode_X($win,$objDrawJugador1->getS1(),$objDrawJugador2->getS1());
    $s2 = Reglas_Juego::ScoreSet_Decode_X($win,$objDrawJugador1->getS2(),$objDrawJugador2->getS2());
    $s3 = Reglas_Juego::ScoreSet_Decode_X($win,$objDrawJugador1->getS3(),$objDrawJugador2->getS3());

    if ($objDrawJugador1->getT1()+$objDrawJugador2->getT1() >=0){
        $t1=  Reglas_Juego::ScoreTB_Decode($objDrawJugador1->getT1(), $objDrawJugador2->getT1());
    }
    if ($objDrawJugador1->getT2()+$objDrawJugador2->getT2() >=0){
        $t2=  Reglas_Juego::ScoreTB_Decode($objDrawJugador1->getT2(), $objDrawJugador2->getT2());
    }
    if ($objDrawJugador1->getT3()+$objDrawJugador2->getT3() >=0){
        $t3=  Reglas_Juego::ScoreTB_Decode($objDrawJugador1->getT3(), $objDrawJugador2->getT3());
    }
}elseif($win==0){

    $s1 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getS1(),$objDrawJugador2->getS1());
    $s2 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getS2(),$objDrawJugador2->getS2());
    $s3 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getS3(),$objDrawJugador2->getS3());
    $t1 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getT1(),$objDrawJugador2->getT1());
    $t2 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getT2(),$objDrawJugador2->getT2());
    $t3 = Reglas_Juego::ScoreSetPizarra($objDrawJugador1->getT3(),$objDrawJugador2->getT3());
    
}

$objAtleta1 = new Atleta();
$objAtleta1->Find($objDrawJugador1->getJugador());

$objAtleta2 = new Atleta();
$objAtleta2->Find($objDrawJugador2->getJugador());


?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Editando un Juego</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    

    <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>-->
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>
    
  		
</head>
<body>
    
<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>Actualizar Juego</h2>
            
           
        </div>
    </div>
</div>
   
<div class="signin-form">

    <div class="container">
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin" method="post" id="register-form"   >
                 <div class="form-group col-xs-12 col-md-6">
                     <label for="ronda">Ronda:</label>
                     <input disabled type="text" class="form-control" name="ronda" maxlength="3"   value="<?php echo $objDrawJugador2->getRonda();?>">
                 </div>
                
                <div class="form-group col-xs-12 col-md-6">
                     <label for="juego">Juego:</label>
                     <input disabled type="text" class="form-control" name="juego" maxlength="3"   value="<?php echo $objDrawJugador2->getPosicion()/2;?>">
                 </div>
                
                
                <div class="form-group col-xs-12 col-md-5">  
                    <div class="radio">
                        <label>
                                                      
                            <input type="radio" name="optwin" id="optRj1" value="1" <?php if (isset($win) && $win==1) echo "checked"?>>
                            
                            <?php echo $objAtleta1->getNombreCompleto();?>
                        </label>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-md-2">
                     <label class="glyphicon glyphicon-user"></label>H2H
                     <label class="glyphicon glyphicon-user"></label>
                </div>
                
                <div class="form-group col-xs-12 col-md-5">  
                    <div class="radio">
                        <label>
                            <input type="radio" name="optwin" id="optRj2" value="2" <?php if (isset($win) && $win==2) echo "checked";?>>
                   
                           <?php echo $objAtleta2->getNombreCompleto();?>
                         
            
                        </label>
                    </div>
                </div>
                    
                <div class="form-group col-xs-12 col-md-12">
                     <label  for="status">Condicion</label>
                     <select name="status" class="form-control">
                         <?php
                         {
                            switch ($status) {
                            case "JU":
                                echo '<option selected value="JU">Jugado</option>';  
                                echo '<option value="WO">WO</option>';
                                echo '<option  value="RE">Retiro</option>';
                               
                                break;
                            case "WO":
                                echo '<option value="JU">Jugado</option>';  
                                echo '<option selected value="WO">WO</option>';
                                echo '<option value="RE">Retiro</option>';
                                break;
                            case "RE":
                                echo '<option value="JU">Jugado</option>';  
                                echo '<option value="WO">WO</option>';
                                echo '<option selected value="RE">Retiro</option>';
                                break;
                             case "BYE":
                                echo '<option selected value="BYE">BYE</option>';  
                                break;
                                
                            default:
                                 echo '<option selected value="JU">Jugado</option>';  
                                echo '<option value="WO">WO</option>';
                                echo '<option value="RE">Retiro</option>';
                                break;
                             }
                             
                             
                         }            
                         ?>
                     </select>
                 </div>
                    
                 
               
                <div class="form-group col-xs-12 col-md-4">
                   <label for="s1">Set 1:</label>

                   <input type="text" class="form-control" placeholder="puntos" id="s1" name="s1" value="<?php echo $s1 ?>">

                </div>
                    
                <div class="form-group col-xs-12 col-md-4">
                    <label for="s2">Set 2:</label>

                    <input type="text" class="form-control" placeholder="puntos" id="s2" name="s2" value="<?php echo $s2 ?>">

                </div>
                    
                    
                <div class="form-group col-xs-12 col-md-4">
                     <label for="s3">Set 3:</label>
                                                
                     <input type="text" class="form-control" placeholder="puntos" id="s3" name="s3" value="<?php echo $s3 ?>">
                    
                </div>
           
                <div class="form-group col-xs-12 col-md-4">
                     <label for="t1">TieBreak 1:</label>
                                                
                     <input type="text" class="form-control" placeholder="Tie Break 1" id="t1" name="t1" value="<?php echo $t1 ?>">
                    
                 </div>
                    
                 <div class="form-group col-xs-12 col-md-4">
                     <label for="t2">TieBreak 2:</label>
                                                
                     <input type="text" class="form-control" placeholder="Tie Break 2" id="t2" name="t2" value="<?php echo $t2 ?>">
                    
                 </div>
                    
                  <div class="form-group col-xs-12 col-md-4">
                     <label for="t3">TieBreak 3:</label>
                                                
                     <input type="text" class="form-control" placeholder="Tie Break 3" id="t3" name="t3" value="<?php echo $t3?>">
                    
                 </div>
                                 
                 
                <div class="form-group col-xs-12" hidden="hidden">
                    
                    <input  type="text" class="form-control" name="id"   value="<?php echo $id?>">
                 </div>

                 
                <div class="form-group col-xs-12">
                        <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                            <span class="glyphicon glyphicon-folder-close"></span> &nbsp; Salir
                        </button>
                        <?php
                        if ($status=='BYE'){
                           echo '<button disabled="" type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">';
                        }else{
                           echo' <button type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">';
                            
                        }
                       
                        ?>
                         <span class="glyphicon glyphicon-floppy-save"></span> &nbsp; Guardar
                        </button> 
                </div>  
                
                    
                </form>
<!--            </div>-->

    </div>


    </div>
 </div>
<script>

$(document).ready(function (){
    
    
    
    $("#register-form").on('click','#btn-submit',function(){
           submitForm();
    });  
    
    
   function submitForm(){     
   //$('#register-form').on('submit',function(e){
           
          
             //var data = new FormData(document.getElementById("register-form"));
            //formData.append("operacion", op);
           // data.append(f.attr("fsheet"), $(this)[0].files[0]);
           // data.append(f.attr("fsheet"), $(this)[0].files[1]);
            //var data = $("#register-form").serialize();
            //var data = $("#register-form");
            var data = new FormData(document.getElementById("register-form"));
            //data.append("operacion", "save");
            $.ajax({
                url: "TorneoDrawDraw_Update.php",
                type: "POST",
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function()
                {	
                        $("#error").fadeOut();
                        $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                        $("#btn-submit").addClass('disabled');
                },
                success :  function(data)
                    {	
                      
                        if(data==1){
                           
                            $("#error").fadeIn(1000, function(){
                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error o datos invalidos!</div>');

                                $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;'+data+'  Cerrar');
                                $("#btn-submit").addClass('disabled');

                            });

                        }
                        else if(data==0)
                        {
                            
                            $("#btn-submit").html('<img src="../images/btn-ajax-loader.gif" /> &nbsp; Registrando espere...');
                            setTimeout('$(".form-signin").fadeOut(10, function(){ $(".signin-form").load("TorneoDrawLista.php"); }); ',2000);
                            $("#btn-submit").addClass('disabled');
        
                        }
                        else{
                               
                            $("#error").fadeIn(1000, function(){

                               $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; No hay cambios que guardar '+data+' !</div>');
                               $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;   Guardar');
                               $("#btn-submit").addClass('disabled');

                            });

                        }
                    }
                });
                
               // return false;
           
        

    };
     
    //Aqui cerramos la window
    $('#btn-close').click(function(){
         window.close();
            
    });
    
    
    
    


});



	
</script>
    
</body>
</html>
