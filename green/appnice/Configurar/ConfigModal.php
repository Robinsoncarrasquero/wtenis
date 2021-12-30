<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}
$mensaje_error=" ";
$mensaje_exito="Edicion de Datos";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
          
    $txt_nombre=$_POST['txt_nombre'];
    $txt_direccion=$_POST['txt_direccion'];
    $txt_descripcion=$_POST['txt_descripcion'];
    $txt_telefonos=$_POST['txt_telefonos'];
    $txt_email=$_POST['txt_email'];
    $txt_twitter=$_POST['txt_twitter'];
    $txt_id=$_POST['txt_id'];
    $txt_estado=$_POST['txt_estado'];
    $txt_colorjumbotron=$_POST['txt_colorjumbotron'];
    $txt_bgcolorjumbotron=$_POST['txt_bgcolorjumbotron'];
    $txt_colorNavbar=$_POST['txt_colorNavbar'];
    $txt_banco=$_POST['txt_banco'];
    $txt_cuenta=$_POST['txt_cuenta'];
    $txt_rif=$_POST['txt_rif'];
   
    $obj = new Empresa();
    $obj->Fetch($_SESSION['asociacion']);
    if ($obj->Operacion_Exitosa()){
      $obj->setNombre($txt_nombre);
      $obj->setDireccion($txt_direccion);
      $obj->setDescripcion($txt_descripcion);
      $obj->setTelefonos($txt_telefonos);
      $obj->setEmail($txt_email);
      $obj->setTwitter($txt_twitter);
      $obj->setEstado($txt_estado);
      $obj->setColorJumbotron($txt_colorjumbotron);
      $obj->setbgColorJumbotron($txt_bgcolorjumbotron);
      $obj->setColorNavbar($txt_colorNavbar);
      //$obj->setFotos($summernote1);
      //$obj->setConstancia($summernote2);
      
      $obj->setBanco($txt_banco);
      $obj->setCuenta($txt_cuenta);
      $obj->setRif($txt_rif);
     
      $obj->Update();
        //echo "<div class='container'><span class=estiloError>Datos actualizados</span></div>";
       // echo json_encode(array("status" => "OK"));
       $mensaje_exito ="<div class='container'><span class=msgExito>Datos Actualizados con exito</span></div>";
   
    } else {
        //echo json_encode(array("status" => "FAIL", "error" => $operacion));
        $mensaje_error="<div class='container'><span class=msgError>Error Datos no Actualizados</span></div>";
   
    }

}else{
    $objEmpresa = new Empresa();
    $objEmpresa->Fetch($_SESSION['asociacion']);

    $rowid=$objEmpresa->get_Empresa_id();
    $txt_nombre=$objEmpresa->getNombre();
    $txt_descripcion=$objEmpresa->getDescripcion();
    $txt_direccion=$objEmpresa->getDireccion();
    $txt_email=$objEmpresa->getEmail();
    $txt_twitter=$objEmpresa->getTwitter();
    $txt_estado=$objEmpresa->getEstado();
    $txt_telefonos=$objEmpresa->getTelefonos();
    $txt_colorjumbotron=$objEmpresa->getColorJumbotron();
    $txt_bgcolorjumbotron=$objEmpresa->getbgColorJumbotron();
    $txt_colorNavbar=$objEmpresa->getColorNavbar();
    $txt_fotos=$objEmpresa->getFotos();
    $txt_constancia = $objEmpresa->getConstancia();
   
    $txt_banco=$objEmpresa->getBanco();
    $txt_cuenta=$objEmpresa->getCuenta();
    $txt_rif = $objEmpresa->getRif();
    $txt_federativa = $objEmpresa->getCartaFederativa();
   
  
}
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Constancias</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- awesone -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
   
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
            .msgError {
              color: red;
              animation: msgError 5s linear forwards;
                -webkit-animation: msgError 5s linear forwards;      
            }
            .msgExito {
              color: blue;
              animation: msgExito 5s linear forwards;
                -webkit-animation: msgExito 5s linear forwards;      
            }
            
    </style>
		
</head>
<body>
              
        

