<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';
//require 'conexion.php';

if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: Login.php');
}
 
sleep(1); // delay para mostrar el ajax loader imagen


$id=$_POST['id'];
//print_r($id);
if ($id>0) {
    
    $obj = new Noticias();
    $obj->Fetch($id);
    $rowid=$obj->ID();
    $txt_titulo=$obj->getTitulo();
    $txt_noticia=$obj->getNoticia();
    $txt_mininoticia=$obj->getMiniNoticia();
    $txt_autor=$obj->getAutor();
    $txt_estatus=$obj->getEstatus();
    
    $operacion='Save';
    
    
    
    
//    //Comprobamos que los inputs no estén vacíos, y si lo están, mandamos el mensaje correspondiente
//       //Si el tamaño es correcto, subimos los datos
//    $sql = "SELECT * FROM  noticias WHERE noticia_id=$id";
//    $result= mysql_query($sql);
//    
//    
//    while($record = mysql_fetch_assoc($result)){
//        $txt_titulo=$record['titulo'];
//        $txt_noticia=$record['noticia'];
//        $txt_mininoticia=$record['mininoticia'];
//        $txt_autor=$record['autor'];
//    }
    
   
    
    

}else{
    $obj = new Noticias();
    $rowid=0;
    $txt_titulo=$obj->getTitulo();
    $txt_noticia=$obj->getNoticia();
    $txt_mininoticia=$obj->getMiniNoticia();
    $txt_autor=$obj->getAutor();
    $txt_estatus=$obj->getEstatus();
    $txt_imagen=' '; //$obj->getImagen();
    $operacion='Save';
//    $txt_titulo=' ';
//    $txt_noticia=' ';
//    $txt_mininoticia=' ';
//    $txt_autor='Sys';
//    $rowid=0;

}


 
$str='
<div class="form-group col-xs-12 col-md-12">
    <label for="txt_titulo">Titulo</label>
    <input type="text" class="form-control" lenght="50" id="txt_titulo" name="txt_titulo" placeholder="Titulo" value="'.$txt_titulo.'">
</div>
<div  class="form-group col-xs-12 col-md-12">
    <label for="txt_mininoticia">Articulo</label>
    <textarea class="form-control" rows="2" lenght="100" id="txt_mininoticia" name="txt_mininoticia" placeholder="Subtitulo"  >'
  .$txt_mininoticia.'</textarea>
</div>

<div  class="form-group col-xs-12">
  <label for="txt_noticia">Noticia</label>
  <textarea class="form-input-block-level" rows="30"   id="summernote" name="content" placeholder="Noticia"  >'
  .$txt_noticia.'</textarea>
</div>

 <div class="form-group col-xs-12 col-md-6">
  <label for="txt_autor">Autor</label>
  <input type="text" class="form-control" lenght="50" id="txt_autor" name="txt_autor" placeholder="Autor" value="'.$txt_autor.'">
</div>



<div class="form-group col-xs-12 col-md-6">
    <label  for="txt_estatus">Estatus</label>
    <select name="txt_estatus" class="form-control">';

    if ($txt_estatus!="P"){
        $str .= '<option selected value="N">No Publicar</option>
                <option value="P">Publicar</option>';
    }else{
         $str .='<option  value="N">No Publicar</option>
                 <option selected value="P">Publicar</option>';
    }
$str.='                        
    </select>
</div>



<div class="form-group hidden">
  <label for="txt_id">Noticia ID</label>
  <input type="text" class="form-control" id="txt_id" name="txt_id" value="'.$rowid.'">

</div>


 <div class="form-group col-xs-12">
    <button type="button" id="close" value="close" class="btn btn-default btnbtn">Close</button>
    <input type="submit"  id="'.$operacion.'" value="'.$operacion.'" class="btn btn-primary btnbtn"> 

    
</div>';

echo $str;

$obj = NULL;


    
    
?>






    
    

