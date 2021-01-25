<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}
 

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $empresa_id=$_SESSION['empresa_id'];
           
    $txt_nombre=$_POST['txt_nombre'];
    $txt_direccion=$_POST['txt_direccion'];
    $txt_descripcion=$_POST['txt_descripcion'];
    $txt_telefonos=$_POST['txt_telefonos'];
    $txt_email=$_POST['txt_email'];
    $txt_twitter=$_POST['txt_twitter'];
    $txt_id=$_POST['txt_id'];
    $txt_estado=$_POST['txt_estado'];
    $txt_colorjumbotron=$_POST['txt_colorjumbotron'];
    $txt_bgcolorjumbotron=$_POST['txt_bgcolorjumbotron'];
    $txt_colorNavbar=$_POST['txt_colorNavbar'];
    $txt_banco=$_POST['txt_banco'];
    $txt_cuenta=$_POST['txt_cuenta'];
    $txt_rif=$_POST['txt_rif'];
    $summernote1= $_POST['contentfotos']; // Fotos
    $summernote2= $_POST['contentcarta']; // Fotos
    $summernote3= $_POST['contentfederativa']; // Fotos
   
    
    $ok=FALSE;
    if (count($_FILES) > 0) {

        print_r(count($_FILES));
    }
    $autor = "Sys";
    if ($txt_id>0){

    //    print_r("REGISTRO NUMERO:".$txt_id);
        //Instanciamos el objeto y actualizamos datos

        $obj = new Empresa();
        $obj->Fetch($_SESSION['asociacion']);
        $obj->setNombre($txt_nombre);
        $obj->setDireccion($txt_direccion);
        $obj->setDescripcion($txt_descripcion);
        $obj->setTelefonos($txt_telefonos);
        $obj->setEmail($txt_email);
        $obj->setTwitter($txt_twitter);
        $obj->setEstado($txt_estado);
        $obj->setColorJumbotron($txt_colorjumbotron);
        $obj->setbgColorJumbotron($txt_bgcolorjumbotron);
        
        $obj->setColorNavbar($txt_colorNavbar);
        $obj->setFotos($summernote1);
        $obj->setConstancia($summernote2);
        
        $obj->setBanco($txt_banco);
        $obj->setCuenta($txt_cuenta);
        $obj->setRif($txt_rif);
        $obj->setCartaFederativa($summernote3);
        
        //echo $txt_id." ".$txt_src_imagen." ".$txt_mininoticia;
        $obj->Update();
        $$operacion=$obj->getMensaje();
        echo $obj->getMensaje();
        if ($obj->Operacion_Exitosa()){
            $ok=TRUE;
        }
        
        

    } elseif ($txt_id <1) {
        //Instanciamos el objeto empresa para traer los datos
        $obj = new Empresa();
        $obj->setNombre($txt_nombre);
        $obj->setDireccion($txt_direccion);
        $obj->setDescripcion($txt_descripcion);
        $obj->setTelefonos($txt_telefonos);
        $obj->setEmail($txt_email);
        $obj->setTwitter($txt_twitter);
        $obj->setEstado($txt_estado);
        $obj->setColorJumbotron($txt_colorjumbotron);
        $obj->setbgColorJumbotron($txt_bgcolorjumbotron);
        $obj->setColorNavbar($txt_colorNavbar);
        $obj->setFotos($summernote1);
        $obj->setConstancia($summernote2);
        $obj->setBanco($txt_banco);
        $obj->setCuenta($txt_cuenta);
        $obj->setRif($txt_rif);
        $obj->setCartaFederativa($summernote3);
        $obj->create();
        $operacion=$obj->getMensaje();
        echo $obj->getMensaje();
        if ($obj->Operacion_Exitosa()){
            $ok=TRUE;
        }
        

       
    }
    if ($ok) {
        echo json_encode(array("status" => "OK"));
    } else {
        echo json_encode(array("status" => "FAIL", "error" => $operacion));
    }
}
//header('Location: NoticiasModal.php');
exit;

?>
 

    
    

