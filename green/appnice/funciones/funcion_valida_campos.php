<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//funcion valida datos para que evitar injection
function valida_input($data) {
   
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function valida_letras($valor){
    $name = valida_input($valor);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
    return $nameErr;
    
}
function is_valid_letras($valor){
  $name = valida_input($valor);
  
  return (false !== preg_match("/^[a-zA-Z ]*$/",$name));
  
}
function is_valid_email($email)
{
  $email = valida_input($email);
  return (false !== filter_var($email, FILTER_VALIDATE_EMAIL));
}
//La contraseña debe tener al menos entre 6 y 12 caracteres, 
//al menos un dígito, al menos una minúscula y al menos una mayúscula.
//Puede tener otros símbolos.
function is_valid_password_x($pwd){
  return (false !== preg_match("^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$",$pwd));
}
function is_valid_password($pwd){
  return (true == preg_match("/([A-Za-z0-9_])(?=\w*\d)/",$pwd));
}
function is_valid_password_y($pwd){
  return true;
}


function sql_edad_deportiva($fecha_nacimiento){
// esta funcion calcula los meses transcurridos en dos fechas utilizando el motor de MYSQL
   
    $date_hoy=date("Y-m-d 00:00:00");
    $date_array=explode("-",$date_hoy);// arreglo de fecha
    $yyyymm_fy=$date_array[0].$date_array[1]; // obtenemos mes y ano
//    echo '<pre>';
//    var_dump($yyyymm_fy);
//    echo '</pre>';
    $date_fn = $fecha_nacimiento;  
    $date_array=explode("-",$date_fn);// arreglo de fecha
    $yyyymm_fn=$date_array[0].$date_array[1]; //obtenemos mes y ano de nacimiento
    
    $sql="SELECT PERIOD_DIFF($yyyymm_fy,$yyyymm_fn)/12 AS edad"; // funcion de MYSQL para calcular los meses entre dos fechas
    $result=mysql_query($sql);
    $rowedad=mysql_fetch_assoc($result); // Calcula de edad
    $edad=$rowedad["edad"];
    return ($edad);
}

?>