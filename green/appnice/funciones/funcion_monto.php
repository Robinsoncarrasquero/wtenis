<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function formatear_monto($number){
    
    return number_format($number, 2, ',', '.');
    
}