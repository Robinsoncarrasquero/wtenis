<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';

if (!$_SERVER['REQUEST_METHOD'] == 'POST' || !isset($_SESSION['logueado']) || !$_SESSION['logueado']){
    //Si el usuario no está logueado redireccionamos al login.
    header('Location:../sesion_cerrar.php');
    exit;
}
$blnoperacion=false;
$msg="No fue realizada ninguna operacion de retiro de inscripcion.. !! " ;

//$adata = json_decode($_POST['data'],true);
//$myJSON='[{"name":"chkretirar[]","value":"644,3810,21234,12,RET"}]';

$adata=json_decode($_POST['data'],true);
$aretiros_ok=[];
foreach ($adata as $key=>$value) {
    $array_Datos = explode (',', $value['value']);
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
        $msg="Error retirando la inscripcion: " .mysql_error();
        $blnoperacion=false;
    
    }else{
        email_inscripcion("RET", $torneoid, $atleta_id, $categoria);
        $msg="El retiro fue realizado exitosamente dentro de los plazos establecidos!! " ;
        $blnoperacion=true;
        $record_retiro=["retiro"=>$torneo_inscrito_id];
        array_push($aretiros_ok,$record_retiro);
    }

}

$jsondata = array("Success" => $blnoperacion, "Mensaje"=>$msg,"Retirados"=>$aretiros_ok);   
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;

?>