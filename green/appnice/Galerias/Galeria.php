<?php
session_start();

include_once '../funciones/funciones_bootstrap.php';
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../funciones/funcion_estados.php';

//echo 'Hello ' . htmlspecialchars(isset($_GET["asociacion"])? $_GET["asociacion"]:"nada") . '!';
//echo "</br>".$_SERVER['HTTP_HOST']; //   localhost 

//Viene metodo GET y se contruye un url virtual

//Galeria

//$key=  Encrypter::decrypt($_GET['tid']);
$key=  ($_GET['tid']);
$clave_array=explode(",",$key);
//var_dump($clave_array);
$codigo=$clave_array[0];

$torneo_id=$clave_array[1];

$objTorneo =new Torneo();
$objTorneo->Fetch($torneo_id);

$objEmpresa = new Empresa();

$objEmpresa->Find($objTorneo->getEmpresa_id());

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Galeria de Torneos">
    <meta name="author" content="Robinson Carrasquero">
    <title>Galeria del Torneo</title>
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="jquery.bsPhotoGallery.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="jquery.bsPhotoGallery.js"></script>
    
    <script>
      $(document).ready(function(){
        $('ul.first').bsPhotoGallery({
          "classes" : "col-lg-2 col-md-4 col-sm-3 col-xs-4 col-xxs-12",
          "hasModal" : true,
          //"fullHeight" : true
        });
      });
    </script>
  
  <style>
   // @import url(https://fonts.googleapis.com/css?family=Bree+Serif);

      body {
        background:#fff;
      }
      ul {
          padding:0 0 0 0;
          margin:0 0 40px 0;
      }
      ul li {
          list-style:none;
          margin-bottom:10px;
      }

    .text {
      /*font-family: 'Bree Serif';*/
      color:#666;
      font-size:11px;
      margin-bottom:10px;
      padding:12px;
      background:#fff;
    }
    .mititulo{
        color:#00c;
            
    }
    
     
  </style>
  </head>
  <body>
    <div class="container">

        <div class="row col-xs-4 ">
            <a  href="#"> <img src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
        </div>

    </div>
    <div class="container">
          
        <div class="text text-center mititulo col-xs-12 ">
          
            <h5 class="well well-sm">TORNEO <?php echo $objTorneo->getNombre() ." ".$objTorneo->getCodigo()?></h5>
        
        </div>
          <div class="text text-justify">
           
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label class="label label-default">Ano </label>
                    <?php echo $objTorneo->getAno()?>
                    
                </div>
                    
                 
                    
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label class="label label-default">Numero</label>
                   <?php echo $objTorneo->getNumero()?>
                    
                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4">
                   <label class="label label-default">Grado</label>
                  <?php echo $objTorneo->getTipo()?>

                </div>
                    
                <div class=" clearfix col-xs-4 col-sm-4 col-md-4">
                  <label class="label label-default">Categoria</label>
                 <?php echo $objTorneo->getCategoria()?>

                </div>
                    
                <div class="col-xs-4 col-sm-4 col-md-4">
                   <label class="label label-default">Sede</label>
                   <?php echo fun_Estado($objTorneo->getEntidad())?>

                </div>
                
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label class="label label-default">Organizador</label>
                    <?php echo strtoupper($objEmpresa->getEntidad())?>
                    
                </div>
                    
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label class="label label-default">Fecha Inicio </label>
                    <?php echo date("d-m-Y",strtotime($objTorneo->getFechaInicioTorneo()))?>
                    
                </div>
                    
                <div class=" col-xs-4 col-sm-4 col-md-4">
                    <label class="label label-default">Fecha Final </label>
                    <?php echo date("d-m-Y",strtotime($objTorneo->getFechaFinTorneo()))?>
                    
                </div>
            
          </div>
        
    </div> 
      
      <br>
       
     
 <?PHP
//El script se utiliza de forma modal para presentar una lista de items en una tabla y editarlos.


//Para generar las miga de pan mediante una clase estatica

 {
     
  echo '<div class="container">';
  
 }
?>
    
    

    <div class="container">
        <hr>
        <ul class="row first">

            <?php
            $folder = "../uploadFotos/torneos/" . $torneo_id . "/";
            fotos_torneo_galeria($folder);
            ?>

        </ul>
    </div> <!-- /container -->

        







  </body>


</html>




	


 




