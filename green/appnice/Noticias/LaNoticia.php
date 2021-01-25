<?php

session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';

if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: ../Login.php');
}
sleep(1); // delay para mostrar el ajax loader imagen

$id=$_GET['id'];

   
    $obj = new Noticias();
    $obj->Fetch($id);
    $rowid=$obj->ID();
    $titulo=$obj->getTitulo();
    $subtitulo=$obj->getMiniNoticia();
    $noticia=$obj->getNoticia();
    $mininoticia=$obj->getMiniNoticia();
    $autor=$obj->getAutor();
    $fecha=$obj->getFecha();
    
    
    $valor_a_buscar='iframe frameborder="0"'; $valor_de_reemplazo='iframe class="embed-responsive-item"';
    $lanoticia=$noticia;
    str_replace ( $valor_a_buscar , $valor_de_reemplazo , $lanoticia , $contador);
    
    $img='';
    $str='
        <div id="lanoticia'.$id.'" class ="thumbnail col-xs-12">
            <h4 id="POST'.$id.'" class="noticia-titular">'.ucwords(strtolower($titulo)).'</h4>'.
            '<h4 class="noticia-subtitulo">'.$subtitulo. '</h4>
            <span class="post-noticia noticia-contenido">'.$lanoticia.'</span>
            
            <p class=" text-info text-right">Fecha:'.$fecha.'</p>
        </div>';
    
    



$obj = NULL;
?>

<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../css/noticias.css">
        <link rel="stylesheet" href="../css/master_page.css">
        
        <link rel="stylesheet" href="../bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="../bootstrap/3.3.7/js/bootstrap.min.js"></script>

    
           
    </head>
    <style>
        nav.navbar {
            background-color:  #000;
        }
        .jumbotron{
            background:   #67b168;
        }
        iframe{
            width: 100%;
        }
       
        .noticia-titulo{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        
                // Use as-is
        
       
    </style>
<body>
    
    <div class="container">
    
<?PHP

    //Presentar los iconos de la pagina
    
    Bootstrap::master_page();
 
     $arrayNiveles=array(array('nivel'=>1,'titulo'=>'Inicio','url'=>$urlHome,'clase'=>''),
    
    array('nivel'=>2,'titulo'=>'Noticias','url'=>'','clase'=>'active'));
    
    echo '<div class="col-xs-12">';
       echo Bootstrap::breadCrum_HomePage($arrayNiveles) ;
       echo '<hr>';
    echo '</div>';
   
    
   ?>
     
        
        <div>
            <div class=" col-xs-12 noticias">


                    <h2   class="noticia-titulo text-center">NOTICIAS</h4>
                    <br></nr>

                    <?PHP
                    echo $str;
                    ?>

                    <div id="results"></div>


            </div>
        </div>

       
   
       
</div>
    
    

        
        <script>
           
           
            $('.breadcrumb').click( function(e)  {
                e.preventDefault();
                //Back page
                var url = window.history.back(); ;
                    
                        
                if(url) {
                    // # open in new window if "_blank" used
                    if(target == '_blank') { 
                        window.open(url, target);
                    } else {
                        window.location = url;
                    }
                }          
            }
        
            );
          
        
        
        
        </script>
    
    
</body>


</html>

