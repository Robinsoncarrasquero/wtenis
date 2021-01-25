<?PHP
//Este programa canaliza la renovacion de afiliados desde el portal creando una variable de session
//para indicarnos el modo que esta el usuario.
//Luego lo invita a loguearse en caso que no este logueado para validar su cuenta y dirigirlo al modulo de 
//Renovacion.

session_start();

$_SESSION['inscripcion']= 'OK';
   
//Creamos las variable de session Incripcion para saber la solicitud
    
if (isset($_SESSION['logueado']) && $_SESSION['logueado']) {
    header('Location: Inscripcion.php');
    exit;
}else{
    header('Location: ../../login.php');
    exit;
}
?>



    
