<?php

/* 
 * Esta clase statica maneja la creacion de imagenes para cargar en un sitio web
 * Manejo de tamano, redimensionar, crop,etc
 
 */


class Imagenes {
    
    
    
    
   
   //Funcion para subir las fotos al portal tamano fijo
    public static function load_img($folder,$w,$h){
        
        //Carpeta fisica
        $folder_name=$folder;  
        
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
            $newfilename=$folder."tmp_".$datetime.".".end(explode(".",$filename));
            
            list($ww, $hh) = getimagesize($filenametmp);
            
           //Crea la imagen
            if ($w>0 && $h >0){
                $ratio=Imagenes::ratio_filename($filenametmp,$w,$h);
            }else{
                $ratio=0;
            }
                       
            //if (round($ratio,2)==1.33 || $ratio==0){
            //if ($ww>=$w || $hh>= $h){
            if ($ww>0 || $hh>0){
      
                 //Movemos el archiov temporal subido a la ruta real
                move_uploaded_file($filenametmp,$newfilename);
            
                $imgh= Imagenes::image_create($newfilename);
                
                

               //Redimensiona imagen con ancho y tamano fijo 
                if ($w>0 && $h >0){
                    $imgr = Imagenes::resizeImagenFixed($imgh, $w, $h);
                }elseif ($w<=0 && $h >0){
                    //Redimensiona imagen manteniendo aspecto dado el alto
                    $imgr = Imagenes::resizeAspectH($imgh, $h);
                }elseif ($w>0 && $h <=0){
                        //Redimensiona imagen manteniendo aspecto dado el ancho
                        $imgr = Imagenes::resizeAspectW($imgh, $w);
                }else{
                         $imgr=$imgh;
                }
                

                imagejpeg($imgr, $newfilename, 75);
                //Redimensiona haciendo un corte 
    //            $imgr = resizeCrop($imgh, 800, 600, 0.4);

    //            header('Content-type: image/jpeg');
    //            imagejpeg($imgr);
                echo json_encode(array("file_id"=>0));
            }else{
                
                echo json_encode(array("file_id"=>1,"Mensaje"=>"Imagen muy pequenas, deben tener una tamano minimo de 600x400"));
            }
             
        }
        
        //echo json_encode($arr);
       
   }
    
    //Crea la imagen segun el tipo de archivo
    static function image_create($filename)
    {
      $isize = getimagesize($filename);
      if ($isize['mime']=='image/jpeg')
        return imagecreatefromjpeg($filename);
      elseif ($isize['mime']=='image/png')
        return imagecreatefrompng($filename);
      /* Add as many formats as you can */
    }
    
     //Redimensiona la imagen dada la anchura y alto
    static function resizeImagenFixed($orig_image, $width, $height)
    {
      /* Original dimensions */
      $origw = imagesx($orig_image);
      $origh = imagesy($orig_image);

      $ratiow = $width / $origw;
      $ratioh = $height / $origh;
      $ratio = min($ratioh, $ratiow);
  
      $dts_w = $origw * $ratio;
      $dts_h = $origh * $ratio;
      
      //imagenes fijas
    $crop=1;
    $w = imagesx($orig_image);
    $h = imagesy($orig_image);
    if($crop){
      //if($w < $width or $h < $height) return "Picture is too small!";
 
      $ratio = max($width/$w, $height/$h);
      $h = $height / $ratio;
      $x = ($w - $width / $ratio) / 2;
      $w = $width / $ratio;
    }
    else{
      //if($w < $width and $h < $height) return "Picture is too small!";
 
      $ratio = min($width/$w, $height/$h);
      $width = $w * $ratio;
      $height = $h * $ratio;
      $x = 0;
    }
                
      $red=0;$green=0;$blue=0;
      imagecolortransparent($orig_image,  imagecolorallocate($orig_image, $red, $green, $blue));
      $dts_imagen = imageCreateTrueColor($width, $height);
      
      imagecopyresampled($dts_imagen, $orig_image, 0, 0, $x, 0, $width, $height, $w, $h);


      //imagecopyresampled($dts_imagen, $orig_image, 0, 0, 0, 0, $dts_w, $dts_h, $origw, $origh);
      return $dts_imagen;
    }

   

    //Redimensiona cortando
    static function resizeCrop($image, $width, $height, $displ='center')
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


   

    


    /**
     * Resize maintaining aspect ratio
     *
     * @param $image
     * @param $width
     */
    //Redimensiona manteniendo aspecto dado el ancho fijo
    static function resizeAspectW($image, $width)
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
    //Redimensiona la imagen dado el alto fijo
    static function resizeAspectH($image, $height)
    {
      $aspect = imagesx($image) / imagesy($image);
      $width = $height * $aspect;
      $new = imageCreateTrueColor($width, $height);

      imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

      return $new;
    }
    
    static function ratio_image($image,$width,$height){
        $origw = imagesx($image);
        $origh = imagesy($image);
      
        $ratiow = $width / $origw;
        $ratioh = $height / $origh;
        $aspect = min($ratioh, $ratiow);
        
        return $aspect;
    }
    
    static function ratio_filename($filename){
        list($origw,$origh)= getimagesize($filename);
        if ($origh>0){     
            $aspect =$origw/$origh;
        }else{
            $aspect=1;
        }
        
        return $aspect;
    }
     
    
    static function findGaleria($folder_) {
        
        $folder=$folder_;
        if(is_dir($folder)){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    
}
