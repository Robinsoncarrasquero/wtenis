<?php

/* 
 * Funciones predeterminada del portal para manejar los fotos, calendario, noticias, 
 * etc, usando bootstrap 
 */


//Carga las fotos del portal de cada asociacion 
function fotos_portal_v3(){
 
    echo ''
    . '<div class="carousel-inner" role="listbox">';

    //Buscamos los archivos en la carpeta de fotos del portal
    $directorio="bsUploadImagenes/uploadimagenes/";
    $directorio =$_SESSION['url_fotos_portal'];      
    $imagenes=  glob($directorio."*.jpg");
    $x=0;

    foreach ($imagenes as $src_image){        
        list($width, $height, $type, $attr) = getimagesize($src_image);      
        $x++;      
        
        echo ($x==1) ? 
             '  <div class="item active ">' : '<div class="item ">' ;
        $image_mirror=  str_replace("jpg", "png", $src_image);
        //echo '<div class="img-responsive">';
        echo '<a class="img-responsive" target="_blank" href="'.$image_mirror.'">';
        
	echo '<img class="img-responsive"  src="'.$src_image.'">';
        
	echo '</a>		';
	//echo '	  </div>';		  
	echo '	</div>';
        // echo $image;
        // echo filesize($image)
        // scaleImage($image) ;   
    }
    
    echo ' </div>';   //<!-- FIN DE LISTBOX -->
    
}

//Carga las fotos galeria de torneos 
function fotos_torneo_galeria($folder_) {
   //Buscamos los archivos en la carpeta de fotos del portal
    $folder = $folder_;
    $imagenes = glob($folder . "*.*");

    foreach ($imagenes as $image) {

        $size = getimagesize($image);
        if ($size['mime'] == "image/jpeg" || $size['mime'] == "image/png") {

            echo '<li> <img  alt="Juega Tenis"  src="' . $image . '"  >
            <div class="text"></div>
            </li>';
        }
    }
}

//Carga las fotos galeria de torneos 
function fotos_portal22() {
   //Buscamos los archivos en la carpeta de fotos del portal
    
     echo '<div class="left carousel-inner" role="listbox">';

    //Buscamos los archivos en la carpeta de fotos del portal
    $folder_="bsUploadImagenes/uploadimagenes/";
    $folder_ =$_SESSION['url_fotos_portal'];     
    $folder = $folder_;
    $imagenes = glob($folder . "*.*");
    $x=0;
    foreach ($imagenes as $image) {
        $x++;

        if ($x == 1) {
            echo '<div class="item active">';
        } else {
            echo '<div class="item">';
        } 
        $size = getimagesize($image);
        if ($size['mime'] == "image/jpeg" || $size['mime'] == "image/png") {

            echo '<li> <img  alt="Juega Tenis"  src="' . $image . '"  >
            <div class="text"></div>
            </li> </div>';
            
        }
    }
}

//Carga las fotos del portal
function fotos_portal2(){
    echo '<div class="left carousel-inner" role="listbox">';

    //Buscamos los archivos en la carpeta de fotos del portal
    $directorio="bsUploadImagenes/uploadimagenes/";
    $directorio =$_SESSION['url_fotos_portal'];      
    //$imagenes=  glob($directorio."*.jpg,*.JPG");
    $imagenes=array_merge(glob($directorio."*.jpg"),glob($directorio."*.JPG"));
    $x=0;

    foreach ($imagenes as $image){

       $x++;

        if ($x == 1) {
            echo '<div class="item active">';
        } else {
            echo '<div class="item">';
        } 
       list($width, $height, $type, $attr) = getimagesize($image);

        echo  '<img src="'.$image. '"  alt="Galeria Portal" class="img-responsive" >
               <div class="carousel-caption">
                <!-- <h3>Equipo</h3>
                    <p class="txt-slide">Tenistas</p> -->
                </div>';
        echo '</div>';

    }
    
    echo ' </div>';   //<!-- FIN DE LISTBOX -->
            
}


