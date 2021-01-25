<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$carpetaAdjunta="../".$_SESSION['url_fotos_portal'];   
//if ($_SERVER['REQUEST_METHOD']=='DELETE'){
{
    
    parse_str(file_get_contents("php://input"),$datosDELETE);
    $kye=$datosDELETE['key'];
    $kye2=  str_replace("jpg", "png",$kye);
    //var_dump($kye);
    //echo $kye;
   
    unlink($carpetaAdjunta.$kye);
    unlink($carpetaAdjunta.$kye2);
    echo 0;//json_encode(array("file_id"=>0));
}