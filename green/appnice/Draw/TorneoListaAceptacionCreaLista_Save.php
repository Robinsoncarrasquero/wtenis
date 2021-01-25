<?php
//Programa para guardar la lista de aceptacion modificada en la interfaz de control
session_start();

require_once '../sql/ConexionPDO.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once "../clases/Torneo_Categoria_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../clases/Torneos_cls.php';


if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}
//sleep(5);
//Esta variables viene con los valores key torneo,categoria, sexo separados por guion(-)
$key_id =explode("-",$_POST['tid']); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo

//Ubicamos la categoria del torneo
$objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
$objCategoria->Fetch($torneo_id, $categoria, $sexo);
$categoria_id=$objCategoria->get_id(); 
//Creamos la categoria en caso que no exista
if (!$objCategoria->Operacion_Exitosa()){
    
    $objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
    $objCategoria->create();
}
//Verificamos que no este publicada para poder modificar la lista de aceptacion
if ($objCategoria->getPublicar()==0){

    $datastr= json_decode($_POST['datajson'],true); // Categoria
    var_dump($datastr);
    
    $array = array_splice($datastr,0);
    $strTable2=$array;
    foreach ($array as $value) {
        $strTable .="<br>Poscion Lista:".$value["posicionlista"]."</br>";
        $atleta_id=$value["id"];
        $posicion_lista = $value["posicionlista"];
        $condicion = $value["condicion"];
       
        
        //Actualizamos la condicion de la lista de aceptacion segun la siguientes
        //condiciones 1=MDW 2=MWC 3 = QLY 4 QWC 5=ALT 6= RET
        $objInscripcion = new TorneosInscritos();
        $objInscripcion->Find_Atleta($torneo_id,$atleta_id);
        $condicion>0 ? $objInscripcion->setCondicion($condicion) : $objInscripcion->setCondicion(1);
        $objInscripcion->Update();


        
    }

    
}


 
//if ($ok) {
//    echo json_encode(array("status" => "OK"));
//} else {
//    echo json_encode(array("status" => "FAIL", "error" => $datos));
//}
//var_dump($strTable2);





   





    


