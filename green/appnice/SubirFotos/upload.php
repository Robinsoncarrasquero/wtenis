<?php
session_start();
require_once '../funciones/Imagenes2_cls.php';
require_once '../clases/Noticias_cls.php';
/* 
 *Este programa cargas las imagenes en una carpeta especificada
 * Funciona con Bootstrap File Input Example
 */
if ($_SESSION['niveluser']>0){
    header("location : ../Login.php");
}
$folder="../".$_SESSION['url_fotos_portal'];
//$json=  Imagenes::load_img_fixed($folder,800,600);
//$json= load_img_libre($folder);
$json= Imagenes2_cls::crear_imagen($folder, 800, 600,"Fija");


 
   
function change_Imagick($file) {
    $img = new Imagick($img_loc . $file); 
    $img->setImageResolution(72,72); 
    $img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1); 
    $img->scaleImage(800,0); 
    $d = $img->getImageGeometry(); 
    $h = $d['height']; 
    if ($h > 600) {
        $img->scaleImage(0, 600);
        $img->writeImage($resized_loc . $file);
    } else {
        $img->writeImage($resized_loc . $file);
    }
    $img->destroy(); 
    $image = new Imagick('800x480.jpg');
    $image->scaleImage(640, 480, true);

// $image is still 800x480
    
}



