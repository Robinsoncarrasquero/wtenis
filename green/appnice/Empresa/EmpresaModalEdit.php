<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';

 
 if ($_SESSION['niveluser']!=9){
    header('Location: ../sesion_inicio.php');
 }
sleep(2); // delay para mostrar el ajax loader imagen
$id=$_POST['id'];
$operacion=$_POST['operacion']; // Se permite 2 operaciones Save o Edit

if ($_POST['operacion']=="Edit") {
   
    $objEmpresa = new Empresa();
    $objEmpresa->Fetch($_SESSION['asociacion']);
    if ($objEmpresa->Operacion_Exitosa()) {
        
        $rowid=$objEmpresa->get_Empresa_id();
        $txt_nombre=$objEmpresa->getNombre();
        $txt_direccion=$objEmpresa->getDireccion();
        $txt_direccion=$objEmpresa->getDireccion();
        $txt_email=$objEmpresa->getEmail();
        $txt_colorjumbotron=$objEmpresa->getColorJumbotron();
        $txt_colorNavbar=$objEmpresa->getColorNavbar();
       
       
        $str='
       
            <div class="form-group">
              <label for="txt_nombre">Nombre</label>
              <input type="text" class="form-control" lenght="50" id="txt_nombre" name="txt_nombre" placeholder="Nombre" value="'.$objEmpresa->getNombre().'">
            </div>
            <div  class="form-group">
              <label for="txt_direccion">Direccion</label>
              <textarea class="form-control" rows="2" lenght="150" id="txt_direccion" name="txt_direccion" placeholder="Direccion"  >'
              .$objEmpresa->getDireccion().'</textarea>
            </div>
            <div class="form-group">
              <label for="txt_descripcion">Descripcion</label>
              <textarea class="form-control" rows="5" lenght="250" id="txt_descripcion" name="txt_descripcion" placeholder="Descripcion">'
              .$objEmpresa->getDescripcion().'</textarea>
            </div>
            <div class="form-group">
              <label for="txt_telefonos">Telefonos</label>
              <input type="text" class="form-control" lenght="50" id="txt_telefonos" name="txt_telefonos" placeholder="Telefonos" value="'.$objEmpresa->getTelefonos().'">
            </div>
            <div class="form-group">
              <label for="txt_email">Email</label>
              <input type="text" class="form-control" lenght="100" id="txt_email" name="txt_email" placeholder="Email" value="'.$objEmpresa->getEmail().'">
            </div>
             <div class="form-group">
              <label for="txt_twitter">Twitter</label>
              <input type="text" class="form-control" lenght="30" id="txt_twitter" name="txt_twitter" placeholder="Twitter" value="'.$objEmpresa->getTwitter().'">
            </div>
            <div class="form-group hidden">
              <label for="txt_id">Afiliado</label>
              <input type="text" class="form-control" id="txt_id" name="txt_id" value="'.$rowid.'">
            </div>
             <div class="form-group hidden">
              <label for="txt_estado">Asociacion</label>
              <input type="text" class="form-control" lenght="10" id="txt_estado" name="txt_estado" value="'.$objEmpresa->getEstado().'">
            </div>
            <div class="form-group">
              <label for="txt_colorJumbotron">Color Jumbotron</label>
               <input type="color" class="form-control" lenght="20" id="txt_colorjumbotron" name="txt_colorjumbotron" value="'.$objEmpresa->getColorJumbotron().'">
            </div>
             <div class="form-group">
              <label for="txt_colorNavbar">Color Barra Navegacion</label>
              <input type="color" class="form-control" lenght="20" id="txt_colorNavbar" name="txt_colorNavbar" value="'.$objEmpresa->getColorNavbar().'">
            </div>

            </div>';
            

        
       
        echo $str;
    }
}else{
   echo "No hay datos";
    
}    
?>



    
    

