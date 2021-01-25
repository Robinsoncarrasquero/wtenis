<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';

 if ($_SESSION['niveluser']!=9){
     header('Location: ../sesion_inicio.php');
 }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Noticias</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    

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
    
  
    <!-- awesone -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
   
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    
    
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
     
    
    


    
 	
		
</head>
<body>
    
<!-- Content Section -->
<div class="container">
   
        <div class="col-sx-12">
            <h3>Panel de Noticias</h3>
             <?php
            //Para generar las miga de pan mediante una clase estatica
            require_once '../clases/Bootstrap2_cls.php';
            echo Bootstrap::breadCrumNoticias();

            ?>
            <div class="pull-right">
<!--               <a href="sesion_usuario_admin.php"> <button id="btn-salir" type="button" class="btn btn-primary">Regresar</button></a>
        -->
                <button class="btn btn-success edit-record"  data-id="0" id="New">Add New</button>
            </div>
<!--            <div class="my-return">
             </div>-->
        </div>
    
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Noticia:</h3>
            
                <form  id="myform"  method="POST"   enctype="multipart/form-data"> 
                    <div id="list">
                    </div>
                         
                    
                </form>
                <div id="results" class="col-md-12 span6">          

                </div>
            <div id="summernote" class="col-md-12 span6">          

                </div>
        </div>
    </div>
</div>
<!-- /Content Section -->

 <div class="embed-responsive embed-responsive-16by9">
     <object class="embed-responsive-item" data="../pdf/example.pdf" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="../pdf/example.pdf">here</a>.</p>
    </object>
</div> 
	
 


  
    
 
</body>
</html>

