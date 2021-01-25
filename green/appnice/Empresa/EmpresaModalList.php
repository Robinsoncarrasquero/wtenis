<?PHP
//El script se utiliza de forma modal para presentar una lista de items en una tabla y editarlos.
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';

 
 if ($_SESSION['niveluser']!=9){
     header('Location: ../sesion_inicio.php');
    exit;
 }
 
//Instanciamos el objeto empresa para traer los datos
sleep(1);
$objEmpresa = new Empresa();
$objEmpresa->Fetch($_SESSION['asociacion']);
if ($objEmpresa->Operacion_Exitosa()) {
   //Obtenemos los registros desde MySQL
    
     
    echo " <table class='table table-striped table-bordered'>";
        echo "<thead>";
            echo "<th>Accion</th>";
            echo "<th>Estado</th>";
            echo "<th>Nombre</th>";
            echo "<th>Asociacion</th>";
            
        echo "</thead>";
        echo "<tbody>";
            $rowid=$objEmpresa->get_Empresa_id();
            echo"<tr>";
                echo "<td><a href='#' class='edit-record'  data-id='$rowid'>EDIT</a></td>";
                echo "<td>".$objEmpresa->getEstado()."</td>";
                echo "<td>".$objEmpresa->getNombre()."</td>";
                echo "<td>".$objEmpresa->getAsociacion()."</td>";
            echo "</tr>";
        echo "</tbody>";
    echo "</table>";
    //Colocamos el Retorno al menu anterior donde fue llamado
    echo '<div class="my-return">
                        <a href="../sesion_usuario_admin.php"> <button id="btn-salir" type="button" class="btn btn-primary btn-block">Regresar</button></a>
         </div>';
   
          
}
?>
      
    


