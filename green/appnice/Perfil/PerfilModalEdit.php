<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

if (isset($_SESSION['niveluser'])){ 
    if ($_SESSION['niveluser']>0){
     header('Location: ../bsPanel.php'); 
     exit;
    }
}else{
    header('Location: ../sesion_inicio.php'); 
    exit;
}
sleep(1); // delay para mostrar el ajax loader imagen


$id=$_POST['id'];
//print_r($id);
$operacion='Guardar';
if ($id>0) {
    $objAtleta = new Atleta();
    $objAtleta->Fetch($id);
    $rowid=$objAtleta->getID();
    $txt_cedula = $objAtleta->getCedula();
    $txt_nombres=$objAtleta->getNombres();
    $txt_apellidos=$objAtleta->getApellidos();
    $txt_sexo=$objAtleta->getSexo();
    $txt_fechaNacimiento=$objAtleta->getFechaNacimiento();
    $txt_biografia=$objAtleta->getBiografia();
    $txt_cedularep=$objAtleta->getCedulaRepresentante();
    $txt_nombrerep=$objAtleta->getNombreRepresentante();
    $txt_direccion=$objAtleta->getDireccion();
    $txt_telefonos=$objAtleta->getTelefonos();
    $txt_email=$objAtleta->getEmail();
    $txt_id=$rowid;
    
    
  
}else{
    $objAtleta = new Atleta();
    $rowid=0;
    $txt_cedula = $objAtleta->getCedula();
    $txt_nombres=$objAtleta->getNombres();
    $txt_apellidos=$objAtleta->getApellidos();
    $txt_sexo=$objAtleta->getSexo();
    $txt_fechaNacimiento=$objAtleta->getFechaNacimiento();
    $txt_biografia=$objAtleta->getBiografia();
    $txt_cedularep=$objAtleta->getCedulaRepresentante();
    $txt_nombrerep=$objAtleta->getNombreRepresentante();
    $txt_direccion=$objAtleta->getDireccion();
    $txt_telefonos=$objAtleta->getTelefonos();
    $txt_email=$objAtleta->getEmail();
    $txt_id=$rowid;
}

 

 $str='
     <div class="form-group col-xs-12 col-sm-4">
   
      <label for="txt_cedula">Cedula</label>
      <input type="text" readonly class="form-control " lenght="20" id="txt_cedula" name="txt_cedula" placeholder="Cedula" value="' . $txt_cedula . '">
    </div>
    <div class="form-group col-xs-12 col-sm-4">
    
      <label for="txt_nombres">Nombre</label>
      <input type="text" class="form-control" lenght="50" id="txt_nombres" name="txt_nombres" placeholder="Nombre" value="' . $txt_nombres . '">
    </div>
    
     <div class="form-group col-xs-12 col-sm-4">
   
      <label for="txt_apellidos">Nombre</label>
      <input type="text" class="form-control" lenght="50" id="txt_apellidos" name="txt_apellidos" placeholder="Apellido" value="' . $txt_apellidos . '">
    </div>';
 
    
    $str .='<div class="form-group col-xs-12 col-sm-6">'   ;
    if ($txt_sexo=="F"){
        $str .= ' <label for="txt_sexo">Sexo</label>
        <select name="txt_sexo" class="form-control">
        
        <option selected value="F">Femenino</option>
        <option value="M">Masculino</option>
        </select>
        </div>';
    }else{
       $str .= ' <label for="txt_sexo">Sexo</label>
        <select name="txt_sexo" class="form-control">
       
        <option value="F">Femenino</option>
        <option selected value="M">Masculino</option>
        </select>
        </div>';
    }
    
     $str .=
    ' <div class="form-group col-xs-12 col-sm-6 ">
        <label for="txt_fechaNacimiento">Fecha Nacimiento</label>
       <input type="date" readonly class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento"  value="' .$txt_fechaNacimiento. '">
    
    </div>';
   
                           
               
    $str .= 
    '  
    <div class="form-group col-xs-12">
      <label for="txt_biografia">Biografia</label>
      <textarea class="form-control" rows="5" lenght="200" id="txt_biografia" name="txt_biografia" placeholder="Biografia">'
        . $txt_biografia . '</textarea>
    </div>
    
     <div class="form-group col-xs-12 col-sm-6">
      <label for="txt_cedularep">Cedula Representante</label>
      <input type="text" class="form-control" lenght="20" id="txt_cedularep" name="txt_cedularep" placeholder="Cedula representante" value="' . $txt_cedularep . '">
    </div>
    
    <div class="form-group col-xs-12 col-sm-6">
      <label for="txt_nombrerep">Nombre Representante</label>
      <input type="text" class="form-control" lenght="50" id="txt_nombrerep" name="txt_nombrerep" placeholder="Nombre representante" value="' . $txt_nombrerep . '">
    </div>
    
    
    
    <div class="form-group col-xs-12 col-sm-12">
      <label for="txt_direccion">Direccion</label>
      <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"  >'
        . $txt_direccion . '</textarea>
    </div>
    
   <div class="form-group col-xs-12 col-sm-6">
      <label for="txt_telefonos">Telefonos</label>
      <input type="text" class="form-control" lenght="45" id="txt_telefonos" name="txt_telefonos" placeholder="Telefonos 0212-9999999/0414-9999999" value="' . $txt_telefonos . '">
    </div>
    <div class="form-group col-xs-12 col-sm-6">
      <label for="txt_email">Email</label>
      <input type="email" class="form-control" lenght="100" id="txt_email" name="txt_email" placeholder="Email" value="' . $txt_email . '">
    </div>
    
    <div class="form-group hidden">
      <label for="txt_id">Atleta</label>
      <input type="text" class="form-control" id="txt_id" name="txt_id" value="' . $rowid . '">
    </div>
   
   

    <div class="pull-right ">
        <button type="button" id="close" value="close" class="btn btn-default  btnbtn">Cancelar</button>
        <input type="submit"  id="' . $operacion . '" value="' . $operacion . '" class="btn btn-primary  btnbtn"> 


    </div>';




echo $str;

$obj = NULL;

exit;
    
    
?>






    
    

