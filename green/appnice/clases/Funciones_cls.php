<?php


/**
 * Description of Crud
 *
 * @author robinson
 */
class Funciones{
    

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

    public static function getRealIP()
    {

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }

    }

    public static function MesLiteral($mes){
        $ar_mes=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
        
        return $ar_mes[$mes-1];
     
    }
     
    //Funcion que devuelve el icono relacionado con el estatu de la inscripcion
    public static function Estatus_Inscripcion($estatus){
        switch ($estatus) {
           case 'Ok':
               $array[]= '<tr class="success "  >  ';
               $array[]= '<td><p class="glyphicon glyphicon-thumbs-up"></p></td>';
               $array[]= '<td>'.$estatus.'</td>';
               return $array;   
               break;
            case 'Confirmado':
               $array[]= '<tr class="danger"  >  ';
               $array[]= '<td><p class="glyphicon glyphicon-usd"></p></td>';
               $array[]= '<td>'.$estatus.'</td>';
               return $array;    
               break;
           case 'Open':
               $array[]= '<tr class=" "  >  ';
               $array[]= '<td><a target=""  class="glyphicon glyphicon-hourglass"></a></td>';
               $array[]= '<td>'.$estatus.'</td>';
               return $array;
               break;
           case 'Inactivo':
               $array[]= '<tr class=" " >';
               $array[]= '<td><p class="glyphicon glyphicon-lock glyphicon-question-sign"></p></td>';
               $array[]= '<td>'.$estatus.'</td>';
               return $array;
               break;
           default:
               $estatus="Abierto";
               $array[]= '<tr class=" "  >  ';
               $array[]= '<td><a target=""  class="glyphicon glyphicon-hourglass"></a></td>';
               $array[]= '<td>'.$estatus.'</td>';
               return $array;         
               break;
        }
       
    }


}