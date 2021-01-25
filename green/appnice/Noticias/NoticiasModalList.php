<?PHP
//El script se utiliza de forma modal para presentar una lista de items en una tabla y editarlos.
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Paginacion_cls.php';
 
 if ($_SESSION['niveluser']<9){
      header('Location: ../sesion_inicio.php');
    exit;
 }
$pagina= intval(substr($_POST['pagina'],4));

//Instanciamos el objeto empresa para traer los datos
sleep(1);
$obj= new Noticias();

$id=$_SESSION['empresa_id'];
//$rsColeccion=$obj->ReadAll($id);
$querycount="SELECT count(*) as total FROM noticias "
        . " WHERE empresa_id=$id ORDER BY fecha desc ";

$select="SELECT * FROM noticias "
        . " WHERE empresa_id=$id ORDER BY fecha desc ";

$objPaginacion = new Paginacion(3,$pagina);
$objPaginacion->setTotal_Registros($querycount);
$rsColeccion=$objPaginacion->SelectRecords($select);
$nr=0;
$linea = " <table class='table table-striped table-bordered'>";
        $linea .= "<thead>";
            $linea .= "<th>Editar</th>";
            $linea .= "<th>Eliminar</th>";
            $linea .= "<th>Titulo</th>";
            $linea .= "<th>Articulo</th>";
            $linea .= "<th>Autor</th>";
            $linea .= "<th>Fecha</th>";
        $linea .= "</thead>";
        
            //Obtenemos los registros desde MySQL
        $linea .= "<tbody>";
        foreach ($rsColeccion as $value) {
            $rowid=$value['noticia_id'];
            $nr++;
            $linea .="<tr>";
                $linea .= "<td><a href='#' class='edit-record'  data-id='$rowid'>EDIT</a></td>";
                $linea .= "<td><a href='#' class='delete-record'  data-id='$rowid'>DELETE</a></td>";
                
                $linea .= "<td>".$value['titulo']."</td>";
                $linea .= "<td>".$value['mininoticia']."</td>";
                $linea .= "<td>".$value['autor']."</td>";
                $linea .= "<td>".$value['fecha']."</td>";
            $linea .= "</tr>";
        }
        $linea .= "</tbody>";
$linea .= "</table>";

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$linea,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos Registrados","pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;

////Colocamos el Retorno al menu anterior donde fue llamado
//$linea .= '<div class="my-return">
//                        <a href="../sesion_usuario_admin.php"> <button id="btn-salir" type="button" class="btn btn-primary btn-block">Regresar</button></a>
//         </div>';

?>
      
    


