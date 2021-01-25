<?PHP
//Este programa canaliza la renovacion de afiliados desde el portal creando una variable de session
//para indicarnos el modo que esta el usuario.
//Luego lo invita a loguearse en caso que no este logueado para validar su cuenta y dirigirlo al modulo de 
//Renovacion.

session_start();
//Creamos las variable de session RENOVACION para saber la solicitud
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
     //die('Error fatal No pudo conectarse: ' . mysql_error());
    if (isset($_GET['id']) && ($_GET['id'])>0){
       $_SESSION['renovacion']= 'OK';
    }
}else{
    if (isset($_SESSION['renovacion'])){
        unset($_SESSION['renovacion']);
    }
}

header('Location: ../Login.php');






?>



    
