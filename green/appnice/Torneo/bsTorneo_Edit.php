<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funcion_archivos.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Atleta_cls.php";

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
    header('Location: ../sesion_inicio.php');
    exit;
}

$niveluser=$_SESSION['niveluser'];
$id=0; //Torneo ID
//print_r($id);
$torneo_id=  0;
$codigo='';
$nombre = '';
$estatus = 'A';
$categoria = '';
$tipo = '';
$monto=0.00;
$iva=0.00;
$empresa_id=$_SESSION['empresa_id'];
$fsheet_tipo=NULL;$fsheet=NULL;
$draw_tipo= NULL;$draw=NULL;
$drawd_tipo= NULL;
$lista_tipo=NULL;
$horacierre="16:00:00";
$horainitorneo="08:00:00";
$horafintorneo="18:00:00";
$fecha_hoy=date("Y-m-d");
$fechainicio= fecha_date($fecha_hoy);
$fechainiciohora=  fecha_time($horainitorneo);
$fechacierre=  fecha_date($fecha_hoy);
$fechacierrehora= fecha_time($horacierre);
$fecharetiros=  fecha_date($fecha_hoy);
$fecharetiroshora=  fecha_time($horacierre);
$fecha_inicio_torneo=  fecha_date($fecha_hoy);
$fecha_inicio_torneo_hora=  fecha_time($horainitorneo);
$fecha_fin_torneo=  fecha_date($fecha_hoy);
$fecha_fin_torneo_hora=  fecha_time($horafintorneo);
$arbitro = NULL; $clavearbitro = NULL;
$anodenacimiento=NULL;
$condicion='C';
$modalidad='TDC';
$entidad=$_SESSION['asociacion']; // Entidad, asociacion o federacion
$disponiblidad='';// Bloquea el torneo desde nivel superior
          
//echo nl2br($entidad[0].$entidad[1]);

//Cargamos los anos permitidos desde el archivo de configuracion
//Numero de anos permitidos de la licencia
$archivo_torneo = fopen("../system/configtorneo.txt", "r");
// Recorremos todas las lineas del archivo
while(!feof($archivo_torneo)){
    // Leyendo una linea
    $traer = fgets($archivo_torneo);
    // Imprimiendo una linea
    //echo nl2br($traer);
    $ano[]=trim($traer);
    
}
// Cerrando el archivo
fclose($archivo_torneo);


//Cargamos los juegos desde el archivo de configuracion
//numeros de juegos del calendario
$archivo_games = fopen("../system/confignumgames.txt", "r");
// Recorremos todas las lineas del archivo
while(!feof($archivo_games)){
    // Leyendo una linea
    $games = fgets($archivo_games);
    // Imprimiendo una linea
    //echo nl2br($traer);
    $numgames=explode(',',$games);
    
}
// Cerrando el archivo
fclose($archivo_games);
$numeros=$numgames;

//Grado
//Cargamos el grado desde el archivo de configuracion
$archivo_grados = fopen("../system/configgrado.txt", "r");
// Recorremos todas las lineas del archivo
while(!feof($archivo_grados)){
    // Leyendo una linea
    $arraygrado = explode(',',fgets($archivo_grados));
    
    // Imprimiendo una linea
    //echo nl2br($traer);
    if (intval($arraygrado[1])<=$niveluser){
        $arr_tipos_grados[]=$arraygrado[0];//Grados
    }
    
}
// Cerrando el archivo
fclose($archivo_grados);


//Categoria
//Cargamos la categoria desde el archivo de configuracion
$archivo_categoria = fopen("../system/configcategoria.txt", "r");
// Recorremos todas las lineas del archivo
while(!feof($archivo_categoria)){
    // Leyendo una linea
    $arraydato = explode(';',fgets($archivo_categoria));
    
    // Imprimiendo una linea
    //echo nl2br($traer);
    if (intval($arraydato[1])<=$niveluser){
        $arrayCategoria[]=$arraydato[0];//Grados
    }
    
}
// Cerrando el archivo
fclose($archivo_categoria);


//Condicion
//Cargamos la condicion del torneo desde el archivo de configuracion
$archivo_condicion = fopen("../system/configcondicion.txt", "r");
// Recorremos todas las lineas del archivo
while(!feof($archivo_condicion)){
    // Leyendo una linea
    $arraydato = explode(',',fgets($archivo_condicion));
    $array_condicion[]=array('condicion'=>$arraydato[0],'descripcion'=>$arraydato[1]);
    
}
// Cerrando el archivo
fclose($archivo_condicion);


