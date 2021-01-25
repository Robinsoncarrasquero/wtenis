<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $fileName = 'foto4.jpg';
 $filePath = './images/';
 $fileSave = './image2/';
 
 if (!file_exists($filePath.$fileName)){

     echo "ERROR PANA EL ARCHINO NO ESTA EN EL DISCO";

     return;

   }

$img = new Imagick(realpath($filePath.$fileName));
//$imagen = new Imagick('imagen.jpg');

// Si se proporciona 0 como parámetro de ancho o alto,
// se mantiene la proporción de aspecto


//$img->thumbnailImage(0,600);
$width=0; $height=800;
//$img->cropthumbnailimage($width, $height);// fino
//$img->cropimage($width, $height,0,0); //fino
$d = $img->getImageGeometry(); 
$h = $d['height']; 
if ($h>800){
    $width=0;
    $height=800;
}

$img->resizeimage($width, $height, Imagick::FILTER_LANCZOS, 1);
//$img->setResolution(10, 10);
$img->setimageformat( "jpeg" );
$img->writeimage(getcwd() . $fileSave .'out_'.$fileName);


switch ($img->GmagickException) {
    
    case true:
        echo $img->GmagickException;
           echo "<br>HUBO UN ERROR";
        exit;
        break;
    default:
       
        break;
}
  
header('Content-type: image/jpeg');
$a = $img->getImageBlob();
 //echo "Rendered to ".strlen($a)." bytes\n";
echo  $a;  
       
//echo $img;




