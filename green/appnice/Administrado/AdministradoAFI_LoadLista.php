<?php
session_start();
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/AfiliacionesXML_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Paginacion_cls.php';

sleep(1);

$empresa_id=$_POST['id']; //Id empresa

$categoria_Filtro=$_POST['categoria']; //categoria

$disciplina_Filtro=$_POST['disciplina']; //modalidad filtro

//Paginacion
$pagina= intval(substr($_POST['pagina'],4));


$str_head= 
"<div class='row'>
<table class=' table table-responsive table-striped table-condensed'>
    <thead>
        <th>#</th>
        <th>A&ntildeo</th>
        <th>Cedula</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Fecha.Nac.</th>
        <th>Sexo</th>
        <th>Cat.</th>
        <th>Modal.</th>
        <th>Estado</th>
        <th>Afiliarme</th>
        <th>Formalizar</th>";
       
       
if ($_SESSION['niveluser']>9){
     $str_head .="
        <th>Federar</th>
        <th>Exonerar</th>";
}

$str_head .=" <th>Ficha</th>"
        . "</thead><tbody>";
    
    
//Buscamos la Empresa
$objEmpresa = new Empresa();
$objEmpresa->Find($empresa_id);

//Buscado la ultima afiliacion de la empresa
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Fetch($empresa_id);

$ano_afiliacion= $rsAfiliacion->getAno();
$fvtCicloCobro = $rsAfiliacion->getFVTCicloCobro();
$fvt_monto = $rsAfiliacion->getFVT();
$asociacionCicloCobro = $rsAfiliacion->getAsociacionCicloCobro();
$aso_monto = $rsAfiliacion->getAsociacion();
$sis_monto = $rsAfiliacion->getSistemaWeb();
$sistemaWebCicloCobro = $rsAfiliacion->getSistemaWebCicloCobro();

//Buscamos los atletas de la asociacion para administrar las afiliaciones directamente por la asociacion
//$rsAfiliados = Atleta::Disciplina($objEmpresa->getEstado(),$disciplina_Filtro);

//Paginacion no esta implementada
//Existe un problema en el filtro de la categoria natural ya que no esta en la tabla de atleta
//impidiendo filtrar los registro para la paginacion, ya que de hace el filtro durante el bucle
//del programa. 
//Verificar para insertar una columna de agregado o analizar bien este problema

switch ($categoria_Filtro) {
    case "PR":
        $yeardesde=  date("Y")-6;
        $yearhasta=  date("Y")-5;
        break;
    case "PN":
        $yeardesde=  date("Y")-8;
        $yearhasta=  date("Y")-7;
        break;
    case "PV":
        $yeardesde=  date("Y")-10;
        $yearhasta=  date("Y")-9;
        break;
    case "12":
        $yeardesde=  date("Y")-12;
        $yearhasta=  date("Y")-11;
        break;
    case "14":
        $yeardesde=  date("Y")-14;
        $yearhasta=  date("Y")-13;
        break;
    case "16":
        $yeardesde=  date("Y")-16;
        $yearhasta=  date("Y")-15;
        break;
    case "18":
        $yeardesde=  date("Y")-18;
        $yearhasta=  date("Y")-17;
        break;
    case "AD":
        $yeardesde=  date("Y")-99;
        $yearhasta=  date("Y")-19;
        break;
    default:
        $yeardesde=  date("Y")-99;
        $yearhasta=  date("Y")-0;
        break;
}
$querycount="SELECT count(*) as total FROM atleta "
        . " WHERE estado='".$objEmpresa->getEstado()."' "
        . " && disciplina='".$disciplina_Filtro."' "
        . " && niveluser=0 && year(fecha_nacimiento)>=$yeardesde && year(fecha_nacimiento)<=$yearhasta ";
$select="SELECT * FROM atleta "
        . " WHERE estado='".$objEmpresa->getEstado()."' "
        . " && disciplina='".$disciplina_Filtro."' "
        . " && niveluser=0 && year(fecha_nacimiento)>=$yeardesde && year(fecha_nacimiento)<=$yearhasta "
        . " ORDER BY Apellidos";
$objPaginacion = new Paginacion(8,$pagina);
$objPaginacion->setTotal_Registros($querycount);
$rrsAfiliados=$objPaginacion->SelectRecords($select);

$ixx=0; $nroPagos= 0;