//Carga las fotos del portal de cada asociacion 
function fotos_portal_new(){
 
    echo '<div class="left carousel-inner" role="listbox">';

    //Buscamos los archivos en la carpeta de fotos del portal
    $directorio="bsUploadImagenes/uploadimagenes/";
    $directorio =$_SESSION['url_fotos_portal'];      
    $imagenes=  glob($directorio."*.jpg");
    $x=0;

    foreach ($imagenes as $image){        
        list($width, $height, $type, $attr) = getimagesize($image);      
        $x++;      
        
        echo ($x==1) ? 
             '  <div class="item active portal-gallery img-responsive">' : '<div class="item portal-gallery img-responsive">' ;
        echo '	  <a target="_blank" href="'.$image.'">';		
	echo	      '<div class="div-portal-gallery-imagen" style="background: url('.$image.') no-repeat center center; background-size: cover;">';
	echo '		</div>';
	echo '	  </a>';		  
	echo '	</div>';
        // echo $image;
        // echo filesize($image)
        // scaleImage($image) ;   
    }
    
    echo ' </div>';   //<!-- FIN DE LISTBOX -->
    
}
function scaleImage($imagePath) {
    $directorio="uploadFotos/portal/xx/";
    $imagick = new \Imagick(realpath($imagePath));
    $imagick->scaleImage(800, 600, true);
    $imagick->setImageFormat('jpg'); 
    $imagick->writeImage($directorio."f1"); 
    header("Content-Type: image/jpg");
}

function JJumbotron($Titulo,$Contenido) {
    
    //-- Section Jumbotron -->
$html_str=

    '<div class="container">'.
        ' <div class="jumbotron jumbotron-tenis">'.
           '<div class="row">
              <div class="col-xs-12 ">
                <br />
              </div>';
                if (file_exists($_SESSION['url_logo'].'/logopatrocinio1.png')){
                    $html_str .='
                        <div class="col-xs-4 ">
                          <a target="" href=""> <img src="'.$_SESSION['url_logo'].'/logo.png" class="img-responsive push-left"></img></a>
                        </div>
                        <div class="col-xs-4 ">
                           <a target="" href="http://www.bk2usa.com/"> <img   src="'.$_SESSION['url_logo'].'/logopatrocinio1.png" class="img-responsive push-left"></img></a>
                        </div>
                        <div class="col-xs-4 ">
                           <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive pull-right"></img></a>
                        </div>';
                }else{
                  
                   if (file_exists($_SESSION['url_logo'].'/logo.png')){
                       $html_str .='
                        <div class="col-xs-6 ">
                            <a target="" href=""> <img src="'.$_SESSION['url_logo'].'/logo.png" class="img-responsive push-left"></img></a>
                        </div>
                        <div class="col-xs-6 ">
                            <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive pull-right"></img></a>
                        </div>';
                    }else{
                        $html_str .='
                        <div class="col-xs-6 ">
                            <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive"></img></a>
                        </div>';
                    }
              }
   
              $html_str .='
              
              <div class="col-xs-12 col-md-12">
                <h3>' .$Titulo.'</h3> '.    
                '<p>'.$Contenido.'</p>
              </div>
       </div>
    </div>
</div> ' ; 
 return $html_str;   
}


function Footer($Direccion, $Telefonos, $Email){
//<!-- Footer 1 -->  

$HTML_str='  
<div class="container" >
    <footer id="contact">
       <div class="row">
            <h3 class="text text-center">DIRECCION</h3>
            <div class="col-xs-12 col-sm-5 col-sm-offset-1">
                <strong >Direccion:</strong>
                <p><span>'.$Direccion.'</span><p>
            </div>
            <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                <strong>Telefonos:</strong>
                <p>'. $Telefonos .'</p>
                 <strong>Email:</strong>
                 <span><a href="mailto:#">'.$Email.'</a> </span>                   
            </div>
        </div>
    </footer>
</div>  ';
//<!-- Footer 1 End -->  
    return $HTML_str;
}


function FooterCopyRT(){
//<!-- Footer 2 -->  
    
$HTML_str='
<div class="container">
    <div class="row ">
        <div class="col-xs-12 col-sm-5 col-sm-push-7 col-md-5 col-md-push-7 col-lg-4 col-md-push-8">
            <strong><p class="text text-primary">© 2018 Todos los derechos reservados</p></strong>
         </div>
        <div class="col-xs-12 col-sm-6 col-sm-pull-4 col-md-5 col-md-pull-4 col-lg-4 col-lg-pull-3">
            <strong><a href="http://www.gss.com.ve/gss" target="_blank">
            <p class="text text-primary powerby">Desarrollado por GSS Consulting</p> </a></strong>
        </div>
    </div>
</div>';
//<!-- Footer 2 End -->  
 
    return $HTML_str;
}

