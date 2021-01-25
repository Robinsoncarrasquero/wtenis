<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Globales
 *
 * @author robinson
 */
class Globales {
    //put your code here
    
    private $acceso;
    Public function AccesoDenegado() {
        
        
    //Si el usuario no está logueado redireccionamos al login.
    for($i=0;$i<4;$i++){
       $msg .= "<div style='color:red;margin-top:100;margin-left: 200px' ><h1 >ACCESO DENEGADO, USUARIO NO AUTORIZADO</h1></div> ";
  
     
     
    }
    $this->acceso=$msg; 
    
        
    }
}

