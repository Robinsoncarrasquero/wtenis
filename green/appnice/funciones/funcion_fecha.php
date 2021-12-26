<?php
define("DIAS_PARA_OPEN_DF",'30');
define("DIAS_PARA_OPEN_G1",'30');
define("DIAS_PARA_OPEN_G2",'30');
define("DIAS_PARA_OPEN_G3",'30');
define("DIAS_PARA_OPEN_G4",'30');
define("DIAS_PARA_OPEN_G5",'30');
define("DIAS_PARA_OPEN",'30');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Retorna el ano de una fecha
function anodeFecha($fechadada){
    $fechax = explode ('-', $fechadada);
    return $fechax[0];
}
//Retorna el mes de una fecha
function mesdeFecha($fechadada){
    $fechax = explode ('-', $fechadada);
    return $fechax[1];
}
//Retorna el dia de mes de una fecha
function diadeFecha($fechadada){
    $fechax = explode ('-', $fechadada);
    return $fechax[2];
}
//Devuelve el ano actual
function ano_actual(){
    return date("Y");
}

//Devuelve la fecha actual
Function Fecha_Hoy(){
    $date_hoy=date_create(); // fecha del servidor 
    //echo date_format($date_hoy,"Y-m-d H:i:s");
    return date_timestamp_get($date_hoy);
}

//Controla el numero de dias para la apertura del calendario de torneo
//segun el grado. Cada grado tiene un tiempo estipulado para activarse.
Function Fecha_Apertura_Calendario($fecha_cierre,$grado_){
    
     $date_new = date_create($fecha_cierre); // fecha cierre de la bd
     $diasParaOpen =DIAS_PARA_OPEN ."  days";
     switch ($grado_) {
        case 'G1':
            $diasParaOpen =DIAS_PARA_OPEN_G1 ."  days";
            break;
        case 'G2':
           $diasParaOpen =DIAS_PARA_OPEN_G2 ."  days";
           break;
        case 'G3':
            $diasParaOpen =DIAS_PARA_OPEN_G3 ."  days";
            break;
        case 'G4':
           $diasParaOpen =DIAS_PARA_OPEN_G4 ."  days";
           break;
       case 'G5':
           $diasParaOpen =DIAS_PARA_OPEN_G5 ."  days";
           break;
        default:
            $diasParaOpen =DIAS_PARA_OPEN_DF ."  days";
            break;
     }
     
     date_sub($date_new,date_interval_create_from_date_string($diasParaOpen));
    
    return date_timestamp_get($date_new);
    
}
//Funcion para controlar el numero de dias que se debe restar a la fecha de inicio
//del torneo para permitir que el administrador pueda manejar inscripciones durante
//el torneo.
Function Fecha_Inicio_Admin($fecha_cierre){
    
     $date_new = date_create($fecha_cierre); // fecha cierre de la bd
     $diasParaOpen ="1 days";
     
     date_sub($date_new,date_interval_create_from_date_string($diasParaOpen));
    
    return date_timestamp_get($date_new);
    
}
//Funcion para controlar el numero de dias que se debe sumar a la fecha de cierre
//del torneo para permitir que el administrador pueda manejar inscripciones durante
//el torneo.
Function Fecha_Cierre_Admin($fecha_cierre){
    
     $date_new = date_create($fecha_cierre); 
     $diasParaOpen ="30 days";
     
     date_add($date_new,date_interval_create_from_date_string($diasParaOpen));
    
    return date_timestamp_get($date_new);
    
}
//Funcion utilizada para activar el status running 
//de un torneo sumando los dias que durara el mismo a partir de la fecha
//de incio del torneo
Function Fecha_Fin_Torneo($fecha_inicio_torneo){
    
     $date_new = date_create($fecha_inicio_torneo); // fecha cierre de la bd
     date_add($date_new,date_interval_create_from_date_string("6 days"));
   
     //return date_timestamp_get($date_new);
     return $date_new->getTimestamp();
}


//Funcion para restar 1 dia de una fecha dada
//Es utilizada para activar el status running de un torneo
//los dias antes que se especifiquen
function Fecha_ini_Torneo($fecha_,$grado_){
    
     $date_new = date_create($fecha_); // fecha cierre de la bd
     if ($grado_=="G4"){
         date_sub($date_new,date_interval_create_from_date_string("2 days"));
     }  else {
         date_sub($date_new,date_interval_create_from_date_string("1 days"));
     }
   
    return date_timestamp_get($date_new);
     
}

//Permite configurar el tiempo que debe transcurrir desde una fecha y grado dado
//para visualizar o emitir la informacion en el listado

function Fecha_listado_Torneo($fecha_,$grado_){
    
    $date_new = date_create($fecha_); // fecha cierre de la bd
    //$format ="Y-m-d 21:00:00";
    //$date=  date_format($date_new, $format);
    //$date_new = date_create($date); // Fecha Actual
    
    if ($grado_=="G4"){
        date_add($date_new,date_interval_create_from_date_string("2 hour"));
      
    }else{
       date_add($date_new,date_interval_create_from_date_string("2 hour"));
    }
    return date_timestamp_get($date_new);
}


//Permite crear una variable fecha unix
Function Fecha_Create($fecha){
    $date_new=date_create($fecha); // fecha del servidor 
    return date_timestamp_get($date_new);
   
    
}