//Llenamos una arreglo con las entidades para hacer seleccion en listbox
if ($niveluser>9){
   $entidades=Empresa::Entidades();

}else{
   $entidades[]=array('estado'=>$_SESSION['asociacion']); // Entidad, asociacion o federacion

}

//Llenamos un listbox con los arbitros
$rsarbitros=  Atleta::ReadbyNivelUser(8);
$arbitro=0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Crear Torneo</title>
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
            <h2>Creacion de Torneo</h2>
        </div>
    </div>
</div>
   
<div class="signin-form">

    <div class="container">
        <div class="row">   
            <div class="col-xs-12">
            <form class="form-signin" method="post" id="register-form" enctype="multipart/form-data" >
               <div class="form-group col-xs-12 ">
                     <label  for="disponibilidad">Disponibilidad</label>
                     <select name="disponibilidad" class="form-control">
                    <?php
                        if ($disponiblidad=="D"){
                            echo '<option selected value="D">Deshabilitado</option>';
                            if ($niveluser > 9) {
                                echo '<option value="H">Habilitado</option>';
                            }
                        } else {
                            echo '<option selected value="H">Habilitado</option>';
                            if ($niveluser > 9) {
                                echo '<option value="D">Deshabilitado</option>';
                            }
                        }
                    ?>
                     </select>
                 </div>
                    
                <div class="form-group col-xs-12 col-sm-3">
                    <label for="anotorneo">Ano</label>
                    <select name="anotorneo" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($ano as $value) {
    
                        if ($value==date("Y")){
                            echo  '<option selected value="'.$value.'">'.$value.'</option>';
                       }else{
                           echo  '<option value="'.$value.'">'.$value.'</option>'; 
                       }
                    }
                    ?>

                   
                    </select>
                </div>
                
                <div class="form-group col-xs-12 col-sm-3">
                    <label for="numtorneo">Numero</label>
                    <select name="numtorneo" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($numeros as $value) {
    
                       // Imprimiendo una linea
                       
                        echo  '<option value="'.$value.'">'.$value.'</option>'; 
                       
                    }
                    ?>

                   
                    </select>
                </div>
                    
                <!-- Para determinar los grados -->
                
                <div class="form-group col-xs-12 col-md-3">
                    <label for="tipo">Grado</label>
                    <select name="tipo" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($arr_tipos_grados as $value) {
                        
                        if ($tipo==$value){
                            echo '<option selected value="'.$value.'">'.$value.'</option>';
                        }else{
                            echo  '<option value="'.$value.'">'.$value.'</option>'; 
                        }
                                
                    }
                    ?>

                   
                    </select>
                </div>
                
                <div class="form-group col-xs-12 col-md-3">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($arrayCategoria as $value) {
                        
                        if ($categoria==$value){
                            echo '<option selected value="'.$value.'">'.$value.'</option>';
                        }else{
                            echo  '<option value="'.$value.'">'.$value.'</option>'; 
                        }
                                
                    }
                    ?>

                   
                    </select>
                </div>
                
                
                <div class="form-group col-xs-12">
                    <label for="nacidos">Nacidos en fecha :(Solo para Torneos con una sola Categoria):</label>
                    <input type="text" class="form-control" name="anodenacimiento" placeholder="2001-2005"  value="<?php echo $anodenacimiento;?>"> 
                </div>
                              
                <div class="form-group col-xs-12 col-sm-3">
                    <label for="entidad">Entidad</label>
                    <select name="entidad" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    foreach ($entidades as $value) {
    
                       // Imprimiendo una linea
                      
                       if ($value[estado]==$entidad){
                            echo  '<option selected value="'.$value[estado].'">'.$value[estado].'</option>';
                           
                       }else{
                           echo  '<option value="'.$value[estado].'">'.$value[estado].'</option>'; 
                       }
                    }
                    ?>

                   
                    </select>
                </div>
                 <div class="form-group col-xs-12 col-md-6">
                     <label for="nombre">Nombre del Torneo:</label>
                     <input type="text" class="form-control" name="nombre" maxlength="50" placeholder="Copa Master "  value="<?php echo $nombre;?>"> 
                 </div>
                    
                <div class="form-group col-xs-12 col-sm-6">
                    <label for="modalidad">Modalidad</label>
                    <select name="modalidad" class="form-control">
                      <option selected value="TDC">Tenis de Campo</option>
                      <option value="TDP">Tenis de Playa</option>
                    </select>
                </div>
                  <div class="form-group col-xs-12 col-md-4">
                     <label  for="estatus">Estatus</label>
                     <select name="estatus" class="form-control">
                         <?php
                           if ($estatus=="A"){
                                echo '<option selected value="A">Activo</option>';
                                echo '<option value="I">Inactivo</option>';
                            }else{
                                echo '<option value="A">Activo</option>';
                                echo '<option selected value="I">Inactivo</option>';
                            }
                                     
                         ?>
                     </select>
                 </div>
                 <div class="form-group col-xs-12 col-md-4">
                     <label  for="condicion">Condicion</label>
                     <select name="condicion" class="form-control">
                         <?php
                         {
                            foreach ($array_condicion as $value) {
                                if ($condicion == $value[condicion]) {
                                    echo '<option selected value="' . $value[condicion] . '">' . $value[descripcion] . '</option>';
                                } else {
                                    echo '<option value="' . $value[condicion] . '">' . $value[descripcion] . '</option>';
                                }
                            }
                         }
         
                         ?>
                     </select>
                 </div>
                  
                 <div class="form-group col-xs-12 col-md-4">
                     <label for="monto">Monto:</label>
                     <input type="number" class="form-control" name="monto" placeholder="Monto"  value="<?php echo $monto;?>">
                 </div>
                <div class="form-group col-xs-12 col-md-4">
                     <label for="iva">IVA:</label>
                     <input type="number" class="form-control" name="iva" placeholder="iva"  value="<?php echo $iva;?>"> 
                 </div>
                    
                
                <div class="form-group col-xs-12 col-md-12">
                     <label for="arbitro">Arbitro:</label>
                     <select name="arbitro" class="form-control">
                         <?php
                         {
                            echo '<option selected value="' . '0' . '">' . 'POR ASIGNAR'. '</option>';
                            foreach ($rsarbitros as $value) {
                                echo '<option value="' . $value[atleta_id] . '">' . $value[nombres] ." ".$value[apellidos]. '</option>';
                            }
                         }
         
                         ?>
                     </select> 
                
                </div>
                
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fecha_inicio_torneo">FECHA INICIO DE TORNEO:</label>
                     <input type="date" class="form-control" id="fecha_inicio_torneo" name="fecha_inicio_torneo" value="<?php echo $fecha_inicio_torneo;?>">
                    <input type="time" class="form-control" id="fecha_inicio_torneo_hora" name="fecha_inicio_torneo_hora"   value="<?php echo $fecha_inicio_torneo_hora;?>">
                 </div>
                 
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fechacierre">FECHA DE CIERRE:</label>
                     <input type="date" class="form-control" name="fechacierre" value="<?php echo $fechacierre;?>">
                     <input type="time" class="form-control" name="fechacierrehora"   value="<?php echo $fechacierrehora;?>">
                  </div>
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fecharetiro">FECHA DE RETIROS:</label>
                     <input type="date" class="form-control" id="fecharetiros" name="fecharetiros" value="<?php echo $fecharetiros;?>">
                     <input type="time" class="form-control" id="fecharetiroshora" name="fecharetiroshora"   value="<?php echo $fecharetiroshora;?>">
                 </div>
                
                 <div class="form-group col-xs-12 col-md-6">
                     <label for="fecha_fin_torneo">FECHA CULMINACION:</label>
                     <input type="date" class="form-control" name="fecha_fin_torneo" value="<?php echo $fecha_fin_torneo;?>">
                    <input type="time" class="form-control" name="fecha_fin_torneo_hora"   value="<?php echo $fecha_fin_torneo_hora;?>">
                 </div>
                    
