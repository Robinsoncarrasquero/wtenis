<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Nacionalidad_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/AfiliacionesXML_cls.php';

/* 
 * Programa para crear el archivo xml que generara los datos de los afiliados formalizados
 */
sleep(1);

$chkExportarXML = $_POST['chkExportar'];
//$jsondata = array("Sucess" => False, "FileName" => $chkExportarXML);
//header('Content-type: application/json; charset=utf-8');
//echo json_encode($jsondata, JSON_FORCE_OBJECT);


$rsAfiliadosVerificados = AfiliacionesXML::RegistrosVerificados();
$booksArray = array();
foreach ($rsAfiliadosVerificados as $datatmp) {
    $atleta_id = $datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    $sexo = $objAtleta->getSexo();
    $ixx ++;
    $rowid = $datatmp['id'];
    $objNacionalidad= new Nacionalidad();
    $objNacionalidad->Fetch($objAtleta->getNacionalidadID());
    
    $objEmpresa= new Empresa();
    $objEmpresa->Fetch($objAtleta->getEstado());
    if ($objEmpresa->Operacion_Exitosa()){
        $id_asociacion=$objEmpresa->getid_asociacion();
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
        'celular' => $objAtleta->getCelular(),
        'fecha_nacimiento' => $objAtleta->getFechaNacimiento(),
        'lugar_nacimiento' => $objAtleta->getLugarNacimiento(),
        'pasaporte' => '',
        'id_direccion' => '',
        'direccion' => $objAtleta->getDireccion(),
        'lugar_trabajo' => $objAtleta->getLugarTrabajo(),
        'tel_trabajo' => $objAtleta->getTelefonos(),
        'correo_trabajo' => '',
        'asociacion' => $id_asociacion,
        'estado' => $objAtleta->getEstado(),
        'club' => '',
        'fecha_afiliacion' => $objAfiliacion_afiliado->getFecha_Pago(),
        'idcatsingles' => -1,
        'idcatdobles' => -1,
        'id_representante' => 0
    );
    array_push($booksArray, $dato);
}

$str= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>Nac.</th>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Apellido</th>
                <th>Fecha.Nac.</th>
                <th>Sexo</th>
                <th>Telefono</th>
                <th>Correo.</th>
                <th>Asoc.</th>
                <th>Exportado</th>
                </thead><tbody>";;

if (count($booksArray)) {
    
    $date_hoy=date_create(); // fecha del servidor 
    //echo date_format($date_hoy,"Y-m-d H:i:s");
    $datetime= date_timestamp_get($date_hoy);
    $datenow= date_format($date_hoy,"Y-M-d");
    $lote_name=$datenow."_".$datetime;
    //Creamos el archivo xml
    //$XML = createXMLfile($booksArray,$lote_name);
    //Recorremos el array de registros para actualizar
    //el campo indicador de dato Exportado al archivo xml 
    //Para el sistema de afiliaciones interno.
    $ixx=0;
    for ($i = 0; $i < count($booksArray); $i++) {
        $atleta_id = $booksArray[$i]['atleta_id'];
        //Si es exportacion definitiva actualizamos el campo de exportacion
        if ($chkExportarXML>0) {
           
            $objXML = new AfiliacionesXML();
            $objXML->Fetch($atleta_id);
            if ($objXML->Operacion_Exitosa()) {
                $objXML->setExportado($chkExportarXML);
                $objXML->Update();
            }  else {
                $objXML->setExportado($chkExportarXML);
                $objXML->setExportado($chkExportarXML);
                $objXML->create();
                
            }
            
            
        }
        $rowid=$atleta_id;
        $ixx ++;
        $linea = "<div class='data'>";
        $linea .= "<tr id='data$rowid' >";
        $linea .= "<td>".$ixx."</td>";
        $linea .= "<td>".$booksArray[$i]['nacionalidad']."</td>";
        $linea .= "<td>".$booksArray[$i]['cedula']."</td>";
        $linea .= "<td>".$booksArray[$i]['nombre']."</td>";
        $linea .= "<td>".$booksArray[$i]['snombre']."</td>";
        $linea .= "<td>".$booksArray[$i]['apellido']."</td>";
        $linea .= "<td>".$booksArray[$i]['sapellido']."</td>";
        $linea .= "<td>".date_format(date_create($booksArray[$i]['fecha_nacimiento']),"Y-m-d")."</td>";
        $linea .= "<td>".$booksArray[$i]['sexo']."</td>";
        $linea .= "<td>".$booksArray[$i]['telefono']."</td>";
        $linea .= "<td>".$booksArray[$i]['correo']."</td>";
        $linea .= "<td>".$booksArray[$i]['estado']."</td>";
        if ($chkExportarXML) {
            $linea .= "<td> <input  type='checkbox' name='chkExportado' data-id='Exp$rowid' id='chkExp$rowid' class='edit-record'  checked='checked' disabled></td>";
        } else {
            $linea .= "<td> <input  type='checkbox' name='chkExportado' data-id='Exp$rowid' id='chkExp$rowid' class='edit-record' disabled ></td>";
        }
        $linea .= "</tr></div>";
        $lineat .= $linea;
        
    }
    $lineat .= "</tbody>";
    $lineat .= "</div>";
    $lineat .= "</table></div>";
   
    $jsondata = array("Sucess" => True,"html"=>$str.$lineat.$table);
    
} else {
    $jsondata = array("Sucess" => False, "html" => '<b>No hay Datos</b>');
}
    
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);