//Genera las diferentes categorias que un atleta puede jugar
// al momento de una inscripcion
function categoria_Torneo($anodeNacimiento){
   $ano= date ("Y");  
   $edad=$ano - $anodeNacimiento;
    if  ($edad >18){
        if ($edad >= 35) {
            $cat_natural = "AB,35";
        } else {
            $cat_natural = "AB";
        }
    }elseif  ($edad >16 && $edad <19){
        $cat_natural="18,AB";
    }elseif ($edad > 14 && $edad <17){
        $cat_natural="AB,16,18";
    }elseif ($edad > 12 && $edad <15){
        $cat_natural="AB,14,16,18";
    }elseif  ($edad >10 && $edad <13){
        $cat_natural="12B,12,14,16";
    }elseif ($edad >8  && $edad <11){
        $cat_natural="PN,PV,12B";
    }elseif  ($edad > 6 && $edad <9){
        $cat_natural="PN,PV";
    }
//           echo'<pre>';
//        echo "EDADA:</br>";
//        var_dump($edad).'</br>';
//        var_dump($cat_natural).'</br>';
//        echo'</pre>';  
   return $cat_natural; 
}

function Categoria_Grado_Torneo($anodeNacimiento,$array_ranking_categoria ,$grado_torneo,$ranking_natural,$numero_torneo){
   $ano= date ("Y");  
   $edad=$ano - $anodeNacimiento;
   $categoria_natural=categoria_Afiliacion($anodeNacimiento,$ano);
   
    if  ($edad >18){
        if ($edad >= 35) {
            $cat_juego = "AB,35";
        } else {
            $cat_juego = "AB";
        }
    }elseif  ($edad >16 && $edad <19){
        $cat_juego="18,AB";
    }elseif ($edad > 14 && $edad <17){
        $cat_juego="AB,16,18";
    }elseif ($edad > 12 && $edad <15){
        $cat_juego="AB,14,16,18";
    }elseif  ($edad >10 && $edad <13){
        //CATEGORIA 12
        //Categoria 12 solo se le permite jugar G4 16 anos
        if (array_search("16",$array_ranking_categoria)>0 && $grado_torneo=="G4"){
            $cat_juego = "12,14,16";
            
        }elseif (array_search("12B",$array_ranking_categoria)>30){
            $cat_juego = "12B,12,14";
        }else {
            $cat_juego = "12,14";
        }
    }elseif ($edad >8  && $edad <11){
        //CATEGORIA PV 9 Y 10
        $cat_juego="PV,12B";
        if (array_search("12",$array_ranking_categoria)>0 && $ranking_natural>0 && $ranking_natural<=5){
            $cat_juego = "PV,12B,12";
        }    
        
    }elseif  ($edad > 6 && $edad <9){
        //CATEGORIA PN 7 y 8
        //Pelota naranja el ranking < 10 puede jugar pelota verde e igualmente a los jugadores
        //del ultimo ano de la categoria,
//        if ($ranking_natural<=10 || $edad==8) {
//            $cat_juego = "PN,PV";
//        } else {
//            $cat_juego = "PN,PV";
//        }
          $cat_juego = "PN";
          if (array_search("PV",$array_ranking_categoria)>0 && $numero_torneo>1){
            $cat_juego = "PN,PV";
        }
    }else{
        $cat_juego = "PR";
    }
//           echo'<pre>';
//        echo "EDADA:</br>";
//        var_dump($edad).'</br>';
//        var_dump($cat_natural).'</br>';
//        echo'</pre>';  
   return $cat_juego; 
}

//Se utiliza para determinar la categoria natural a una fecha dada
function categoria_natural($anodeNacimiento){
   $ano= date("Y");  
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


//Se utiliza para determinar la categoria natural al momento de la afiliacion
function categoria_Afiliacion($anodeNacimiento,$anoAfiliacion){
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
function fecha_date($fechayymmdd){
    $fecha_=  date_create($fechayymmdd);
    $fecha_=  date_format($fecha_,"Y-m-d");
     
    return $fecha_;
}
//Crear una fecha con formado de horas hh:mm
 function fecha_time($fechayymmdd){
    $fecha_=  date_create($fechayymmdd);
    $fecha_=  date_format($fecha_,"H:i:00"); 
    
        
    return $fecha_;
}  

//Crea una fecha en formato dd/mm/yyyy
function fecha_date_dmYYYY($fechaddmmyyyy){
    $fecha_=  date_create($fechaddmmyyyy);
    $fecha_=  date_format($fecha_,"d-m-Y");
     
    return $fecha_;
}

//Retorna el literal de un mes segun el valor entero del mes recibido 
//la posicion 0 es suplantada con un titulo de relleno para que los meses coincida 
//en el arreglo
function fun_Mes_Literal($mes_integer) {
    $arryMes= array('Mes','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    
    return $arryMes[$mes_integer]; 
}

//Esta funcion sirve para calcula el tiempo transcurrido entre dos fechas.
function calcular_edad($fecha_hoy,$fecha_nacimiento){
$d1=new DateTime("2017-05-26 11:14:15.0"); 
$d2=new DateTime("1964-06-19 11:14:15.0"); 
$diff=$d2->diff($d1); 

$anos=($diff->y);
$dias=($diff->d);
$meses=($diff->m);
return $anos;


}

