<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(getenv('REQUEST_METHOD') == 'POST') {
	$client_data = file_get_contents("php://input");
//	echo "
//		<SERVER>
//			Hallo, I am server
//			This is what I've got from you
//			$client_data
//		</SERVER>
//	";
//	exit();

//$carpetaAdjunta="../".$_SESSION['url_fotos_portal'];  




//$folder="../".$_SESSION['url_fotos_torneos'];
$folder=$client_data;
//if ($_SERVER['REQUEST_METHOD']=='DELETE'){
{
    
    parse_str(file_get_contents("php://input"),$datosDELETE);
    $kye=$datosDELETE['key'];
    
    //var_dump($datosDELETE);
    //echo $kye;
   
    unlink($kye);
    echo 0;//json_encode(array("file_id"=>0));
}

}else{
    echo 1;//json_encode(array("file_id"=>0));
}