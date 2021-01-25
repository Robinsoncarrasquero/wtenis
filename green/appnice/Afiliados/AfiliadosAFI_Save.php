<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';

/* 
 * Programa para crear el archivo xml que generara los datos de los afiliados formalizados
 */

$afiliacion_id=$_POST['id'];

$chkFiltro=$_POST['chkFiltro']; //Confirmacion de pagos o Por pagar
       
            //Buscado la data de la afiliacion
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Find($afiliacion_id);

$afiliacion_id = $rsAfiliacion->get_ID();
$ano_afiliacion = $rsAfiliacion->getAno();
$fvtCicloCobro = $rsAfiliacion->getFVTCicloCobro();
$fvt_monto = $rsAfiliacion->getFVT();
$asociacionCicloCobro = $rsAfiliacion->getAsociacionCicloCobro();
$aso_monto = $rsAfiliacion->getAsociacion();
$sis_monto = $rsAfiliacion->getSistemaWeb();
$sistemaWebCicloCobro = $rsAfiliacion->getSistemaWebCicloCobro();


//Manejos coleccion de afiliaciones
$objAfiliaciones = new Afiliaciones();

switch ($chkFiltro) {
    case 1://Afiliaciones Formalizadas
        $rsAfiliados = $objAfiliaciones->rsAfiliacionesWebFormalizadas($afiliacion_id);
        break;
    case 0: //Afiliaciones no formalizadas
        $rsAfiliados = $objAfiliaciones->rsAfiliacionesWebNoFormalizadas($afiliacion_id);
        break;

    default:

        break;
}
$ixx = 0;
$nroPagos = 0;
$totalAso = 0;
$totalFvt = 0;
$totalWeb = 0;
$booksArray = array();

foreach ($rsAfiliados as $datatmp) {
    $atleta_id = $datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    $sexo = $objAtleta->getSexo();
    $ixx ++;
    $rowid = $datatmp['afiliaciones_id'];

    if ($datatmp['pagado'] > 0) {
        $xfvt_monto = $datatmp['fvt'];
        $xaso_monto = $datatmp['asociacion'];
        $xsis_monto = $datatmp['sistemaweb'];
    } else {
        $xfvt_monto = $fvt_monto;
        $xaso_monto = $aso_monto;
        $xsis_monto = $sis_monto;
    }

    //IMPORTANTE !! 
    //Inicializamos para no acumular las afiliaciones de federacion y asociaon
    //Ya que son anuales y se pagan una sola vez
    {
        $nroPagos ++;
        $totalFvt = $totalFvt + $xfvt_monto;
        $totalAso = $totalAso + $xaso_monto;
        $totalWeb = $totalWeb + $xsis_monto;
    }
    
    $objNacionalidad= new Nacionalidad();
    $objNacionalidad->Fetch($objAtleta->getNacionalidadID());
    
    $objEmpresa= new Empresa();
    $objEmpresa->Fetch($objAtleta->getEstado());
    if ($objEmpresa->Operacion_Exitosa()){
        $id_asociacion=$objEmpresa->getID_Asociacion();
    }else{
        $id_asociacion=1; //asociacion XX INDEFINIDA segun la tabla de sistema viejo
    }
              
    //Separamos los nombres y apellidos    
    $arraynombre=explode(" ",$objAtleta->getNombres());
    $arrayapelli=explode(" ",$objAtleta->getApellidos());
    $dato = array(
        'idJugador' => '',
        'cedula' => $objAtleta->getCedula(),
        'nacionalidad' => $objNacionalidad->getPais(),
        'nombre' => $arraynombre[0],
        'snombre' => $arraynombre[1],
        'apellido' => $arrayapelli[0],
        'sapellido' => $arrayapelli[1],
        'sexo' => $objAtleta->getSexo(),
        'correo' => $objAtleta->getEmail(),
        'telefono' => $objAtleta->getTelefonos(),
        'celular' => $objAtleta->getTelefonos(),
        'fecha_nacimiento' => $objAtleta->getFechaNacimiento(),
        'lugar_nacimiento' => '',
        'pasaporte' => '',
        'id_direccion' => '',
        'direccion' => $objAtleta->getDireccion(),
        'lugar_trabajo' => '',
        'tel_trabajo' => $objAtleta->getTelefonos(),
        'correo_trabajo' => '',
        'asociacion' => $id_asociacion,
        'club' => '',
        'fecha_afiliacion' => $datatmp['fecha_pago'],
        'idcatsingles' => -1,
        'idcatdobles' => -1,
        'id_representante' => 0
    );
    array_push($booksArray, $dato);
}


