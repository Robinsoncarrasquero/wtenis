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
class Noticaciones {
    //put your code here
   
    public $sesion_id;
    
    
    public function __construct() {
       
       
    }

   
    // esta funcion se debe rehacer completamente desde la funcion
    // de envial notificacione
    public static function email_notification($tipo) 
    {
            
             
       
                
        
        
        switch ($tipo){
            case "Rank": //Ranking Modificado
                $asunto="Actualizacion de Ranking";
                $notificacion="la actualizacion de ranking";
                break;
            case "Email": //Ingreso de Email
                $asunto="Actualizacion de correo";
                $notificacion="la actualizacion de correo";
                break;
            case "Clave": //Modificacion de clave
                $asunto="Cambio de clave";
                $notificacion="la Creacion de clave";
                break;
            case "RecuperarClave": //Recuperacion de clave
                $asunto="Recuperacion de clave";
                $notificacion="la Modificacion de clave";
                break;
            default:
                $asunto="Ingreso al sistema";
                $notificacion="Entrada al sistema";
                return;

        } 
        $notificacion2="fue realizada exitosamente";
        if ($tipoNotificacion=="RecuperarClave" || $tipoNotificacion="Clave"){
            $notificacion="su nueva clave es :".$row["contrasena"];
            $notificacion2=" ";
        }
        
        
        
        $conexion=null;
        return;
    }
        
    
    
    
}