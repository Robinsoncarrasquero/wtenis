<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_excepciones.php';

 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $logueado=false;
   // header('Location: sesion_inicio.php');
    
 }
// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
//mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
//mb_http_output('UTF-8');

header('Content-Type: text/html; charset=utf-8');

$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$estatus=(isset($_GET['estatus'])) ? $_GET['estatus'] : null; // Inscrito o Retirado
$chk="checked";
$chkpagado=0;
if ($codigo_torneo!=null)
{ 
    $codigo_torneo=strtoupper($codigo_torneo);
    $codigo_torneo=mysql_real_escape_string($codigo_torneo);
    $categoria=  strtoupper($categoria);
    $categoria=mysql_real_escape_string($categoria);
    $sexo=  strtoupper($sexo);
    $sexo=mysql_real_escape_string($sexo);
    $estatus=mysql_real_escape_string($estatus);
    
    //Obtenemos los registros desde MySQL
    //Ahora procedemos a extraer los registros de nuestra base de datos, 
    //en este caso solo obtenemos el nombre, dirección y telefono de la tabla empresa de nuestra base de datos.
    $conexion = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname,$conexion);
    //mysql_query('SET NAMES "utf8"');
    //mysqli_query($conexion, 'SET NAMES "utf8"');
    //$codigo_torneo = mysql1_real_escape_string($conexion, $codigo_torneo);
    //$categoria = mysql1_real_escape_string($conexion, $categoria);
   
    $categoria = trim($categoria);
    $codigo_torneo = trim($codigo_torneo);
    $sql = "SELECT torneo.categoria as categoria,torneo.tipo as grado,torneo.numero as numero,torneo.entidad as entidad,torneo.ano as ano,tipo_torneo,nombre as nombre_torneo FROM torneo where codigo='".$codigo_torneo."'";
    $result = mysql_query($sql, $conexion) or die(mysql_error());
    mysql_query('SET NAMES "utf8"');
    $record = mysql_fetch_assoc($result);
    $nombre_torneo=$record['nombre_torneo'];
    
    
    $queEmp = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
            . "atleta.sexo,DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
        ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',atleta.sexo) as Categoria_Sexo,"
            . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
            . "torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
            . "torneoinscritos.afiliado,torneoinscritos.modalidad,"
        .'torneoinscritos.rknacional as elranking '
        ."FROM atleta "
        . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
        . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
        . "WHERE torneo.codigo='".$codigo_torneo."' " ;
    if ($estatus!=null){
        $queEmp .=" AND torneoinscritos.estatus='". $estatus."'";
    }
    if ($sexo!=null){
      $queEmp.=" AND atleta.sexo='".$sexo."'";
    }
    if ($categoria!=null) {
         $queEmp.=" AND torneoinscritos.categoria='".$categoria."' ";
    }
    $chk=" ";
    $chkpagado=1;
    if ($_GET['chkpagaron']) {
         $queEmp.=" AND torneoinscritos.pagado=1 ";
          $chk="checked";
          $chkpagado=0;
    }
    
    
    $queEmp.=" ORDER BY Categoria_Sexo,elranking";
    
    $resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
    mysql_query('SET NAMES "utf8"');
    $totEmp = mysql_num_rows($resEmp);
     
     switch ($sexo){
        case "F":
            $txttit2= "Categoria(".$categoria." FEM.)";
            break;
        case "M":
            $txttit2= "Categoria(".$categoria." MAS.)";
            break;
        default :
            $txttit2= "";
     }
    $txtsistit = "FEDERACION VENEZOLANA DE TENIS";
    if ($estatus!=null){
        $txttit  = "Atletas Retirados del Torneo: $nombre_torneo($codigo_torneo) $txttit2";       
    } else{
        $txttit  = "Atletas pre-inscritos en el Torneo: $nombre_torneo($codigo_torneo) $txttit2";
           
    }
    $txttit  .="<br>Ano: ".$record['ano']." Numero: ".$record['numero']." Grado: ".$record['grado']." Categoria: ".$record['categoria']." Entidad: ".$record['entidad'];
 
    
        
        $Table='
        <div class="row"> 
            <div class="col-xs-12">
              <section class="table-torneo ">
                <div class="table-responsive">
           
                 <table class="table table-bordered table-condensed">
                <thead >
                    <tr class="table-head">
           
                        <th>#</th>';
        
                       
                        if ($_SESSION['niveluser']>0){
                           $str .= '<th>Cedula</th>';
                        }
                        
                        $str .='<th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Nac.</th>
                        <th>Categoria</th>
                        <th>Ranking</th>
                        <th>Entidad</th>
                        <th>Fecha Rank.</th>
                        <th>Modalidad</th>
                        <th>Fecha Reg.</th>
                        <th>Confirmado</th>
                        
                    </tr>
             </thead>
        <tbody>';
          
            $ixx = 0;
            $ano_afiliacion=date("Y");
           
            $fila="";
            while($datatmp = mysql_fetch_assoc($resEmp)) {
                
                $atleta_id=$datatmp['atleta_id'];
                $fecha_fin_torneo=$datatmp['fecha_fin_torneo'];
                $empresa_id=$datatmp['empresa_id'];
                
                
                {
                    $ixx++;
                    $fila .= "<tr >";
                    $fila .= "<td>$ixx</td>";
                    
                    if ($_SESSION['niveluser']>0){
                      $fila .= "<td>".$datatmp['cedula']."</td>";
                    }
                  
                    $fila .= "<td>".$datatmp['nombres']."</td>";
                    $fila .= "<td>".$datatmp['apellidos']."</td>";
                    $fila .= "<td>".$datatmp['fechanac']."</td>";
                    $fila .= "<td>".$datatmp['Categoria_Sexo']."</td>";
                    $fila .= "<td>".$datatmp['elranking']."</td>";
                    $fila .= "<td>".$datatmp['estado']."</td>";
                    $fila .= "<td>".$datatmp['fecha_ranking']."</td>";
                    $fila .= "<td>".$datatmp['modalidad']."</td>";
                    $fila .= "<td>".$datatmp['fecha_registro']."</td>";
                    if ($_SESSION['niveluser']>=0){
                        if ($datatmp['pagado']>0){
                            //echo "<td>OK</td>";
                            $fila .= '<th><p class="glyphicon glyphicon-thumbs-up"<p></th>';
                        }else{
                            $fila .= "<td></td>";
                         }
                            
                    }
                    
                    $fila .= "</tr>";
                }
                


           }
          
        $fila .="</tbody>";
        $fila .="</table>";
           
    $fila .="</div></div></div></div>";
    if ($ixx>0){
        $jsondata = array("Sucess" => True, "html"=>$Table.$fila);

    } else {
        $jsondata = array("Sucess" => False,  "html"=>'No hay datos');
    }

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);            
              
    
}else {
    $error_login=true;
    $mensaje="NO HAY DATOS PARA LA INFORMACION SOLICITADA";
    
    $jsondata = array("Sucess" => False,  "html"=>'No hay datos');
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);            
              
    exit;
   
}

?>

