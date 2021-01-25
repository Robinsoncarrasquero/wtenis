<?php 
 function validaRequerido($valor){
    if(trim($valor) == ''){
       return false;
    }else{
       return true;
    }
 }
 function validarEntero($valor, $opciones=null){
    if(filter_var($valor, FILTER_VALIDATE_INT, $opciones) === FALSE){
       return false;
    }else{
       return true;
    }
 }
 function validaEmail($valor){
    if(filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE){
       return false;
    }else{
       return true;
    }
 }
 function leerArchivo($archivo){
    if(file_exists($archivo)){
       return file_get_contents($archivo);
    }else{
       throw new Exception('El archivo no se puede leer porque no existe.');
       return false;
    }
 }
// try{
//    $texto = leerArchivo('archivo_que_no_existe.txt');
//    echo $texto;
// }catch(PDOException $e){
//    echo $e->getMessage();
//    exit;
// }
?>

