<?php
require_once 'clases/Noticias_cls.php';
require_once 'sql/ConexionPDO.php';
//require 'conexion.php';

if ($_SERVER['REQUEST_METHOD']=='GET'){
    die();
}
if ($_SESSION['niveluser']!=9){
     header('Location: sesion_inicio.php');
 }
sleep(1); // delay para mostrar el ajax loader imagen


$id=$_POST['id'];

//print_r($id);

    
    $obj = new Noticias();
    $obj->Fetch($id);
    $rowid=$obj->ID();
    $titulo=$obj->getTitulo();
    $noticia=$obj->getNoticia();
    $subtitulo=$obj->getMiniNoticia();
    $mininoticia=$obj->getMiniNoticia();
    $autor=$obj->getAutor();
    $fecha=$obj->getFecha();
    
    
    $valor_a_buscar='iframe frameborder="0"'; $valor_de_reemplazo='iframe class="embed-responsive-item"';
    $lanoticia=$noticia;
    str_replace ( $valor_a_buscar , $valor_de_reemplazo , $lanoticia , $contador);
    
    $img='';
    $str='
        <div id="lanoticia'.$id.'" class ="thumbnail">
            <h4 id="POST'.$id.'" class="noticia-subtitulo>'.$subtitulo.' </h4>
            <h4 class="caption">'.$titulo. '</h4>
            
            <span class="post-noticia">'.$lanoticia.'</span>
            
            <p class=" text-info text-right">Fecha:'.$fecha.'</p>
        </div>';
    
    


echo $str;
$obj = NULL;
