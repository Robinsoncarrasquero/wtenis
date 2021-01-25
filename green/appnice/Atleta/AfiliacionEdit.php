<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
//Cargamos las nacionalidades desde el archivo de configuracion

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if ($_POST['txt_search']!=""){
        $nacionalidad=1;
        $ObjAtleta= new Atleta();
        $ObjAtleta->Fetch(0,$_POST['txt_search']);

        //Llenamos una recordset con las entidades para hacer seleccion en listbox
        if ($ObjAtleta->Operacion_Exitosa()){
            $txt_id=$ObjAtleta->getID();
            $objNacionalidad = new Nacionalidad();
            $objNacionalidad->Find($ObjAtleta->getNacionalidadID());

        }
    }
        
}






?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Afiliacion</title>
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
        <div class="col-xs-8">
            <h2>Consulta de Atleta</h2>
           
            
            
        </div>
    </div>
</div>


<div class="signin-form">

    <div class="container">
       
         
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin " method="POST" id="register-form" >
                  
                <div class="form-group col-xs-12 ">
                    <label for="txt_search">Buscar ficha</label>
                    <input type="text" name="txt_search" placeholder="Cedula" >
                     <input type="submit" value="Buscar"> 
                 </div>
                   
            </div>
        </div>
             <div class="row">   
                    
                    <div class="form-group col-xs-12 col-sm-4">
                        <label for="txt_asociacion">Estado</label>
                        <select name="txt_asociacion" class="form-control">
                        <?php
                        // Recorremos todas las lineas del archivo
                        
                            echo  '<option value="'.$ObjAtleta->getEstado().'">'.$ObjAtleta->getEstado().'</option>'; 
                        
                        ?>
                            

                        </select>
                    </div>
                   

                    
                   <div class="form-group col-xs-12 col-sm-4">
                        <label for="txt_nacionalidad">Nacionalidad</label>
                        <select name="txt_nacionalidad" class="form-control">
                        <?php
                            echo  '<option value="'.$objNacionalidad->getPais().'">'.$objNacionalidad->getPais().'</option>'; 
                        ?>

                        </select>
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-4 ">
                    <label for="txt_cedula">Cedula</label>
                    <input type="text" class="form-control" lenght="20" id="txt_cedula" name="txt_cedula" value="<?php echo $ObjAtleta->getCedula()?>" >
                    </div>
                    
                     <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_nombres">Nombre</label>
                      <input type="text" class="form-control" lenght="50" id="txt_nombres" name="txt_nombres" value="<?php echo $ObjAtleta->getNombres()?>"  >
                    </div>


                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="txt_apellidos">Apellido</label>
                      <input type="text" class="form-control" lenght="50" id="txt_apellidos" name="txt_apellidos"value="<?php echo $ObjAtleta->getApellidos()?>"  >
                    </div>
                    
                   
                     <div class="form-group col-xs-12 col-sm-6">
                        <label for="txt_fechaNacimiento">Fecha Nacimiento</label>

                        <input type="date" class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento" value="<?php echo $ObjAtleta->getFechaNacimiento()?>">

                    </div>
                    
                     <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <label for="txt_cedularep">Cedula Representante</label>
                      <input type="text" class="form-control" lenght="20" id="txt_cedularep" name="txt_cedularep" value="<?php $ObjAtleta->getCedulaRepresentante()?>" >
                    </div>

                     <div class="form-group col-xs-12 col-sm-6 col-md-8">
                      <label for="txt_nombrerep">Nombre Representante</label>
                      <input type="text" class="form-control" lenght="50" id="txt_nombrerep" name="txt_nombrerep" value="<?php $ObjAtleta->getNombreRepresentante()?>" >
                    </div>



                     <div class="form-group col-xs-12">
                      <label for="txt_direccion">Direccion</label>
                      <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" value="<?php $ObjAtleta->getDireccion()?>"></textarea>
                    </div>

                     <div class="form-group col-xs-12 col-sm-4 col-md-4">
                      <label for="txt_telefonos">Telefono</label>
                      <input type="text" class="form-control"  id="txt_telefonos" name="txt_telefonos" value="<?php $ObjAtleta->getTelefonos()?>" >
                    </div>
                   <div class="form-group col-xs-12 col-sm-8 col-md-8">
                      <label for="txt_email">Email</label>
                      <input type="email" class="form-control" lenght="100" id="txt_email" name="txt_email" value="<?php $ObjAtleta->getEmail()?>" >
                    </div>

                    <div class="form-group hidden">
                      <label for="txt_id">Atleta</label>
                      <input type="text" class="form-control" id="txt_id" name="txt_id">
                    </div>  
                     <div id="error" class='span6'>
                    <!-- error will be showen here ! -->
                    </div>
<!--                    <div class="form-group col-xs-12">
                        <button  type="button" class="btn btn-primary btn-block" name="btn-salir" id="btn-salir">
                        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Regresar
                        </button> 
                    </div>  -->
                    

                </form>
        
            </div> 
        </div>
    </div>
       
</div>
<!-- /Content Section -->

<script>

$(document).ready(function (){
    
    
   
    
            
  
        
        
        
   
   
    
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link   
        
            
    });
    
    
    
    


});



	
</script>
	
 



    
    
 
</body>
</html>

