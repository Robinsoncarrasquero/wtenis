<?PHP
//El script se utiliza de forma modal para presentar una lista de items en una tabla y editarlos.
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

 
 if ($_SESSION['niveluser']>0){
     header('Location: ../bsPanel.php');
    exit;
 }
 
//Instanciamos el objeto empresa para traer los datos
sleep(1);
$ObjAtleta = new Atleta();
$ObjAtleta->Fetch($_SESSION['atleta_id']);
//Para generar las miga de pan mediante una clase estatica
require_once '../clases/Bootstrap2_cls.php';
$arrayNiveles=array(array('nivel'=>1,'titulo'=>'Inicio','url'=>'../bsPanel.php','clase'=>''),
    array('nivel'=>2,'titulo'=>'Cambio Clave','url'=>'bsChangeKey.php','clase'=>''),
    array('nivel'=>3,'titulo'=>'Cambio Email','url'=>'bsChangeEmail.php','clase'=>''),
    array('nivel'=>4,'titulo'=>'Mis Datos','url'=>'PerfilModal.php','clase'=>'active'));
echo Bootstrap::breadCrum($arrayNiveles);  
if ($ObjAtleta->Operacion_Exitosa()) {
   //Obtenemos los registros desde MySQL
    $rowid=$ObjAtleta->getID();
     echo '<div class="container"> <div class="row"> 
            <div class="col-xs-12">
            <div class="table-responsive">';
                  
   echo " <table class='table table-striped table-bordered table-condensed'>";
        echo "<thead>";
           
            echo "<th>Modificar</th>";
            echo "<th>Cedula</th>";
            echo "<th>Nombre</th>";
            echo "<th>Sexo</th>";
            echo "<th>Telefonos</th>";
            

            
        echo "</thead>";
        echo "<tbody>";
            
            echo"<tr>";
            echo "<td><a href='#'  data-id='$rowid' class=' edit-record glyphicon glyphicon-pencil'></a></td>";
                                           
              
               // echo "<td><a href='#' class='edit-record'  data-id='$rowid'>EDITAR</a></td>";
                echo "<td>".$ObjAtleta->getCedula()."</td>";
                echo "<td>".$ObjAtleta->getNombres()."</td>";
                echo "<td>".($ObjAtleta->getSexo()=="" ? "Error":$ObjAtleta->getSexo()). "</td>";
                echo "<td>".$ObjAtleta->getTelefonos()."</td>";
            echo "</tr>";
            if ($ObjAtleta->getSexo()!="F" && $ObjAtleta->getSexo()!="M"){
                echo '<p class="alert alert-warning">'.Bootstrap_Class::texto("Notificacion:").' Es muy importante que actualice los datos del Perfil como Sexo, Telefonos, Direccion, Correo'.'</p>';
                echo '<p class="alert alert-danger">'.Bootstrap_Class::texto("Advertencia:","danger").' Sus datos parecen no estar completos, usted debe actualizar sus datos'.'</p>';
        
                
            }else{
                 echo '<p class="alert alert-info">'.Bootstrap_Class::texto("Notificacion:","warning").' Es muy importante que actualice los datos del Perfil como Sexo, Telefonos, Direccion, Correo'.'</p>';
                 echo '<p class="alert alert-success">'.Bootstrap_Class::texto("Notificacion:","warning").' Sus datos parecen estar completos y actualizados'.'</p>';
      
            }
            echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
     echo "</div>";
     echo "</div>";
    //Colocamos el Retorno al menu anterior donde fue llamado
//    echo '<div class="pull right">
//                        <a href="sesion_usuario.php"> <button id="btn-salir" type="button" class="btn btn-primary btn-block">Regresar</button></a>
//         </div>';
   
          
}
?>
      
    


