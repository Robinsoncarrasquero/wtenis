<?php

function Contenido_Blob($tmpName) {
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    return addslashes($content);
    
}


//Funcion para subir un archivo a una carpeta del servidor
function upload_file($file_load,$array_numero,$file_name,$forder_destino) {
    
    $posicion_array=$array_numero; // 0;
    $carpetaDestino=$forder_destino; //"../FILE_RANKING/"; 
    $nombreArchivo=$_FILES[$file_load]['name'][$posicion_array];
    $ext=  strtolower(end(explode(".",$_FILES[$file_load]['name'][$posicion_array])));
    $nombreTemporal=$_FILES[$file_load]['tmp_name'][$posicion_array];
    $tipoArchivo=$_FILES[$file_load]['type'][$posicion_array];

    $nuevo_nombre=$file_name; //$disciplina_Filtro."_".$fecha_rk."_".$categoria_Filtro.$sexo_Filtro.".xls";
    $rutaArchivo=$carpetaDestino.$nuevo_nombre;
    $extensiones_permitidas=array("pdf","jpg","png","xls","xlsx","doc","docx","odc","odx");

    $jsondata = array("Success" =>FALSE,"Mensaje"=>"Sorry, Archivo No fue subido ");
    if (in_array($ext, $extensiones_permitidas)){
        return move_uploaded_file($nombreTemporal,$rutaArchivo);
    } else{
        return FALSE;
    }

   

}

//Obtener la extension de un archivo subido basados en el nombre subido
function get_extension($str) 
{
    return end(explode(".", $str));
}


