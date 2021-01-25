<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud
 *
 * @author robinson
 */
class Funciones{
    
    
public static function encriptar($cadena){
    $key='fvtenis';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
    return $encrypted; //Devuelve el string encriptado
 
}
 
public static function desencriptar($cadena){
     $key='fvtenis';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decrypted;  //Devuelve el string desencriptado
}

public static function categoria_natural($anodeNacimiento,$anoAfiliacion){
   $ano= $anoAfiliacion;  
   $edad=$ano - $anodeNacimiento;
   $cat_natural="NA";
    if  ($edad >18){
        $cat_natural="AD";
    }elseif  ($edad >= 17){
        $cat_natural="18";
    }elseif ($edad >= 15 ){
        $cat_natural="16";
    }elseif ($edad >= 13){
        $cat_natural="14";
    }elseif  ($edad >=11){
        $cat_natural="12";
    }elseif ($edad >=9){
        $cat_natural="PV";
    }elseif ($edad >=7){
        $cat_natural="PN";
    }else{
        $cat_natural="PR";
    }
    

   return $cat_natural; 
}

//Crea un fecha con formato yyyy-mm-dd;
public static function fecha_date_YYYYmmdd($fechayymmdd){
    $fecha_=  date_create($fechayymmdd);
    $fecha_=  date_format($fecha_,"Y-m-d");
     
    return $fecha_;
}

public static function Fecha_Ano($fechadada_yyyy_mm_dd){
    $fechax = explode ('-', $fechadada_yyyy_mm_dd);
    return $fechax[0];
}
//Retorna el mes de una fecha
public static function Fecha_Mes($fechadada_yyyy_mm_dd){
    $fechax = explode ('-', $fechadada_yyyy_mm_dd);
    return $fechax[1];
}
//Retorna el dia de mes de una fecha
public static function Fecha_Dia($fechadada_yyyy_mm_dd){
    $fechax = explode ('-', $fechadada_yyyy_mm_dd);
    return $fechax[2];
}

//Retorna el ano de una fecha dada en formato dd-mm-YYYY
public static function ffecha_ano($fechadada_dd_mm_yyyy){
    $fechax = explode ('-', $fechadada_dd_mm_yyyy);
    return $fechax[2];
}
//Retorna el mes de una fecha dada en formato dd-mm-YYYY
public static function ffecha_mes($fechadada_dd_mm_yyyy){
    $fechax = explode ('-', $fechadada_dd_mm_yyyy);
    return $fechax[1];
}
//Retorna el dia de una fecha dada en formato dd-mm-YYYY
public static function ffecha_dia($fechadada_dd_mm_yyyy){
    $fechax = explode ('-', $fechadada_dd_mm_yyyy);
    return $fechax[0];
}


}