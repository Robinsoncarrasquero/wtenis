<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';
require_once '../funciones/funcion_fecha.php';
require_once'../funciones/funcion_archivos.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Encriptar_cls.php';

if ( $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}
$niveluser=$_SESSION['niveluser'];
$mensaje=null;
if (isset($_GET['tid']))
{
    $torneo_id=  htmlspecialchars($_REQUEST['tid']);
//    echo '<pre>';
//    var_dump($_REQUEST['torneo_id']);
//    echo '</pre>';
    $objeto = new Crud();
    $objeto->table_name="torneo";
    $objeto->select="*";
    $objeto->from="torneo";
    $objeto->condition="torneo_id=$torneo_id";
    $objeto->Read();
    $records = $objeto->rows;
    foreach ($records as $record)
    {
        $codigo= $record['codigo'];
        $nombre= $record['nombre'];
        $monto= $record['monto'];
        $iva= $record['iva'];
        $estatus=$record['estatus'];
        $tipo = $record['tipo'];
        $categoria=$record['categoria'];
        $arbitro=$record['arbitro'];
        $condicion=$record['condicion'];
        $ano =$record['ano'];
        $entidad =$record['entidad'];
        $numero=$record['numero'];
        $disponiblidad=$record['disponibilidad'];// Bloquea el torneo desde nivel superior
          
        
        $objFiles = new Crud();
        $objFiles->table_name="torneo_archivos";
        $objFiles->select="*";
        $objFiles->from="torneo_archivos";
        $objFiles->condition="torneo_id=$torneo_id";
        $objFiles->Read();
        $rsArchivos = $objFiles->rows;
        $arrayArchivos=NULL;
        $fsheet_size=0;$draw_size=0;
        $fsheet_tipo=NULL;$draw_tipo=NULL;$drawd_tipo=NULL;$lista_tipo=NULL;
        foreach ($rsArchivos as $rsRow) {
            $arrayArchivos[]=array("Doc"=>$rsRow['documento'],'tipo'=>$rsRow['tipo'],'id'=>$rsRow['id']);
            if ($rsRow['doc']=="fs"){
                $fsheet_tipo=  $rsRow['tipo'];
            }
            if ($rsRow['doc']=="ds"){
                $draw_tipo=  $rsRow['tipo'];
            }
            if ($rsRow['doc']=="dd"){
                $drawd_tipo=  $rsRow['tipo'];
            }
            if ($rsRow['doc']=="la"){
                $lista_tipo=  $rsRow['tipo'];
            }
            
            
        }
        $objFiles=NULL;
        //Get file
        //header("Content-disposition: attachment; filename=$filename");
        //header("Content-length: $size");
        //header("Content-type: $type");
        //echo $content;

        $fechainicio= fecha_date($record['fechainicio']);
        $fechainiciohora=  fecha_time($record['fechainicio']);
        $fechacierre=  fecha_date($record['fechacierre']);
        $fechacierrehora= fecha_time($record['fechacierre']);
        $fecharetiros=  fecha_date($record['fecharetiros']);
        $fecharetiroshora=  fecha_time($record['fecharetiros']);
        $fecha_inicio_torneo=  fecha_date($record['fecha_inicio_torneo']);
        $fecha_inicio_torneo_hora=  fecha_time($record['fecha_inicio_torneo']);
        $fecha_fin_torneo=  fecha_date($record['fecha_fin_torneo']);
        $fecha_fin_torneo_hora=  fecha_time($record['fecha_fin_torneo']);
       
//        echo '<pre>';
//        var_dump($draw_tipo);
//         
//
//        echo '</pre>';
        
        //Llenamos una arreglo con las entidades para hacer seleccion en listbox
        if ($niveluser>9){
           $entidades=Empresa::Entidades();


        }else{
           $entidades[]=array('estado'=>$_SESSION['asociacion']); // Entidad, asociacion o federacion
        }
    }
    
}
else
{
    header("location: bsTorneo_Read.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Actualizar Draw</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    

    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
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
            <h2>Actualizar Draw</h2>
            
           
        </div>
    </div>
</div>
   
<div class="signin-form">

    <div class="container">
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin" method="post" id="register-form" enctype="multipart/form-data" >
                    
                <div class="form-group col-xs-12 col-md-6 ">
                    <label for="codigo">Codigo</label>
                    <select name="codigo" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    {
                            echo  '<option selected value="'.$codigo.'">'.$codigo.'</option>';
                           
                       
                    }
                    ?>

                   
                    </select>
                </div>  
                    
                 <div class="form-group col-xs-12 col-md-6">
                     <label  for="disponibilidad">Disponibilidad</label>
                     <select   name="disponibilidad" class="form-control">
                    <?php
                        if ($disponiblidad=="D"){
                            echo '<option selected value="D">Deshabilitado</option>';
                            if ($niveluser > 9) {
                                echo '<option  value="H">Habilitado</option>';
                            }
                        } else {
                            echo '<option selected value="H">Habilitado</option>';
                            if ($niveluser > 9) {
                                echo '<option  value="D">Deshabilitado</option>';
                            }
                        }
                    ?>
                     </select>
                 </div>
                 
                    
                  <div class="form-group col-xs-12 col-sm-3">
                    <label for="anotorneo">Ano</label>
                    <select  name="anotorneo" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    {
                            echo  '<option selected value="'.$ano.'">'.$ano.'</option>';
                           
                       
                    }
                    ?>

                   
                    </select>
                </div>
                    
                <div class="form-group col-xs-12 col-sm-3 ">
                    <label for="numtorneo">Numero</label>
                    <select  name="numtorneo" class="form-control">
                    <?php
                   {
                       
                        echo  '<option value="'.$numero.'">'.$numero.'</option>'; 
                       
                    }
                    ?>

                   
                    </select>
                </div>
                
                    
                <div class="form-group col-xs-12 col-md-3">
                     <label for="tipo">Grado:</label>

                     <select name="tipo" class="form-control">
                         
                         <?php
                         {
                             
                            echo  '<option value="'.$tipo.'">'.$tipo.'</option>'; 
                            
                         }            
                         ?>
                     </select>
                 </div>
                  <div class="form-group col-xs-12 col-md-3">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" class="form-control">
                        <?php
                        echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="anodenacimiento">Nacidos en Fecha:(Torneos con una sola categoria):</label>
                    <input type="text" class="form-control" name="anodenacimiento" placeholder="NACIDOS EN 2001-2005"  value="<?php echo $anodenacimiento;?>"> 
                </div>
                    
                <div class="form-group col-xs-12 col-sm-6">
                    <label for="entidad">Entidad</label>
                    <select name="entidad" class="form-control">
                    <?php
                    // Recorremos todas las lineas del archivo
                    {
                           // echo  '<option selected value="'.$value.'">'.$entidad.'</option>';
                           
                       
                    }
                    ?>
                        
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
                    
                    <input readonly="readonly" type="text" class="form-control" name="nombre" maxlength="50" placeholder="Torneo"  value="<?php echo $nombre;?>"> 
           
                   
                 </div>
                    
                 <div class="form-group col-xs-12 col-sm-6 ">
                    <label for="modalidad">Modalidad</label>
                    <select  name="modalidad" class="form-control">
                      <option selected value="TDC">Tenis de Campo</option>
                      
                    </select>
                </div>
                
                <div class="form-group col-xs-12 col-md-6">
                     <label  for="estatus">Estatus</label>
                     <select  name="estatus" class="form-control">
                         <?php
                         if ($disponiblidad!='D') //Deshabilitado
                         {

                             if ($estatus=="A"){
                                 echo '<option readonly="readonly" selected value="A">Activo</option>';
                                 
                             }else{
                                 echo '<option readonly="readonly" selected value="I">Inactivo</option>';
                             }
                         }else{
                              echo '<option readonly="readonly" selected value="I">Inactivo</option>';
                         }          
                         ?>
                     </select>
                 </div>
                    
                <div class="form-group col-xs-12 col-md-4">
                     <label  for="condicion">Condicion</label>
                     <select name="condicion" class="form-control">
                         <?php
                         {
                            switch ($condicion) {
                            case "X":
                                
                                echo '<option selected value="X">Cancelado</option>';
                                
                                break;
                            case "S":
                                
                                echo '<option selected value="S">Suspendido</option>';
                                
                                break;
                            case "D":
                               
                                 echo '<option selected value="D">Diferido</option>';
                                break;
                            default:
                                echo '<option selected value="C">Calendario</option>';  
                               
                                break;
                             }
                             
                             
                         }            
                         ?>
                     </select>
                 </div>
                  
                 <div class="form-group col-xs-12 col-md-4">
                 
                     <label for="monto">Monto:</label>
                     <input readonly="readonly" type="number" class="form-control" name="monto" placeholder="Monto"  value="<?php echo $monto;?>">
                 </div>
                <div class="form-group col-xs-12 col-md-4">
                     <label for="iva">IVA:</label>
                     <input readonly="readonly" type="number" class="form-control" name="iva" placeholder="iva"  value="<?php echo $iva;?>"> 
                 </div>
                 
                <div class="form-group col-xs-12 col-md-12">
                     <label for="arbitro">Arbitro:</label>
                     <input readonly="readonly" type="text" class="form-control" name="arbitro" placeholder="Nombre Arbitro"  value="<?php echo $arbitro;?>"> 
                 </div>
                
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fecha_inicio_torneo">FECHA INICIO DE TORNEO:</label>
                    <input readonly="readonly" type="date" class="form-control" id="fecha_inicio_torneo" name="fecha_inicio_torneo" value="<?php echo $fecha_inicio_torneo;?>">
                    <input readonly="readonly" type="time" class="form-control" id="fecha_inicio_torneo_hora" name="fecha_inicio_torneo_hora"   value="<?php echo $fecha_inicio_torneo_hora;?>">
                 </div>
                 
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fechacierre">FECHA DE CIERRE:</label>
                     <input readonly="readonly" type="date" class="form-control" name="fechacierre" value="<?php echo $fechacierre;?>">
                     <input readonly="readonly" type="time" class="form-control" name="fechacierrehora"   value="<?php echo $fechacierrehora;?>">
                  </div>
                <div class="form-group col-xs-12 col-md-6">
                     <label for="fecharetiro">FECHA DE RETIROS:</label>
                     <input readonly="readonly" type="date" class="form-control" id="fecharetiros" name="fecharetiros" value="<?php echo $fecharetiros;?>">
                     <input readonly="readonly" type="time" class="form-control" id="fecharetiroshora" name="fecharetiroshora"   value="<?php echo $fecharetiroshora;?>">
                 </div>
                
                 <div class="form-group col-xs-12 col-md-6">
                     <label for="fecha_fin_torneo">FECHA CULMINACION:</label>
                     <input readonly="readonly" type="date" class="form-control" name="fecha_fin_torneo" value="<?php echo $fecha_fin_torneo;?>">
                    <input readonly="readonly" type="time" class="form-control" name="fecha_fin_torneo_hora"   value="<?php echo $fecha_fin_torneo_hora;?>">
                 </div>
                    
<!--                <div class="form-group col-xs-12 col-md-12">
                     <label for="fechainicio">FECHA DE INICIO DE INSCRIPCIONES:</label>
                     <input type="date" class="form-control" name="fechainicio" required value="<?php echo $fechainicio;?>">
                     <input type="time" class="form-control" name="fechainiciohora"   value="<?php echo $fechainiciohora;?>">
                 </div>-->



                 <div class="form-group col-xs-12 col-md-3 hidden ">
                     <label for="fsheet">Fact Sheet:</label>
                     <input type="hidden" class="form-control" name="MAX_FILE_SIZE" value="16000000">
                     <input type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba un factsheet aqui.</p>
                      <?php 
                      //header("Content-type: $fsheet_tipo");
                      if ($fsheet_tipo!=NULL){
                         echo '<a href="../Descargar_PDF.php?id='.$torneo_id.'&doc=fsheet" target="_blank"> <img id="Logo" src="../images/fsheet.jpg" width="10%"></a>';
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
                        echo '<a href="Download_Doc.php?thatid='.urlencode(Encrypter::encrypt($torneo_id)).
                            '&thatdoc='.urlencode(Encrypter::encrypt('ds')).'"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
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
                        echo '<a href="Download_Doc.php?thatid='.urlencode(Encrypter::encrypt($torneo_id)).
                        '&thatdoc='.urlencode(Encrypter::encrypt('dd')).'"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
                   }
                   ?>
                </div>
                
                
                <div class="form-group col-xs-12 col-md-3 hidden">
                     <label for="lista">Lista Aceptacion:</label>
                     <input readonly="readonly" type="hidden" name="MAX_FILE_SIZE" value="16000000">
                     <input readonly="readonly"  type="file" class="form-control" name="fsheet[]"  >
                     <p class="help-block">Suba una lista aqui</p>
                      <?php 
                     //header("Content-type: $draw_tipo");
                     if ($lista_tipo!=NULL){
                         echo '<a href="../Descargar_PDF.php?id='.$torneo_id.'&doc=lista"  target="_blank"> <img id="Logo"  src="../images/fsheet.jpg" width="10%"></a>';
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
<!--            </div>-->

    </div>


    </div>
 </div>
<script>

$(document).ready(function (){
    
    
    //Validar Formulario
    $( "#register-form" ).validate( {
           ignore: "ignore",
        
            rules: {
                    
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
                    $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
            },
            success :  function(data)
                {	

                    if(data.Success)
                    {
                        $("#btn-submit").html('');

                        $("#btn-submit").html('<img src="../images/btn-ajax-loader.gif" /> &nbsp; Registrando espere...');
                        setTimeout('$(".form-signin").fadeOut(10, function(){ $(".signin-form").load("bsTorneo_Update_Success.php"); }); ',4000);
                        $("#btn-submit").addClass('disabled');
                    
                    }else{
                        $("#error").fadeIn(1000, function(){
                             $("#btn-submit").html('<span class="glyphicon glyphicon-save"></span> &nbsp; Guardar');

                        });
                        alert("Datos invalidos "+data.Mensaje+" o Registro Duplicado")

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