//Post de Noticia se despliega en Thumbnail con un texto largo
function Post_Noticia($id,$titulo, $noticia,$autor,$fecha,$imagen) {
    //En caso de no llegar una imagen colocamos una predeterminada
    if ($imagen==NULL) {
        $imagen='lorempixelcobre.jpg';
        $img='<a  ><img  class="thumbnail img-responsive" src="image/sport/lorempixelcobre.jpg"> </a>';
    }else{
        $img='<a  ><img  class="thumbnail img-responsive" src="data:image/jpeg;base64,'.base64_encode($imagen).'"> </a>';
    }
    $valor_a_buscar='iframe frameborder="0"'; $valor_de_reemplazo='iframe class="embed-responsive-item"';
    $lanoticia=$noticia;
    str_replace ( $valor_a_buscar , $valor_de_reemplazo , $lanoticia , $contador);
    
    $img='';
    $HTML_str='
        
        <div class="col-xs-12 ">
            <br/>
        </div>
        <div id="lanoticia'.$id.'" class ="thumbnail Noticias">
            <h5 id="POST'.$id.'" class="post-title">POST </h5>
            <h5 class="caption">'.$titulo. '</h5>
            <span class="post-noticia">'.$lanoticia.'</span>
            <p class=" text-info text-right">Post:'.$fecha. '('.$contador.')</p>
        </div>'; 
return $HTML_str;
}

//Post de mini noticia se despliega en un list Group con un texto corto
function Post_Titulares($id,$titulo, $mininoticia,$autor,$fecha) {
    //$mininoticia='';
    $HTML_str='    
        <a data-id="'.$id.'"  href="Noticias/LaNoticia.php?id=' . $id . '" 
            target="" class=" list-group-item" >
            <h5 class="list-group-item-heading noticia-titular">' . ucwords($titulo) . '</h5>
            <p class="list-group-item-text text text-capitalize noticia-subtitulo">' . $mininoticia . '</p>
            <p class="text text-info noticia-fecha">' . $fecha . '</p>
        </a></br>';
    
return $HTML_str;
}


//Post de mini noticia se despliega en un list Group con un texto corto
function Torneos($id,$estatus, $grado,$entidad,$fechacierre,$fecharetiros) {
    //$mininoticia='';
    $HTML_str='
        <a data-id="'.$id.'"  href="Noticias/LaNoticia.php?id=' . $id . ' class="list-group-item " >
            <h5 class="list-group-item-heading ">Estatus : ' . $estatus . '</h5>
            <p class="list-group-item-text">Grado: ' . $grado . '</p>
            <p class="list-group-item-text">Lugar: ' . $entidad . '</p>
            <p class="list-group-item-text">Cierre : ' . $fechacierre. '</p>
            <p class=" text-info">Retiro: ' . $fecharetiros. '</p>
        </a>';
    
return $HTML_str;
}

//Post de mini noticia se despliega en un list Group con un texto corto
function Torneo_Modal($id,$estatus, $grado,$entidad,$fechacierre,$fecharetiros) {
    //$mininoticia='';
    $HTML_str='
       <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" data-id="'.$id.'"  >
            <h5 class="list-group-item-heading ">Estatus : ' . $estatus . '</h5>
            <span class="list-group-item-text">Grado: ' . $grado . '</span>
            <p class="list-group-item-text">Lugar: ' . $entidad . '</p>
            <p class="list-group-item-text">Cierre : ' . $fechacierre. '</p>
            <p class="list-group-item-text">Retiro: ' . $fecharetiros. '</p>
            <p class="list-group-item-text">Grado: ' . $grado . '</p>
            <p class="list-group-item-text">Lugar: ' . $entidad . '</p>
            <p class="list-group-item-text">Cierre : ' . $fechacierre. '</p>
            <p class="list-group-item-text">Retiro: ' . $fecharetiros. '</p>
        </button>
        
     ';
    
return $HTML_str;
}

