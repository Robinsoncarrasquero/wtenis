<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imagenes2_cls
 *
 * @author robinson
 */
class Imagenes2_cls {
    //put your code here
    

    public static function crear_imagen($folder, $width, $height,$resolucion) {
        
         //Contamos todas las imagenes que envia el plugin en la subida
        $list_imagens= count($_FILES['imagenes']['tmp_name']);
        for($i=0;$i<$list_imagens;$i++){

            $filename=$_FILES['imagenes']['name'][$i];
            $filenametmp=$_FILES['imagenes']['tmp_name'][$i];
            
            $date_hoy=date_create(); // fecha del servidor 
            //echo date_format($date_hoy,"Y-m-d H:i:s");
            sleep(1);
            $datetime= date_timestamp_get($date_hoy);
            $datenow= date_format($date_hoy,"Y-M-d");
            $array=explode(".",$filename);
            $newfilename=$folder."tmp_".$datetime.".".end($array);
            $orifilename=$folder."tmp_".$datetime.".png";
            
            list($ww, $hh) = getimagesize($filenametmp);
            move_uploaded_file($filenametmp,$newfilename);
            $image= Imagenes2_cls::icreate($newfilename);
            copy($newfilename, $orifilename);
            
            
            //Redimensiona imagen con ancho y tamano fijo 
            switch ($resolucion) {
                case "Max":
                    $imgr = Imagenes2_cls::resizeMax($image, $width, $height);
                    break;
                case "Fija":
                    $imgr = Imagenes2_cls::resizeCrop($image, $width, $height, "min");
                    break;
                case "Larga":
                    $imgr = Imagenes2_cls::resizeAspectW($image, $width);
                    break;
                case "Alta":
                    $imgr = Imagenes2_cls::resizeAspectH($image, $height); 
                    break;
                default:
                $imgr=$image;
                echo json_encode(array("file_id"=>1,"Mensaje"=>"Imagen muy pequena, deben tener un ancho minimo de 600px)"));
                return;
               
            }
//            if ($width>0 && $height >0){
//                $imgr = Imagenes2_cls::resizeImagenFixed($image, $width, $height);
//            }elseif ($height>0){
//                //Redimensiona imagen manteniendo aspecto dado el alto
//                $imgr = Imagenes2_cls::resizeAspectH($image, $height);
//            }elseif ($width>0){
//                //Redimensiona imagen manteniendo aspecto dado el ancho
//                $imgr = Imagenes2_cls::resizeAspectW($image, $width);
//            }else{
//                $imgr=$image;
//                echo json_encode(array("file_id"=>1,"Mensaje"=>"Imagen muy pequena, deben tener un ancho minimo de 600px)"));
//                return;
//            }
//            
            imagejpeg($imgr, $newfilename, 75);
            echo json_encode(array("file_id"=>0));
            return;
        
        }
    }
public static function icreate($filename)
{
  $isize = getimagesize($filename);
  if ($isize['mime']=='image/jpeg')
    return imagecreatefromjpeg($filename);
  elseif ($isize['mime']=='image/png')
    return imagecreatefrompng($filename);
  /* Add as many formats as you can */
}

/**
 * Resize maintaining aspect ratio
 *
 * @param $image
 * @param $width
 */
public static function resizeAspectW($image, $width)
{
  $aspect = imagesx($image) / imagesy($image);
  $height = $width / $aspect;
  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
  return $new;
}

/**
 * Resize maintaining aspect ratio
 *
 * @param $image
 * @param $height
 */
public static function resizeAspectH($image, $height)
{
  $aspect = imagesx($image) / imagesy($image);
  $width = $height * $aspect;
  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
  return $new;
}

/*
 * Resize image maintaining aspect ratio, occuping
 * as much as possible with width and height inside
 * params.
 *
 * @param $image
 * @param $width
 * @param $height
 */
public static function resizeMax($image, $width, $height)
{
  /* Original dimensions */
  $origw = imagesx($image);
  $origh = imagesy($image);

  $ratiow = $width / $origw;
  $ratioh = $height / $origh;
  $ratio = min($ratioh, $ratiow);

  $neww = $origw * $ratio;
  $newh = $origh * $ratio;

  $new = imageCreateTrueColor($neww, $newh);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $neww, $newh, $origw, $origh);
  return $new;
}

/*
 * Redimensiona y Recorta una imagen manteniendo un tamano fijo sin perder el aspecto pero 
 * se perdera alguna parte de la imagen de la siguiente manera:
 * ‘min’: recortará la imagen arriba o a la izquierda
 * ‘center’: se quedará con la parte central de la imagen
 * ‘max’: recortará la imagen abajo o a la derecha
 * 0>=x>=1 (cualquier valor entre 0 y 1): desplazará la ventana de recorte hacia la derecha o abajo.
 *  Podemos interpretarlo como un porcentaje.
 */
public static function resizeCrop($image, $width, $height, $displ='center')
{
  /* Original dimensions */
  $origw = imagesx($image);
  $origh = imagesy($image);

  $ratiow = $width / $origw;
  $ratioh = $height / $origh;
  $ratio = max($ratioh, $ratiow); /* This time we want the bigger image */

  $neww = $origw * $ratio;
  $newh = $origh * $ratio;

  $cropw = $neww-$width;
  /* if ($cropw) */
  /*   $cropw/=2; */
  $croph = $newh-$height;
  /* if ($croph) */
  /*   $croph/=2; */

  if ($displ=='center')
    $displ=0.5;
  elseif ($displ=='min')
    $displ=0;
  elseif ($displ=='max')
    $displ=1;

  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, -$cropw*$displ, -$croph*$displ, 0, 0, $width+$cropw, $height+$croph, $origw, $origh);
  return $new;
}



}

