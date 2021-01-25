<?php

/**
 * Esta clase maneja la configuracion del html del sitio web
 *
 * @author robinson
 */
class HTML_SET {
    
    //public $js_script_array;
    private $js_script_array;

    //Cargar el head de la pagina el la primera que se debe cargar
    public static function html_head($title,$content=NULL,$css_path=NULL){
        $contentx='Sitio web para Inscripciones onLine de Torneos de Tenis de Campo, Tenis de Playa'; 
        $contentx=$content;
        echo '<!DOCTYPE html>';
        print_r("\n");
        echo '<!html lang="en">';
        print_r("\n");
        echo '<head>';
        print_r("\n");
        echo '<meta charset="utf-8" >';
        print_r("\n");
        echo '<title>'.$title.'</title>';
        print_r("\n");
        echo '<meta name="description" content="'.$contentx.'">';
        print_r("\n");
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        print_r("\n");
        echo '<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">';
        print_r("\n");
        echo '<link rel="stylesheet" href="'.$css_path.'css/tenis_estilos.css">';
        print_r("\n");
        echo '<link rel="stylesheet" href="'.$css_path.'css/master_page.css">';
        echo '<link rel="stylesheet" href="'.$css_path.'css/redsocial.css">';
        echo '<link rel="stylesheet" href="'.$css_path.'css/noticias.css">';
        echo '<link rel="stylesheet" href="'.$css_path.'css/fonts.css">';
        print_r("\n");
        echo '<link rel="stylesheet" href="'.$css_path.'css/FotosPortal2.css">';
        print_r("\n");
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
        print_r("\n");
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
        print_r("\n");
        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
        print_r("\n");
        echo '<link rel="shortcut icon" href="'.$_SESSION['favicon'].' " />';
        print_r("\n");
        
//        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">';
//        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
//        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>';
//
//        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>';

    }
    
    //Abre tag body
    public static function html_head_closed(){
        echo '</head>';
        print_r("\n");
    }
    //Abre tag body
    public static function html_body_open(){
        echo '<body {padding-bottom:70px;}';
        print_r("\n");
    }
    //Cierra tag Body
    public static function html_body_closed(){
        echo '</body>';
        print_r("\n");
    }
    //Abre tag html
    public static function html_open(){
        echo '<html>';
        print_r("\n");
    }
    //Abre tag html
    public static function html_closed(){
        echo '</html>';
        print_r("\n");
    }
    //Abre tab style
    public static function style_open(){
        echo '<style>'; 
        print_r("\n");
        
       
    }
    public static function style_content() {
        echo '<style>'; 
//        echo 'body{'
//        . 'background-image: url("images/logo/fvt/woman500x352.jpg");'
//        . 'background-repeat: no-repeat;'
//        . 'background-size: cover;'
//        . '}';
        print_r("\n");
        echo '.loader{
            background-image: url("images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }';
        print_r("\n");
        echo '.nav.navbar {
            background-color:    #000;
            background-color:'. $_SESSION['bgcolor_navbar'].'
        }';
        print_r("\n");
        echo '.jumbotron{
            
            background-color:'.$_SESSION['bgcolor_jumbotron'].';
            color:'.$_SESSION['color_jumbotron'].';
        }';
        print_r("\n");
        echo '.title-table{
            background-color:'.$_SESSION['bgcolor_jumbotron'].';
            color:'.$_SESSION['color_jumbotron'].';
            padding: 10px;
                
        }';

        echo 'tr[class~="table-head"]{
            background-color:'.$_SESSION['bgcolor_jumbotron'].';
            color:'.$_SESSION['color_jumbotron'].';
        }';
        
        print_r("\n");
        echo '.twitter-titulo{
            background-color:'.$_SESSION['bgcolor_jumbotron'].';
            color:'.$_SESSION['color_jumbotron'].';
            padding: 20px;
        }';
        
        echo '.noticia-titulo{
           background-color:'.$_SESSION['bgcolor_jumbotron'].';
           color:'.$_SESSION['color_jumbotron'].';
            padding: 20px;
        }';
        print_r("\n");
        echo  '.calendario-titulo{
            
            background-color:'.$_SESSION['bgcolor_jumbotron'].';
            color:'.$_SESSION['color_jumbotron'].';
            padding: 20px;

        }';
        print_r("\n");
        echo 'iframe{
            width: 100%;
        }';
        print_r("\n");
        
  $style='      ul {
  
 
  background-color: #f1f1f1;
}

dropdown-toggle {
 
  padding: 5px;
  width: 50px;
  background-color: #f1f1f1;
  padding: 8px 16px;
  
}

.navbar-header .navbar-nav{
 
  padding: 5px;
  width: 50px;
  background-color: #f1f1f1;
  padding: 8px 16px;
  
}

';
//Setea Barra de Navegacion
  HTML_SET::NavBar();
  
        echo '</style>';   
        print_r("\n");
        
    }
    //Cierra tab style
    public static function style_closed(){
        echo '</style>';       
    }
    
    //Abre tag js
    public static function html_JS_open($source_library){
        $js_script_array[]=$source_library;
    }
    
     //Cierra tag js
    public static function html_JS_closed($source_library){
        echo '<script type="text/javascript"';
        $jjs_script_array=$source_library;
        foreach ($jjs_script_array as $value) {
            print_r("\n");
            echo $value;
        }
        echo '></script>"';
        print_r("\n");
    }
   
    Public static function NavBar(){
        
        /* cambiar tipo de letra */
        echo 'nav.navbar ul.nav li {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:16px;
            
        }';
//        echo '.navbar{
//            background-color:gray !important;
//            
//        }';
//        
//        echo '.dropdown-menu{
//            background-color:white ;
//           
//        }';
//        echo 'nav{
//            background: url(images/logo/fvt/flores1024x490.png) no-repeat center;
//            //background: url(images/logo/fvtlogo.png) no-repeat center;
//            background-size: cover;
//            min-height: 100vh;
//            color:#ff00ff;
//            
//        }';

        

        //cambiar el color de fondo a la barra */
//        echo 'nav.navbar {
//            background-color: #ff00ff;
//            color:#ffffff;
//        }';

    }
    
}