if (count($booksArray)) {
    createXMLfile($booksArray);
    $jsondata = array("Sucess" => True);
} else {
    $jsondata = array("Sucess" => False);
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

   

function createXMLfile($booksArray){
   
   
   $xml     = new DOMDocument('1.0', 'utf-8'); 

   //Nivel fvt
   $xml_fvt     = $xml->createElement('fvt'); 
   
   //Nivel Afiliaciones
   $xml_afi    = $xml->createElement('afiliaciones'); 

   for($i=0; $i<count($booksArray); $i++){
    
     $bookIDjugador        =  $booksArray[$i]['idJugador'];  

     $bookCedula = htmlspecialchars($booksArray[$i]['cedula']);
     
     $bookNacionalidad = htmlspecialchars($booksArray[$i]['nacionalidad']);

     $bookNombre    =  $booksArray[$i]['nombre']; 
     
     $bookSNombre    =  $booksArray[$i]['snombre']; 
     
     $bookApellido    =  $booksArray[$i]['apellido']; 
     
     $bookSApellido    =  $booksArray[$i]['sapellido']; 

     $bookSexo     =  $booksArray[$i]['sexo']; 

     $bookCorreo      =  $booksArray[$i]['correo']; 

     $bookTelefono  =  $booksArray[$i]['telefono'];	
     
     $bookCelular  =  $booksArray[$i]['celular'];
     
     $bookFechaNac  = date_format(date_create($booksArray[$i]['fecha_nacimiento']),"Y-m-d");
     
     $bookLugarNac  =  $booksArray[$i]['lugar_nacimiento'];
     
     $bookPasaporte  =  $booksArray[$i]['pasaporte'];
     
     $bookIDdireccion  =  $booksArray[$i]['id_direccion'];
     
     $bookLugarTrabajo  =  $booksArray[$i]['lugar_trabajo'];
     
     $bookTelTrabajo  =  $booksArray[$i]['tel_trabajo'];
     
     $bookCorreoTrabajo  =  $booksArray[$i]['correo_trabajo'];
     
     $bookAsociacion  =  $booksArray[$i]['asociacion'];
     
     $bookClub  =  $booksArray[$i]['club'];
     
     $bookFechaAfiliacion= date_format(date_create($booksArray[$i]['fecha_afiliacion']),"Y-m-d");
     
     $bookidcatsingles= $booksArray[$i]['idcatsingles'];
     
     $bookidcatdobles= $booksArray[$i]['idcatdobles'];
     
     $bookIDrepresentante= $booksArray[$i]['id_representante'];
  
     $book = $xml->createElement('jugador');
    
     $book->setAttribute('idJugador', $bookIDjugador);
     
     $bkcedula     = $xml->createElement('cedula', $bookCedula); 
 
     $book->appendChild($bkcedula); 

     $bkNacionalidad   = $xml->createElement('nacionalidad', $bookNacionalidad); 

     $book->appendChild($bkNacionalidad); 

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
     
     $bkCorreo   = $xml->createElement('correo', $bookCorreo); 

     $book->appendChild($bkCorreo);
     
     $bkTelefono   = $xml->createElement('telefono', $bookTelefono); 

     $book->appendChild($bkTelefono);
     
     $bkCelular   = $xml->createElement('celular', $bookCelular); 

     $book->appendChild($bkCelular);
     
     $bkFecNac   = $xml->createElement('fecha_nacimiento', $bookFechaNac); 

     $book->appendChild($bkFecNac);
     
     $bkLugNac   = $xml->createElement('lugar_nacimiento', $bookLugarNac); 

     $book->appendChild($bkLugNac);
     
     $bkPasaporte   = $xml->createElement('pasaporte', $bookPasaporte); 

     $book->appendChild($bkPasaporte);
     
     $bkIDdireccion   = $xml->createElement('id_direccion', $bookIDdireccion); 

     $book->appendChild($bkIDdireccion);
     
     $bkLugarTrabajo   = $xml->createElement('lugar_trabajo', $bookLugarTrabajo); 

     $book->appendChild($bkLugarTrabajo);
     
     $bkTelTrabajo   = $xml->createElement('tel_trabajo', $bookTelTrabajo); 

     $book->appendChild($bkTelTrabajo);
     
     $bkCorreoTrabajo   = $xml->createElement('correo_trabajo', $bookCorreoTrabajo); 

     $book->appendChild($bkCorreoTrabajo);
     
     $bkAsociacion   = $xml->createElement('asociacion', $bookAsociacion); 

     $book->appendChild($bkAsociacion);
     
     $bkClub   = $xml->createElement('club', $bookClub); 

     $book->appendChild($bkClub);
     
     $bkFechaAfiliacion   = $xml->createElement('fecha_afiliacion', $bookFechaAfiliacion); 

     $book->appendChild($bkFechaAfiliacion);
     
     $bkIDcatsingles   = $xml->createElement('idcatsingles', $bookidcatsingles); 

     $book->appendChild($bkIDcatsingles);
     
     $bkIDcatdobles   = $xml->createElement('idcatdobles', $bookidcatdobles); 
 
     $book->appendChild($bkIDcatdobles);
     
     $bkIDrepresentante   = $xml->createElement('id_representante', $bookIDrepresentante); 

     $book->appendChild($bkIDrepresentante);
  
     $xml_afi->appendChild($book);
    

   }
   $xml_fvt->appendChild($xml_afi); 
   $xml->appendChild( $xml_fvt);
   
   $date_hoy=date_create(); // fecha del servidor 
    //echo date_format($date_hoy,"Y-m-d H:i:s");
   $datetime= date_timestamp_get($date_hoy);
   $datenow= date_format($date_hoy,"Y-M-d");
   
   $filePath = 'c:\xml\afiliaciones_'.$datenow.'_'.$datetime.'.xml';
   $xml->save($filePath); 
   

 } 