<!--                <div class="form-group col-xs-12 col-md-12">
                     <label for="fechainicio">FECHA DE INICIO DE INSCRIPCIONES:</label>
                     <input type="date" class="form-control" name="fechainicio" required value="<?php echo $fechainicio;?>">
                     <input type="time" class="form-control" name="fechainiciohora"   value="<?php echo $fechainiciohora;?>">
                 </div>-->

                 <div class="form-group col-xs-12 col-md-3 ">
                     <label for="fsheet">Fact Sheet:</label>
                     <input type="hidden" class="form-control" name="MAX_FILE_SIZE" value="16000000">
                     <input   type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba un factsheet aqui.</p>
                      <?php 
                      //header("Content-type: $fsheet_tipo");
                      if ($fsheet_tipo!=NULL){
                         echo '<a href="bsDescargar_PDF.php?id='.$torneo_id.'&doc=fsheet" target="_blank"> <img id="Logo" src="../images/fsheet.jpg" width="10%"></a>';
                      }
                      ?>
                 </div>
                

                 <div class="form-group col-xs-12 col-md-3">
                     <label for="draw">Draw Singles:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
                     <input   type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba un draw aqui</p>
                      <?php 
                     //header("Content-type: $draw_tipo");
                     if ($draw_tipo!=NULL){
                         echo '<a href="bsDescargar_PDF.php?id='.$torneo_id.'&doc=draw"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
                     }
                     ?>
                 </div>
                    
                 <div class="form-group col-xs-12 col-md-3">
                     <label for="draw">Draw Dobles:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
                     <input   type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba un draw aqui</p>
                      <?php 
                     //header("Content-type: $draw_tipo");
                     if ($drawd_tipo!=NULL){
                         echo '<a href="bsDescargar_PDF.php?id='.$torneo_id.'&doc=drawd"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
                     }
                     ?>
                 </div>
                
                <div class="form-group col-xs-12 col-md-3">
                     <label for="lista">Lista Aceptacion:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
                     <input   type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba una lista aqui</p>
                      <?php 
                     //header("Content-type: $draw_tipo");
                     if ($lista_tipo!=NULL){
                         echo '<a href="bsDescargar_PDF.php?id='.$torneo_id.'&doc=lista"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
                     }
                     ?>
                </div>

                <div class="form-group col-xs-12 hidden">
                    <label for="torneo_id">id</label>
                    <input type="text"   class="form-control" id="torneo_id" name="torneo_id"  value="<?php echo $torneo_id ?> ">
                </div>

                <div id="error" class="span6 col-xs-12">          

                </div>
                <div class="form-group col-xs-12">
                    <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                        <span class="glyphicon glyphicon-folder-close"></span> &nbsp; Cerrar
                    </button>
                    <button type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">
                        <span class="glyphicon glyphicon-floppy-save"></span> &nbsp; Guardar
                    </button> 
                </div>  
                
                    
            </form>

    </div>


    </div>
 </div>
