<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
//require 'conexion.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}
sleep(1); // delay para mostrar el ajax loader imagen

$niveluser=$_SESSION['niveluser'];
$id=$_POST['id'];
//print_r($id);
$operacion='Guardar';
if ($id>0) {
    $objEmpresa = new Empresa();
    $objEmpresa->Fetch($_SESSION['asociacion']);
    $rowid=$objEmpresa->get_Empresa_id();
    $txt_nombre=$objEmpresa->getNombre();
    $txt_descripcion=$objEmpresa->getDescripcion();
    $txt_direccion=$objEmpresa->getDireccion();
    $txt_email=$objEmpresa->getEmail();
    $txt_twitter=$objEmpresa->getTwitter();
    $txt_estado=$objEmpresa->getEstado();
    $txt_telefonos=$objEmpresa->getTelefonos();
    $txt_colorjumbotron=$objEmpresa->getColorJumbotron();
    $txt_bgcolorjumbotron=$objEmpresa->getbgColorJumbotron();
    $txt_colorNavbar=$objEmpresa->getColorNavbar();
    $txt_fotos=$objEmpresa->getFotos();
    $txt_constancia = $objEmpresa->getConstancia();
    $txt_banco=$objEmpresa->getBanco();
    $txt_cuenta=$objEmpresa->getCuenta();
    $txt_rif = $objEmpresa->getRif();
  
}else{
    $objEmpresa = new Empresa();
    $rowid=$objEmpresa->get_Empresa_id();
    $txt_nombre=$objEmpresa->getNombre();
    $txt_descripcion=$objEmpresa->getDescripcion();
    $txt_direccion=$objEmpresa->getDireccion();
    $txt_email=$objEmpresa->getEmail();
    $txt_twitter=$objEmpresa->getTwitter();
    $txt_estado=$objEmpresa->getEstado();
    $txt_telefonos=$objEmpresa->getTelefonos();
    $txt_colorjumbotron=$objEmpresa->getColorJumbotron();
    $txt_bgcolorjumbotron=$objEmpresa->getbgColorJumbotron();
    $txt_colorNavbar=$objEmpresa->getColorNavbar();
    $txt_fotos=$objEmpresa->getFotos();
    $txt_constancia = $objEmpresa->getConstancia();
    $txt_banco=$objEmpresa->getBanco();
    $txt_cuenta=$objEmpresa->getCuenta();
    $txt_rif = $objEmpresa->getRif();
    
}

 $str='
       
    <div class="form-group col-xs-12 col-md-12">
      <label for="txt_nombre">Nombre</label>
      <input type="text" class="form-control" lenght="50" id="txt_nombre" name="txt_nombre" placeholder="Nombre" value="' . $txt_nombre . '">
    </div>
   <div class="form-group col-xs-12 col-md-12">
      <label for="txt_direccion">Direccion</label>
      <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"  >'
        . $txt_direccion . '</textarea>
    </div>
   <div class="form-group col-xs-12 col-md-12">
      <label for="txt_descripcion">Descripcion</label>
      <textarea class="form-control" rows="5" lenght="250" id="txt_descripcion" name="txt_descripcion" placeholder="Descripcion">'
        . $txt_descripcion . '</textarea>
    </div>
    <div class="form-group col-xs-12 col-md-6">
      <label for="txt_rif">Rif</label>
      <input type="text" class="form-control" lenght="50" id="txt_rif" name="txt_rif" placeholder="Rif" value="' . $txt_rif . '">
    </div>
   <div class="form-group col-xs-12 col-md-6">
      <label for="txt_telefonos">Telefonos</label>
      <input type="text" class="form-control" lenght="50" id="txt_telefonos" name="txt_telefonos" placeholder="Telefonos" value="' . $txt_telefonos . '">
    </div>
    <div class="form-group col-xs-12 col-md-6">
      <label for="txt_email">Email</label>
      <input type="text" class="form-control" lenght="100" id="txt_email" name="txt_email" placeholder="Email" value="' . $txt_email . '">
    </div>
    <div class="form-group col-xs-12 col-md-6">
      <label for="txt_twitter">Twitter</label>
      <input type="text" class="form-control" lenght="30" id="txt_twitter" name="txt_twitter" placeholder="Twitter" value="' . $txt_twitter . '">
    </div>
    <div class="form-group col-xs-12 col-md-6">
      <label for="txt_banco">Banco</label>
      <input type="text" class="form-control" lenght="100" id="txt_banco" name="txt_banco" placeholder="Banco" value="' . $txt_banco . '">
    </div>
    <div class="form-group col-xs-12 col-md-6">
      <label for="txt_cuenta">Numero de Cuenta</label>
      <input type="text" class="form-control" lenght="100" id="txt_cuenta" name="txt_cuenta" placeholder="Cuenta" value="' . $txt_cuenta . '">
    </div>
    <div class="form-group hidden">
      <label for="txt_id">Afiliado</label>
      <input type="text" class="form-control" id="txt_id" name="txt_id" value="' . $rowid . '">
    </div>
     <div class="form-group hidden">
      <label for="txt_estado">Asociacion</label>
      <input type="text" class="form-control" lenght="10" id="txt_estado" name="txt_estado" value="' . $txt_estado . '">
    </div>
    <div class="form-group col-xs-12 col-md-4">
      <label for="txt_colorjumbotron">Color Letras Jumbotron</label>
       <input type="color" class="form-control" lenght="20" id="txt_colorjumbotron" name="txt_colorjumbotron" value="' . $txt_colorjumbotron . '">
    </div>
   <div class="form-group col-xs-12 col-md-4">
      <label for="txt_bgcolorjumbotron">Color de Fondo(Background) Jumbotron</label>
       <input type="color" class="form-control" lenght="20" id="txt_bgcolorjumbotron" name="txt_bgcolorjumbotron" value="' . $txt_bgcolorjumbotron . '">
    </div>
    <div class="form-group col-xs-12 col-md-4">
      <label for="txt_colorNavbar">Color Barra Navegacion(NavBar)</label>
      <input type="color" class="form-control" lenght="20" id="txt_colorNavbar" name="txt_colorNavbar" value="' . $txt_colorNavbar . '">
    </div>
    
    <!-- <div  class="form-group col-xs-12">
    <label for="txt_fotos">Fotos</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote1" name="contentfotos" placeholder="Cargue las fotos del site"  >
    .$txt_fotos.</textarea>
    </div> -->
 
    <div  class="form-group col-xs-12 hidden">
    <label for="txt_constancia">Constancia</label>
    <textarea class="form-input-block-level " rows="30"   id="summernote2" name="contentcarta" placeholder="Escriba la constancia"  >'
    .$txt_constancia.'</textarea>
    </div>

    <div class="form-group col-xs-12 ">
        <button type="button" id="close" value="close" class="btn btn-default btnbtn">Cancelar</button>
        <input type="submit"  id="' . $operacion . '" value="' . $operacion . '" class="btn btn-primary  btnbtn"> 


    </div>';




echo $str;

$obj = NULL;


    
    
?>






    
    

