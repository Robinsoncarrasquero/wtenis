<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//funcion valida datos para que evitar injection
function data_input($data) {
   
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function valida_letras($valor){
    $name = data_input($valor);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
    return $nameErr;
}

function valida_email($valor){
    $email = data_input($valor);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
    return $emailErr;
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
function update($string_sql)
{
    
    $result=mysql_query($string_sql);
    if (!$result) {
        echo "Error de conexion Actulizando Ranking : " .mysql_error();
        return(1);
    }else{
      return(0) ;
    }
        
}
?>