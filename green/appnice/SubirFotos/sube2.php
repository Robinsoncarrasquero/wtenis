<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
{
    $img_loc="";
    $file="sura.jpg";
    $file2="sura2.jpg";
    $resized_loc="";
    
    
    $img_loc="";
    $file="sura.jpg";
    $file2="sura2.jpg";
    $resized_loc="";
    $img = new Imagick($img_loc.$file); 
    $img->setImageResolution(72,72); 
    $img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1); 
    $img->scaleImage(800,0); 
    $d = $img->getImageGeometry(); 
    $h = $d['height']; 
    if($h > 600) { 
        $img->scaleImage(0,600); 
        $img->writeImage($resized_loc.$file2); 
    } else { 
        $img->writeImage($resized_loc.$file); 
    } 
//    $img->destroy(); 
   

// $image is still 800x480
    
    $data = $Imagick->getImageBlob (); 
echo $data; 
file_put_contents ('test.png', $data); 
    
}

