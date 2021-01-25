<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Bootstrap_Class
{
 
   
    public static function badge($Titulo,$options="default") {
        
        return '<span>'.$Titulo.'</span>';
        //return '<span class="label label-'.$options.' ">'.$Titulo.'</span>';

    }

    public static function mensajes_notas($titulo,$class_titulo_alert="text-success",$texto,$class_texto_alert="text-success",$class_div_container="alert-default") {
        $salida="<div class='alert $class_div_container'>";
        $salida .= "<h3 class='text $class_titulo_alert'>".$titulo."<br>";

        $salida .=  "<h4 class='text text-primary'>".trim($texto)."</h4></h3>";
        $salida .="</div>";
        
        echo $salida;
    }
    public static function mensajes_panel($titulo,$texto,$class_panel_alert="panel-default",$class_texto_alert="text-info") {
        $salida = "<div class='panel $class_panel_alert'>";
        $salida .= '<div class="panel-heading"><h3>'.$titulo."</h3></div>";
        //echo "<h3 class='panel-body $class_texto_alert '>".$texto."</h3>";
                    
        $salida .= '<div class="panel-footer  '.$class_texto_alert.'"><h4>'.$texto.'</h4></div>';
                
        $salida .= '</div>';
        echo $salida;
    }
    public static function texto($titulo,$options="success") {

        
        return '<span class="label label-'.$options.' ">'.trim($titulo).'</span>';

    }
    public function color_option($option) {
        switch ($option) {
            case "default":
                $option= "default";
                break;
            case "primary":
                $option= "primary";
                break;
            case "success":
                $option= "success";
                break;
            case "info":
                $option= "info";
                break;
            case "warning":
                $option= "warning";
                break;
            case "danger":
                $option= "danger";
                break;
            default:
                $option=" ";
                
                break;
        }
        return '<span class="label label-success">'.$option.'</span>';

    }

    public static function label($Titulo,$options="default") {

        return '<span class="label label-'.$options.' ">'.$Titulo.'</span>';

    }

    public static function span($Titulo,$options="default") {


        return '<span class="label label-'.$options.' ">'.$Titulo.'</span>';

    }


    
    
    
}