<script>

$(document).ready(function (){
    
    
    //Validar Formulario
    $( "#register-form" ).validate( {
           ignore: "ignore",
            rules: {
                    codigo: {
                            required: true,
                            minlength: 2
                    },
                    nombre: "required",
            },
            messages: {
                    codigo: "Ingrese una codigo",
                    nombre: "Ingrese un Nombre",
            },
            
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                    // Add the `help-block` class to the error element
                    error.addClass( "alert alert-danger" );

                    if ( element.prop( "type" ) === "checkbox" ) {
                            error.insertAfter( element.parent( "label" ) );
                    } else {
                            error.insertAfter( element );
                    }
            },
            highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                    $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
            },
//          
            submitHandler: submitForm
           
    } );
   $("#xregister-form").on('click','#btn-submit',function(){
           submitForm();
       });  
    
    
   function submitForm(){     
            var data = new FormData(document.getElementById("register-form"));
            
            $.ajax({
                url: "bsTorneo_Save.php",
                type: "POST",
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function()
                {	
                    $("#error").fadeOut();
                    $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando.. espere ...');
                },
                success :  function(data)
                    {	
                        
                        if(!data.Success){
                            
                            $("#error").fadeIn(1000, function(){
                                 $("#btn-submit").html('<span class="glyphicon glyphicon-save"></span> &nbsp; Guardar');
     
                           });
                            alert("Datos invalidos "+data.Mensaje+" o Registro Duplicado")
                        }
                        else if(data.Success)
                        {
                            $("#btn-submit").html('<img src="../images/btn-ajax-loader.gif" /> &nbsp; Registrando espere...');
                            setTimeout('$(".form-signin").fadeOut(10, function(){ $(".signin-form").load("bsTorneo_Update_Success.php"); }); ',4000);
                            $("#btn-submit").addClass('disabled');
                        }
                        else{
                            $("#error").fadeIn(1000, function(){
                               $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; No hay cambios que guardar '+data.Mensaje+' !</div>');
//                               $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp;   Guardar');
                               $("#btn-submit").addClass('disabled');
                            });
                            alert("No hay datos que guardar "+data.Mensaje+" Continue...")
                     
                        }
                    }
                });
                return false;
    };
     
    //Aqui regresamos a una direccion referenciada
    $('#btn-close').click(function(){
         window.close();   
            
    });
 
});

	
</script>
    
</body>
</html>