<!-- Content Section -->
<div class="container-fluid">
        <?php  
                //Menu de usuario
                include_once '../Template/Layout_NavBar_Admin.php';
                echo '<br><hr>';
        ?>
    
        <div class="row col-xs-12 col-md-12" >
           
            <div class="text text-center col-xs-12 col-md-12" >
                <h4>Configuracion</h4>
            </div>
        </div>

    <div class="col-xs-12" >
      
            
            
    <form  id="myform"  method="POST"   enctype="multipart/form-data"   > 
    <div class="msgExito text text-center " >
            <h2><?php echo $mensaje_exito?> </h2>
     </div>
     <div class="msgError text text-center " >
            <h2><?php echo $mensaje_error?> </h2>
     </div>
    <div class="form-group col-xs-12 col-md-12 ">
      <label for="txt_nombre">Nombre</label>
      <input type="text" class="form-control" lenght="50" id="txt_nombre" name="txt_nombre" placeholder="Nombre" value="<?PHP echo $txt_nombre?>">
    </div>
   <div class="form-group col-xs-12 col-md-12 ">
      <label for="txt_direccion">Direccion</label>
      <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"><?php echo $txt_direccion?> </textarea>
    </div>
   <div class="form-group col-xs-12 col-md-12 ">
      <label for="txt_descripcion">Descripcion</label>
      <textarea class="form-control" rows="5" lenght="250" id="txt_descripcion" name="txt_descripcion" placeholder="Descripcion"><?php echo $txt_descripcion?></textarea>
    </div>
    <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_rif">Rif</label>
      <input type="text" class="form-control" lenght="50" id="txt_rif" name="txt_rif" placeholder="Rif" value="<?php echo $txt_rif ?>">
    </div>
   <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_telefonos">Telefonos</label>
      <input type="text" class="form-control" lenght="50" id="txt_telefonos" name="txt_telefonos" placeholder="Telefonos" value="<?php echo $txt_telefonos ?> " >
    </div>
    <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_email">Email</label>
      <input type="text" class="form-control" lenght="100" id="txt_email" name="txt_email" placeholder="Email" value="<?php echo $txt_email ?> ">
    </div>
    <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_twitter">Twitter</label>
      <input type="text" class="form-control" lenght="30" id="txt_twitter" name="txt_twitter" placeholder="Twitter" value="<?php  echo $txt_twitter ?> ">
    </div>
    <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_banco">Banco</label>
      <input type="text" class="form-control" lenght="100" id="txt_banco" name="txt_banco" placeholder="Banco" value="<?php echo $txt_banco ?> ">
    </div>
    <div class="form-group col-xs-12 col-md-6 ">
      <label for="txt_cuenta">Numero de Cuenta</label>
      <input type="text" class="form-control" lenght="100" id="txt_cuenta" name="txt_cuenta" placeholder="Cuenta" value="<?php echo $txt_cuenta ?> ">
    </div>
    
     <div class="form-group col-xs-12 ">
      <label for="txt_estado">Asociacion</label>
      <input type="text" class="form-control" lenght="10" id="txt_estado" name="txt_estado" value="<?php echo $txt_estado ?>">
    </div>
    
    <?php echo '
    
    <div class="form-group col-xs-12 col-md-4 ">
      <label for="txt_colorjumbotron">Color Letras Jumbotron</label>
       <input type="color" class="form-control" id="txt_colorjumbotron" name="txt_colorjumbotron" value="'. $txt_colorjumbotron . '">
    </div>';
    ?>

    <?php echo '
    <div class="form-group col-xs-12 col-md-4 ">
      <label for="txt_colorNavbar">Color Barra Navegacion(NavBar)</label>
      <input type="color" class="form-control"  id="txt_colorNavbar" name="txt_colorNavbar" value="'. $txt_colorNavbar. '">
    </div>';
    ?>
    
    
    <?php echo ' 
     <div class="form-group col-xs-12 col-md-4 ">
      <label for="txt_bgcolorjumbotron">Color de Fondo(Background) Jumbotron</label>
       <input type="color" class="form-control" lenght="20" id="txt_bgcolorjumbotron" name="txt_bgcolorjumbotron" value="' . $txt_bgcolorjumbotron . '">
    </div>';
    ?>

    <!-- <div  class="form-group col-xs-12 hidden">
    <label for="txt_fotos">Fotos</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote1" name="contentfotos" placeholder="Cargue las fotos del site"  >
    .$txt_fotos.</textarea>
    </div> -->
    

    <!-- <div  class="form-group col-xs-12" >
    <label for="txt_constancia">CONTANCIA DE PARTICIPACION</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote2" name="contentcarta" placeholder="Escriba la constancia"  >
     <?php //echo $txt_constancia ?></textarea>
    </div>
    
    <div  class="form-group col-xs-12">
    <label for="txt_federativa">CONSTANCIA FEDERATIVA</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote3" name="contentfederativa" placeholder="Escriba la constancia"  >
    <?php //echo $txt_federativa?></textarea>
    </div>
     -->
    <div class="form-group col-xs-12">
        <!-- <button type="button" id="close" value="close" class="btn btn-default btnbtn">Cancelar</button> -->
        <input type="submit"  id="update" value="Guardar" class="btn btn-primary  btnbtn"> 


    </div>';
   </form>
   </div>
    
