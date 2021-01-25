<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_excepciones.php';
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/AfiliacionesXML_cls.php';

 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    $logueado=false;
   // header('Location: sesion_inicio.php');
    
 }

header('Content-Type: text/html; charset=utf-8');

$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$estatus=(isset($_GET['estatus'])) ? $_GET['estatus'] : null; // Inscrito o Retirado
$chk="checked";
$chkpagado=0;
 
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
mysql_query('SET NAMES "utf8"');
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

$strRanking="torneoinscritos.rknacional as elranking ";


$queEmp = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
        . "atleta.sexo,DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
    ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',atleta.sexo) as Categoria_Sexo,"
        . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
        . "torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
        . "torneoinscritos.afiliado,torneoinscritos.modalidad,"
    .$strRanking
    ."FROM atleta "
    . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
    . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
    . "WHERE torneo.codigo='".$codigo_torneo."' && torneoinscritos.estatus is null" ;
if ($sexo!=null){
  $queEmp.=" AND atleta.sexo='".$sexo."'";
}
if ($categoria!=null) {
     $queEmp.=" AND torneoinscritos.categoria='".$categoria."' ";
}

$queEmp.=" ORDER BY Categoria_Sexo,elranking";

$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
//mysql_query('SET NAMES "utf8"');
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

$txttit  = "Atletas pre-inscritos en el Torneo: $nombre_torneo($codigo_torneo) $txttit2";

$txttit  .="<br>Ano: ".$record['ano']." Numero: ".$record['numero']." Grado: ".$record['grado']." Categoria: ".$record['categoria']." Entidad: ".$record['entidad'];
$filetmp= "Torneo_".$record['ano']."_".$record['numero']."_".$record['grado']."_".$categoria."_".$record['entidad'];
 
$booksArray = array();

 while($datatmp = mysql_fetch_assoc($resEmp)) {
    
    $atleta_id=$datatmp['atleta_id'];
    $fecha_fin_torneo=$datatmp['fecha_fin_torneo'];
    $empresa_id=$datatmp['empresa_id'];
    $afiliado=$datatmp['afiliado'];

    $atleta_id = $datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    $sexo = $objAtleta->getSexo();
    
    $rowid = $datatmp['id'];
    $objNacionalidad= new Nacionalidad();
    $objNacionalidad->Fetch($objAtleta->getNacionalidadID());
    
    $objEmpresa= new Empresa();
    $objEmpresa->Fetch($objAtleta->getEstado());
    if ($objEmpresa->Operacion_Exitosa()){
        $id_asociacion=$objEmpresa->getID_Asociacion();
    }else{
        $id_asociacion=1; //asociacion XX INDEFINIDA segun la tabla de sistema viejo
    }
    
    //Busca la ultima afiliacion del atleta
    $objAfiliacion_afiliado= new Afiliaciones();
    $objAfiliacion_afiliado->Atleta($atleta_id);
    
              
    //Separamos los nombres y apellidos    
    $arraynombre=explode(" ",$objAtleta->getNombres());
    $arrayapelli=explode(" ",$objAtleta->getApellidos());
    $dato = array(
        'atleta_id' => $objAtleta->getID(),
        'idJugador' => $ixx,
        'cedula' => $objAtleta->getCedula(),
        'nombre' => $arraynombre[0],
        'snombre' => $arraynombre[1],
        'apellido' => $arrayapelli[0],
        'sapellido' => $arrayapelli[1],
        'sexo' => $objAtleta->getSexo()
    );
    array_push($booksArray, $dato);
}


if (count($booksArray)) {
    
    $date_hoy=date_create(); // fecha del servidor 
    //echo date_format($date_hoy,"Y-m-d H:i:s");
    $datetime= date_timestamp_get($date_hoy);
    $datenow= date_format($date_hoy,"Y-M-d");
    $lote_name=$datenow."_".$datetime;
    //Creamos el archivo xml
    $filexml = createXMLfile($booksArray,$filetmp);
    //Recorremos el array de registros para actualizar
    //el campo indicador de dato Exportado al archivo xml 
    //Para el sistema de afiliaciones interno.
    $ixx=0;
    for ($i = 0; $i < count($booksArray); $i++) {
        $atleta_id = $booksArray[$i]['atleta_id'];
        //Si es exportacion definitiva actualizamos el campo de exportacion
        
        $rowid=$atleta_id;
        $ixx ++;
     }
      
    $jsondata = array("Sucess" => True, "FileXML" =>$filexml);
    
} else {
    $jsondata = array("Sucess" => False, "FileXML" => '<b>Ninguno</b>');
}

//header('Content-type: application/json; charset=utf-8');
//echo json_encode($jsondata, JSON_FORCE_OBJECT);

   

function createXMLfile($booksArray,$lote_Name_){
   
   
   $xml     = new DOMDocument('1.0', 'utf-8'); 

   //Nivel fvt
   $xml_fvt     = $xml->createElement('fvt'); 
   
   //Nivel Afiliaciones
   $xml_afi    = $xml->createElement('afiliaciones'); 

   for($i=0; $i<count($booksArray); $i++){
    
     $bookIDjugador        =  $booksArray[$i]['idJugador'];  

     $bookCedula = htmlspecialchars($booksArray[$i]['cedula']);
     
     $bookNombre    =  $booksArray[$i]['nombre']; 
     
     $bookSNombre    =  $booksArray[$i]['snombre']; 
     
     $bookApellido    =  $booksArray[$i]['apellido']; 
     
     $bookSApellido    =  $booksArray[$i]['sapellido']; 

     $bookSexo     =  $booksArray[$i]['sexo']; 

      
     $book = $xml->createElement('jugador');
    
     $book->setAttribute('idJugador', $bookIDjugador);
     
     $bkcedula     = $xml->createElement('cedula', $bookCedula); 
 
     $book->appendChild($bkcedula); 

     
     $bkNombre   = $xml->createElement('nombre', $bookNombre); 

     $book->appendChild($bkNombre); 
     
     $bkSNombre   = $xml->createElement('snombre', $bookSNombre); 

     $book->appendChild($bkSNombre); 
    
     $bkApellido   = $xml->createElement('apellido', $bookApellido); 

     $book->appendChild($bkApellido);
     
     $bkSApellido   = $xml->createElement('sapellido', $bookSApellido); 

     $book->appendChild($bkSApellido);
     
     $bkSexo   = $xml->createElement('sexo', $bookSexo); 

     $book->appendChild($bkSexo);
     
      
     $xml_afi->appendChild($book);
    

   }
   $xml_fvt->appendChild($xml_afi); 
   $xml->appendChild( $xml_fvt);
   
   
   
   $fileName =$lote_Name_.'.xml';
   
   $xml->formatOutput = true;
   $el_xml = $xml->saveXML();
   //$xml->save($fileName); 
    //echo "<p><b>El XML ha sido creado.... Mostrando en texto plano:</b></p>".
//         htmlentities($el_xml)."<br/><hr>";
  
    header("Content-Type: application/xml");
    header('Content-Disposition: attachment; filename="'.$fileName.'"');
    echo $el_xml;
    return $el_xml;
 } 


