<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';

if (!$_SERVER['REQUEST_METHOD'] == 'POST' || !isset($_SESSION['logueado']) || !$_SESSION['logueado']){
    //Si el usuario no está logueado redireccionamos al login.
    header('Location:../sesion_cerrar.php');
    exit;
}

if (@$_POST['btnProcesar']){   
    
    //Aqui se ejecuta los retiros donde solo cambiamos el campo "ESTATUS" a RETIRO en la tabla de inscripciones
    if (isset($_POST['chkretirar'])){
        // Retirar incripciones
        foreach($_POST['chkretirar'] as $Datos){

            $array_Datos = explode (',', trim($Datos)); 
            //Creamos un array para extraer los datos
            $torneoid= $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            $categoria=  $array_Datos[3];
            $t_id = (int) $torneo_inscrito_id;
            //Delete suave
            $sql = "UPDATE torneoinscritos SET estatus='Retiro', condicion=9 WHERE torneoinscrito_id=$t_id";
            $result=mysql_query($sql);
            if (!$result) {
                echo "Error retirando inscripcion: " .mysql_error();
            }else{
                email_inscripcion("RET", $torneoid, $atleta_id, $categoria);
            }
        }
        mysql_close($conn);
        header('Location: Inscripcion_Retiros.php');
        exit;
    }
    //este funciona en el caso que el usuario haya presionado el bonto guardar pero no hizo
    //ningun cambio al formulario
    header("Location: Inscripcion_Retiros.php ");
    exit; 
}

?>


   

        

         
	
         
	
        
        
	
	


