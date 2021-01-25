<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$carpetaAdjunta="imagenes_/";
//Contamos todas las imagenes que envia el plugin
$Imagenes= count($_FILES['imagenes']);
for($i=0;$i<$Imagenes;$i++){
    
    $nombreArchivo=$_FILES['imagenes']['name'][$i];
    $nombreTemporal=$_FILES['imagenes']['tmp_name'][$i];
    $rutaArchivo=$carpetaAdjunta.$nombreArchivo;
    move_uploaded_file($nombreTemporal,$rutaArchivo);
    $infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","height"=>"120px","url"=>"borrar.php","key"=>$nombreArchivo);
    $imagenesSubidas[$i]='<img height="120px" src="$rutaArchivo" class="file-preview-image"';
    
}
$arr = array("file_id"=>0,"overwriteInitial"=>true,"initialPreview"=>$imagenesSubidas);
echo json_encode($arr);