function modal($param) {
//  <!-- Button trigger modal -->
//<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
//  Launch demo modal
//</button>
//
//<!-- Modal -->
//<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
//  <div class="modal-dialog" role="document">
//    <div class="modal-content">
//      <div class="modal-header">
//        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
//      </div>
//      <div class="modal-body">
//        ...
//      </div>
//      <div class="modal-footer">
//        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
//        <button type="button" class="btn btn-primary">Save changes</button>
//      </div>
//    </div>
//  </div>
//</div>  
    

}
//Post de mini noticia se despliega en un list Group con un texto corto
function xPost_Titulares($id,$titulo, $mininoticia,$autor,$fecha) {
    //$mininoticia='';
    $HTML_str='
        
        <a  href="#lanoticia' . $id . '" class="list-group-item Titulares" >
            <h5 class="list-group-item-heading ">' . $titulo . '</h5>
            <p class="list-group-item-text">' . $mininoticia . '</p>
            <p class=" text-info">Post:' . $fecha . '-' . $id . '</p>
        </a>';
    
return $HTML_str;
}




//Post de mini noticia se despliega en un list Group con un texto corto
function Twitter($userTwitter) {
   
    if ($userTwitter==''){
        $userTwitter="@MyTenis";
    }
    $HTML_str='
        <div> 
            <h5 class="twitter-title">DESDE TWITTER</h5>
            <a class="twitter-timeline" data-width="99%" data-height="800" href="https://twitter.com/'.$userTwitter.'"> '.$userTwitter.'</a> 
            <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>  
        </div>';  
    


return $HTML_str;
}


function PubliJumbotron($Titulo,$Contenido) {
    
    //-- Section Jumbotron -->
$html_str=

        '<div class="jumbotron">'.
            '<div class="row">
                <div class="col-xs-12">
                  <br />
                </div>';
              if (file_exists($_SESSION['url_logo'].'/patrocinio_1.png')){
                  
                    $html_str .='
                <div class="col-xs-12 ">
                    <a target=" " href="bsPanel.php"> <img src="'.$_SESSION['url_logo'].'/patrocinio_1.png" class="img-responsive img-thumbnail "></img></a> 
                    <a target="" href="bsPanel.php"> <img src="'.$_SESSION['url_logo'].'/patrocinio_1.png" class="img-responsive img-thumbnail "></img></a> 
                    <a target="" href="bsPanel.php"> <img src="'.$_SESSION['url_logo'].'/patrocinio_1.png" class="img-responsive img-thumbnail "></img></a> 
                    <a target=" " href="bsPanel.php"> <img src="'.$_SESSION['url_logo'].'/patrocinio_1.png" class="img-responsive img-thumbnail "></img></a> 
                    <a target=" " href="bsPanel.php"> <img src="'.$_SESSION['url_logo'].'/patrocinio_1.png" class="img-responsive img-thumbnail "></img></a> 
                </div>';
             
              }
              
              $html_str .='
            </div>
        </div>
   ' ; 
 return $html_str;   
}

function DatosdeBanco($banco, $cuenta,$nombre,$rif){
//<!-- Footer 1 -->  

$HTML_str='  
<div class="container" >
    <footer id="banco">
       <div class="row">
            <div class="col-xs-12 col-sm-5 col-sm-offset-1">
                <strong >Banco:</strong>
                <p><span>'.$banco.'</span><p>
            </div>
            <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                <strong>Cuenta:</strong>
                <p>'. $cuenta .'</p>
            </div>
            <div class="col-xs-12 col-sm-5 col-sm-offset-1">
                <strong>Titular:</strong>
                <p><span>'.$nombre.'</span><p>
            </div>
            <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                <strong>Rif:</strong>
                <p>'. $rif .'</p>
            </div>
        </div>
    </footer>
</div>  ';
//<!-- Footer 1 End -->  
    return $HTML_str;
}

