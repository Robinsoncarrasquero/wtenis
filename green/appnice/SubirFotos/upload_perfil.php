<?php
session_start();
/* 
 *Este programa cargas las imagenes en una carpeta especificada
 * Funciona con Bootstrap File Input Example
 */
//if ($_SESSION['niveluser']>0){
//    header("location : ../Login.php");
//}

$carpetaAdjunta="../".$_SESSION['url_foto_perfil']; 
//$carpetaAdjunta ="../uploadfotos/perfil/";
//Contamos todas las imagenes que envia el plugin
$Imagenes= count($_FILES['imagenes']['tmp_name']);
for($i=0;$i<$Imagenes;$i++){
   
    
    $nombreArchivo=$_FILES['imagenes']['name'][$i];
    $nombreTemporal=$_FILES['imagenes']['tmp_name'][$i];
    $rutaArchivo=$carpetaAdjunta.$nombreArchivo;
    $filePerfil=trim($_REQUEST['kvId']);
    $archivo_perfil=$carpetaAdjunta.$filePerfil;
   
//    if(file_exists($filedelete) && $nombreArchivo!="ftdefault.jpg"){
//        
//        copy($fichero, $nuevo_fichero);
//    }
    
    move_uploaded_file($nombreTemporal,$rutaArchivo);
    //rename($rutaArchivo,$archivo_perfil);
    copy($rutaArchivo, $archivo_perfil);
    
    
}

//echo json_encode($arr);
echo json_encode(array("file_id"=>0));
