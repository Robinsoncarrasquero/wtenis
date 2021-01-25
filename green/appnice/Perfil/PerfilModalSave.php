<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';


$operacion=$_POST['operacion'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $txt_id=$_POST['txt_id'];
    $txt_cedula = $_POST['txt_cedula'];
    $txt_nombres=$_POST['txt_nombres'];
    $txt_apellidos=$_POST['txt_apellidos'];
    $txt_sexo=$_POST['txt_sexo'];
    $txt_fechaNacimiento=$_POST['txt_fechaNacimiento'];
    $txt_biografia=$_POST['txt_biografia'];
    $txt_cedularep=$_POST['txt_cedularep'];
    $txt_nombrerep=$_POST['txt_nombrerep'];
    $txt_direccion=$_POST['txt_direccion'];
    $txt_telefonos=$_POST['txt_telefonos'];
    $txt_email=$_POST['txt_email'];
    
    
    
    $ok=FALSE;
    
    
    if ($txt_id>0){

    //    print_r("REGISTRO NUMERO:".$txt_id);
        //Instanciamos el objeto atleta y actualizamos los datos

        $obj = new Atleta();
        $obj->Fetch($txt_id);
        //$obj->getCedula($txt_cedula);
        $obj->setNombres($txt_nombres);
        $obj->setApellidos($txt_apellidos);
        $obj->setSexo($txt_sexo);
        $obj->setFechaNacimiento($txt_fechaNacimiento);
        $obj->setBiografia($txt_biografia);
        $obj->setCedulaRepresentante($txt_cedularep);
        $obj->setNombreRepresentante($txt_nombrerep);
        $obj->setDireccion($txt_direccion);
        $obj->setTelefonos($txt_telefonos);
        $obj->setEmail($txt_email);
        
        
        //echo $txt_id." ".$txt_src_imagen." ".$txt_mininoticia;
        $obj->Update();
        $operacion=$obj->getMensaje();
        
        
        if ($obj->Operacion_Exitosa()){
            $ok=TRUE;
        }
        
        $obj= NULL;

    } elseif ($txt_id <1) {
        //Instanciamos el objeto empresa para traer los datos
        $obj = new Atleta();
        $obj->getCedula($txt_cedula);
        $obj->setNombres($txt_nombres);
        $obj->setApellidos($txt_apellidos);
        $obj->setSexo($txt_sexo);
        $obj->setFechaNacimiento($txt_fechaNacimiento);
        $obj->setBiografia($txt_biografia);
        $obj->setCedulaRepresentante($txt_cedularep);
        $obj->setNombreRepresentante($txt_nombrerep);
        $obj->setDireccion($txt_direccion);
        $obj->setTelefonos($txt_telefonos);
        $obj->setEmail($txt_email);
        $obj->create();
        $operacion=$obj->getMensaje();
       
         
        if ($obj->Operacion_Exitosa()){
            $ok=TRUE;
        }
        $obj= NULL;

       
    }
    if ($ok) {
        
        echo json_encode(array("status" => "OK"));
    } else {
        echo json_encode(array("status" => "FAIL", "error" => $operacion));
    }

    
}
    

exit;

?>
 

    
    

