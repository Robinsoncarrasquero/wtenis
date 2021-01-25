<?php

/* 
 *Este programa cargas las imagenes en una carpeta especificada
 * Funciona con Bootstrap File Input Example
 */

$carpetaAdjunta="uploadimagenes/";
//Contamos todas las imagenes que envia el plugin
$Imagenes= count($_FILES['imagenes']['tmp_name']);
for($i=0;$i<$Imagenes;$i++){
    
    $nombreArchivo=$_FILES['imagenes']['name'][$i];
    $nombreTemporal=$_FILES['imagenes']['tmp_name'][$i];
    $rutaArchivo=$carpetaAdjunta.$nombreArchivo;
    move_uploaded_file($nombreTemporal,$rutaArchivo);
    $infoImagenesSubidas[$i]=array("caption"=>$nombreArchivo,"height"=>"120px","url"=>"borrar.php","key"=>$nombreArchivo);
    $imagenesSubidas[$i]='<img height="120px" src="'.$rutaArchivo.'" class="file-preview-image"';
    
}

//echo json_encode($arr);
echo json_encode(array("file_id"=>0));