$lineat='';
//Iniciamos el contador de lineas segun el inicio de paginacion
$contador=$objPaginacion->getInicio();
foreach ($rrsAfiliados as $datatmp)
{
    
    $atleta_id=$datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    //if ($categoria_Filtro=='TD' || $objAtleta->Categoria_Natural($ano_afiliacion)==$categoria_Filtro){
    {  
    {
            $ixx ++;
            $rowid=$atleta_id;
            $contador ++;    
            $linea = "<div class='data'>";
            $linea .="<tr id='data$rowid'>";
            $linea .= "<td>".($contador)."</td>";
            $linea .= "<td >".$ano_afiliacion."</td>";
            $linea .= "<td>".$objAtleta->getCedula()."</td>";
            $linea .= "<td>".$objAtleta->getNombres()."</td>";
            $linea .= "<td>".$objAtleta->getApellidos()."</td>";
            $linea .= "<td>".$objAtleta->FechaNacimientoDDMMYYYY()."</td>";
            
            if ($objAtleta->getSexo()=="F" || $objAtleta->getSexo()=="M"){
                $linea .= "<td>".$objAtleta->getSexo()."</td>";
            }else{
                 $linea .= "<td class='alert alert-danger'>error</td>";
            }
            $linea .= "<td>".$objAtleta->Categoria_Afiliacion($ano_afiliacion)."</td>";
            $linea .= "<td>".$disciplina_Filtro."</td>";
            
            $linea .= "<td>".$objAtleta->getEstado()."</td>";
            $objAfiliacion_atleta = new Afiliaciones();
            $objAfiliacion_atleta->Find_Afiliacion_Atleta($objAtleta->getID(),$ano_afiliacion);
            if ($objAfiliacion_atleta->getAfiliarme() > 0) {
                $linea .= "<td> <input  type='checkbox' name='chkafiliarme' data-id='op0$rowid' id='op0$rowid' class='edit-record' checked='checked'></td>";
            } else {
                $linea .= "<td> <input  type='checkbox' name='chkafiliarme' data-id='op0$rowid' id='op0$rowid' class='edit-record' ></td>";
            }
            if ($objAfiliacion_atleta->getFormalizacion() > 0) {
                $linea .= "<td> <input  type='checkbox' name='chkformalizado' data-id='op1$rowid' id='op1$rowid' class='edit-record' checked='checked'></td>";
            } else {
                $linea .= "<td> <input  type='checkbox' name='chkformalizado' data-id='op1$rowid' id='op1$rowid' class='edit-record' ></td>";
            }
            if ($_SESSION['niveluser']>9){
                if ($objAfiliacion_atleta->getPagado() > 0) {
                    $linea .= "<td> <input   type='checkbox' name='chkfederado' data-id='op2$rowid' id='op2$rowid' class='edit-record' checked='checked'></td>";
                } else {
                    $linea .= "<td> <input  type='checkbox' name='chkfederado' data-id='op2$rowid' id='op2$rowid' class='edit-record' ></td>";
                }

                if ($objAfiliacion_atleta->getExonerado() > 0) {
                    $linea .= "<td> <input   type='checkbox' name='chkexonerado' data-id='op3$rowid' id='op3$rowid' class='edit-record' checked='checked'></td>";
                } else {
                    $linea .= "<td> <input  type='checkbox' name='chkexonerado' data-id='op3$rowid' id='op3$rowid' class='edit-record' ></td>";
                }
            }
          
            $linea .= "<td > <a class='edit-href glyphicon glyphicon-pencil' target='blank_' href='../Ficha/FichaDatosBasicos.php?id=$rowid' data-id='h$rowid'></a></td>";
            $linea .= "</tr>";
            $lineat .= $linea;


        }
    }
}

$lineat .= "<tr>";
$lineat .= "<td>$ixx</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";


//echo "<td>".formatear_monto($totalFvt)."</td>";
//echo "<td>".formatear_monto($totalAso)."</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
if ($_SESSION['niveluser']>9){
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
}
$lineat .= "</tr>";
$lineat .= "</tbody>";
$lineat .= "</div>";
$lineat .= "</table>";
$lineat .= "</div>";

$lineaOut=$str_head.$lineat;
$nr=$ixx;
//if ($ixx>0){
//    $jsondata = array("Success" => True, "html"=>$str_head.$lineat);
//    
//} else {
//    
//    $jsondata = array("Success" => False,  "html"=>"");
//}
if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos Registrados","pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;