</div>
<!-- /Content Section -->


	
 
<script>

$(function (){
    
    
    //Cargamos el icono de ajaxloader y la lista de personas
    readRecords();
    
     
    //Buscamos que boton fue pulsado durante un update o new record
    // y cargar nuevamente los registros
    $('#myform').on('click','.btnbtn',function(e){
        // var contenfotosa =$('textarea[name="contentfotos"]').val();
        // var contenfotosb=$('#summernote1').summernote('code');
       
        // var contencartaa =$('textarea[name="contentcarta"]').val();
        // var contencartab=$('#summernote2').summernote('code');
        
        var contenfedea =$('textarea[name="contentfederativa"]').val();
        var contenfedeb=$('#summernote3').summernote('code');
        
        var op =$(this).attr('id'); // Nos indica que operacion Save o Close
//        if (contenfotosa!==contenfotosb){
//            alert("Los conteidos son diferentes submitted" + conten);
//        }
         if (op!=='close'){
            var f = $(this);
            var formData = new FormData(document.getElementById("myform"));
            formData.append("operacion", op);
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "ConfigModalSave.php",
                type: "POST",
                data:formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response){
               // var status = response.status;
                var status=response;
                $("#results").html("Respuesta: " + status);

                readRecords();
            })
            .fail(function( xhr, status, errorThrown ) {
            //alert( "Sorry, there was a problem!" );
            $("#results").html("Sorry, there was a problem: " + errorThrown);
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
            });
        }else{
           readRecords();

        }
        
        
        
    });
       
    
    
    //Editamos el registro nuevo o update
    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        //Cuando data-id es cero representa un nuevo registro y update debe ser mayor> 0 
        var x =$(this).attr('data-id');
        
           
            $("#results").html('');
//            $('#summernote').summernote('destroy');
            $( "#New" ).prop( "disabled", true );
            $.post("ConfigModalEdit.php",
            {operacion: "Edit",id: $(this).attr('data-id')}, 
            function(html){
                    //$('.modal-body').removeClass('loader');
                    //$('#results').html(html);
                    $('#list').html(html);
                    $('#summernote1').summernote({height: 300,lineHeigh: 50});
                    $('#summernote2').summernote({height: 300,lineHeigh: 50});
                    $('#summernote2').summernote({
                        
                       fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                        toolbar: [
                          // [groupName, [list of button]]
                          ['fontname', ['fontname']],
                          ['style', ['style']],
                          ['style', ['bold', 'italic', 'underline', 'clear']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['height', ['height']],
                          ['table', ['table']],
                          ['insert', ['link', 'picture']],
                          ['undo', ['undo']],
                          ['redo', ['redo']]

                        ]

                    });
                    
                    $('#summernote3').summernote({

                     fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                      toolbar: [
                        // [groupName, [list of button]]
                        ['fontname', ['fontname']],
                        ['style', ['style']],
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['undo', ['undo']],
                        ['redo', ['redo']]

                      ]

                    });
                  
                   
              }

        );
    });
   
    //Eliminar un Registro de la lista
    $(document).on('click','.delete-record',function(e)  {
        e.preventDefault();

        var conf = confirm("Estas Seguro de eliminar este registro? "+$(this).attr('data-id'));
        if (conf == true) {
            $.post("ConfigModalDelete.php", 
            {operacion:"Del",id: $(this).attr('data-id')},
            function (data, status) {
                // reload Users by using readRecords();
                //$("#results").html("Respuesta: " + data);
                readRecords();
            });
        }
    });
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });
    
    
    // Cargamos la lista de items
    function readRecords() {
      
        $('#list').html('');
        $('#list').addClass('loader');
        $("#list").load("ConfigModalList.php",function(){;
            $("#list").removeClass('loader');
        });
         $( "#New" ).prop( "disabled", false );

    }
 
// function summerNote(){
//    $('#txt_noticia').summernote({
//
//          height: 300,
//          onImageUpload: function(files, editor, welEditable) {
//              sendFile(files[0], editor, welEditable);
//          }
//   });
// }
    

   
function sendFile(file, editor, welEditable) {
   
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: 'ConfigModalSave.php',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
            editor.insertImage(welEditable, url);
        }
    });
}
 
    

   

    
    

});



	
</script>


    
    
 
</body>
</html>

