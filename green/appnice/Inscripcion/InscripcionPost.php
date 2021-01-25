<?PHP
//Este programa canaliza la renovacion de afiliados desde el portal creando una variable de session
//para indicarnos el modo que esta el usuario.
//Luego lo invita a loguearse en caso que no este logueado para validar su cuenta y dirigirlo al modulo de 
//Renovacion.

session_start();


//Creamos las variable de session Incripcion para saber la solicitud
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
     //die('Error fatal No pudo conectarse: ' . mysql_error());
    $data=  htmlentities($_GET['id']);
    if (isset($_GET['id']) && ($_GET['id'])>0){
       $_SESSION['inscripcion']= 'OK';
    }
    if (isset($_SESSION['inscripcion'])){
        if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
            header('Location: bsInscripcion.php');
            exit;
       }
    }
   
}else{
    if (isset($_SESSION['inscripcion'])){
        unset($_SESSION['inscripcion']);
    }
    
}
header('Location: ../Login.php');
?>



    