function JJJumbotron($Titulo,$Contenido) {
    
    //-- Section Jumbotron -->
$html_str=

    ''.
        ' <div class="jumbotron ">'.
           '<div class="row">
              
                <br />
              ';
              if (file_exists($_SESSION['url_logo'].'/logopatrocinio1.png')){
                  
                $html_str .='
                <div class="col-xs-2 ">
                    <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive push-right"></img></a>
                </div>
                <div class="col-xs-offset-1 col-xs-7 ">
                    <a target="" href=""> <img   src="'.$_SESSION['url_logo'].'/logopatrocinio1.png"  class="img-responsive  "></img></a>
                </div>
                
                <div class="col-xs-offset-1 col-xs-1 ">
                    <a target="" href=""> <img src="'.$_SESSION['url_logo'].'/logo.png" class="img-responsive pull-right"></img></a>
                </div>';
               
               
              }else{
                  
                    if (file_exists($_SESSION['url_logo'].'/logo.png')){
                        $html_str .='
                         
                        <div class="col-xs-3 ">
                             <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive push-left"></img></a>
                        </div>
                        <div class="col-xs-offset-7 col-xs-2 ">
                            <a target="" href=""> <img src="'.$_SESSION['url_logo'].'/logo.png" class="img-responsive pull-right"></img></a>
                        </div>';
                     }else{
                         $html_str .='
                         <div class="col-xs-3">
                            <a target="" href="http://mytenis"> <img src="images/logo/fvtlogo.png" class="img-responsive"></img></a>
                         </div>';
                     }
              }
   
              $html_str .='
              
              <div class="col-xs-12 col-md-12">
                    <h5>'.$Titulo.'</h5> '.    
                    '<span>'.$Contenido.'</span>
              </div>
              
              
       </div>
    </div>' ;
              
    if (file_exists($_SESSION['url_logo'].'/logopatrocinio1.png')){
        $html_str .='
        <div class="container">
        
        <div class="col-xs-4 ">

           <a target="" href=""> <img   src="'.$_SESSION['url_logo'].'/wilson.png"  class="img-responsive  "></img></a>
        </div>
        
        <div class="col-xs-4 ">

           <a target="" href=""> <img   src="'.$_SESSION['url_logo'].'/unimodaverde.png"  class="img-responsive "></img></a>
        </div>
         <div class="col-xs-4 ">

           <a target="" href=""> <img   src="'.$_SESSION['url_logo'].'/panasalud.png"  class="img-responsive "></img></a>
        </div>
        
        
        </div>';
    }
    return $html_str;   
}

function FFFooterCopyRT(){
//<!-- Footer 2 -->  
    
$HTML_str='
<div class="container">
    <hr>
    <div class="row ">
        <div class="col-sm-12 col-sm-5 col-sm-push-7 col-md-5 col-md-push-7 col-lg-4 col-md-push-8">
            <strong><p class="text text-primary">© 2018 Todos los derechos reservados</p></strong>
        </div>
        <div class="col-sm-12 col-sm-6 col-sm-pull-4 col-md-5 col-md-pull-4 col-lg-4 col-lg-pull-3">
            <strong><a href="http://www.gss.com.ve/gss" target="_blank">
            <p class="text text-primary powerby">Desarrollado por GSS Consulting</p> </a></strong>
        </div>
    </div>
     
</div>';
//<!-- Footer 2 End -->  
 
    return $HTML_str;
}

//Footer
function FFFooter($Direccion, $Telefonos, $Email){
//<!-- Footer 1 -->  

$HTML_str='  
<div class="container" >
    <footer id="contacto" class="text text-center">
        <div class="row">
        <h4 id="banco" class="text text-center">Direccion</h4>
            <div class="col-sm-12 ">'
                .$Direccion.'
                <span>Telefonos : '.$Telefonos.'</span><span> Email : </span>
                 <a href="mailto:#">'.$Email.'</a> 
                   
            </div>
        </div>
        <br>
        <div  id="banco">
        <button id="btnmostrarbanco" class="btn btn-primary center-block"  >Datos Bancarios</button>
        </div>
    </footer>
           
</div>  ';
//<!-- Footer 1 End -->  
    return $HTML_str;
}


//Datos de Banco
function DDDatosdeBanco($banco, $cuenta,$nombre,$rif){
//<!-- Footer 1 -->  

$HTML_str='  
<div class="container" >
        
    <footer id="datosbanco" >
        
        <!-- <h4  class="text text-center">Datos Bancarios</h4> -->
        <div class="row text text-center">
                <strong >BANCO :</strong>'.($banco).' |
                <span>CUENTA :</span>'. $cuenta .' |
                <span>TITULAR :'.($nombre).'</span> |
                <span>RIF : </span>'. $rif .'
           
        </div>
    </footer>
</div>  ';
//<!-- Footer 1 End -->  
    return $HTML_str;
}

//Twiiter
function TTTwitter($userTwitter) {
    if ($userTwitter==''){
        $userTwitter="@MyTenis";
    }
    $HTML_str='
        <div class="text text-center" > 
            <a class="twitter-timeline" data-width="99%" data-height="800" href="https://twitter.com/'.$userTwitter.'"> '.$userTwitter.'</a> 
            <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>  
        </div>';  
return $HTML_str;
}