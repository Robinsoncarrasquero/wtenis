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
    $txt_constancia= $_POST['carta_torneo']; // Fotos
    $txt_federativa= $_POST['carta_federativa']; // Fotos

    $obj = new Empresa();
    $obj->Fetch($_SESSION['asociacion']);
    if ($obj->Operacion_Exitosa()){
  
      $obj->setConstancia($txt_constancia);
      $obj->setCartaFederativa($txt_federativa);

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
    $txt_federativa = $objEmpresa->getCartaFederativa();
    $txt_constancia = $objEmpresa->getConstancia();
   
  
}
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
 <title>Configuracion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- awesone -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
   
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  </head>
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
    
    
    <?php echo '
   <div  class="form-group col-xs-12">
    <label for="txt_constancia">CONSTANCIA DE PARTICIPACION</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote2" name="carta_torneo" placeholder="Escriba la constancia"  >'
    .$txt_constancia.'</textarea>
    </div>';
    ?>

    <?php echo '
    <div  class="form-group col-xs-12">
    <label for="txt_federativa">CONSTANCIA FEDERATIVA</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote3" name="carta_federativa" placeholder="Escriba la constancia"  >'
    .$txt_federativa.'</textarea>
    </div>';
    ?>
   
  
    <div class="form-group col-xs-12">
        <!-- <button type="button" id="close" value="close" class="btn btn-default btnbtn">Cancelar</button> -->
        <input type="submit"  id="update" value="Guardar" class="btn btn-primary  btnbtn"> 


    </div>';
   </form>
   </div>
    
</div>
<!-- /Content Section -->


	
 
<script>
$(document). ready(function(){

  //$('#summernote2').summernote({height: 300,lineHeigh: 50});
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
  //$('#summernote3').summernote({height: 300,lineHeigh: 50});
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

});      
   
	
</script>
 
</body>
</html>

