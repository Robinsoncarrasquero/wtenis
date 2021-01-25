<?php
session_start();

require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';
require_once '../funciones/funciones.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}

$mensaje=null;
if (isset($_REQUEST['atleta_id']))
{
    $atleta_id=  htmlspecialchars($_REQUEST['atleta_id']);
//    echo '<pre>';
//    var_dump($_REQUEST['atleta_id']);
//    echo '</pre>';
    
    $objeto = new Atleta();
    
    $objeto->Find($atleta_id);
    if ($objeto->Operacion_Exitosa())
    {
        $cedula= $objeto->getCedula();
        $nombres= $objeto->getNombres();
        $apellidos= $objeto->getApellidos();
        $sexo = $objeto->getSexo();
        $fecha_nacimiento= $objeto->getFechaNacimiento();
        $estado =$objeto->getEstado();
        $email=$objeto->getEmail();
             
    }
    
    
}
else
{
   header('Location: atletaRead.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Datos de Afiliado</title>
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
            <h2>Modificacion de Datos Basicos</h2>
            
           
        </div>
    </div>
</div> 
   
   <div class="signin-form">

    <div class="container">
        <div class="row">   
            <div class="col-xs-12">
                <form class="form-signin" method="post" id="register-form" >    


                <div class="form-group col-xs-12 col-md-4">
                    <label for="codigo">CEDULA:</label>
                    <input class="form-control" type="text" name="cedula" maxlength="20" placeholder="cedula" required value="<?php echo $cedula;?>">
                </div>   
                <div class="form-group col-xs-12 col-md-4">
                   <label for="nombre">NOMBRES:</label>
                    <input class="form-control" type="text" name="nombres" maxlength="50" placeholder="nombres" required value="<?php echo $nombres;?>"> 
                </div>
                <div class="form-group col-xs-12 col-md-4">
                    <label for="apellidos">APELLIDOS:</label>
                    <input class="form-control" type="text" name="apellidos" maxlength="50" placeholder="apellidos" required value="<?php echo $apellidos;?>"> 
                </div>
                <div class="form-group col-xs-12 col-md-4">
                    <label for="estado">ESTADO:</label>
                    <input class="form-control" type="text" name="estado" value="<?php echo $estado;?>">
                </div>
                <div class="form-group col-xs-12 col-md-4">
                    <label for="sexo">SEXO</label>
                    <select name="sexo" class="form-control">
                        <?php
                        {
                            if ($sexo=="F"){
                                echo '<option selected value="F">Femenino</option>';
                                echo '<option value="M">Masculino</option>';
                            }else{
                                echo '<option value="F">Femenino</option>';
                                echo '<option selected value="M">Masculino</option>';
                            }
                        }            
                        ?>
                    </select>
                </div>

                <div class="form-group col-xs-12 col-md-4">
                    <label for="fecha_nacimiento">FECHA DE NACIMIENTO:</label>
                    <input class="form-control" type="date" name="fecha_nacimiento" required value="<?php echo $fecha_nacimiento;?>">
                </div>
                <div class="form-group col-xs-12 col-md-4">
                    <label for="email">EMAIL:</label>
                    <input class="form-control" type="email" name="email" maxlength="50" placeholder="example@gmail.com" value="<?php echo $email;?>"> 
                </div>

                
            </form>

                            
            <div id="error" class="span6 col-xs-12">          
                <label for="respuesta"><?php echo $mensaje;?></label>
         
            </div>
            <div class="form-group col-xs-12">
                    <button type="button" class="btn btn-primary" name="btn-close" id="btn-close">
                        <span class="glyphicon glyphicon-folder-close"></span> &nbsp; Cerrar
                    </button>
                <button type="submit" class="btn btn-warning" name="btn-save" id="btn-submit">
                        <span class="glyphicon glyphicon-floppy-save"></span> &nbsp; Guardar
                    </button> 
            </div>  
         
        </div>
    </div>
    </div>
   </div>
<script>

$(document).ready(function (){
    
    
    
       
//    $('#btn-submit').click(function(){
//        alert("alerta");
//    });
   
    //Aqui regresamos a una direccion referenciada
    $('#btn-close').click(function(){
        alert("alerta vamos a cerrar windows");
         window.close();   
         
            
    });
    
    
    
    


});



	
</script>
    </body>
</html>


