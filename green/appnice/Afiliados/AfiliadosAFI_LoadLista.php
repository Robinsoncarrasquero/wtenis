<?php
session_start();
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';

require_once '../clases/AfiliacionesXML_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Disciplina_cls.php';
require_once '../clases/Paginacion_cls.php';

sleep(1);


$afiliacion_id=$_POST['id']; //Id de afiliacion del ano
$categoria_Filtro=$_POST['categoria']; //categoria
$disciplina_Filtro=$_POST['disciplina']; //modalidad filtro

//Paginacion
$pagina= intval(substr($_POST['pagina'],4));


$str= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>A&ntildeo</th>

                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha.Nac.</th>
                <!-- <th>Asociaciones</th>
                <th>Asociacion</th>
                <th>Web</th> -->
                <th>Estado</th>
                <th>Sexo</th>
                <th>Cat.</th>
                <th>Disciplina.</th>
                <th>Verificado</th>
                <th>Ficha</th>
                </thead>";
                    
                
 
            
//echo $str;
            
//Buscado la data de la afiliacion
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Find($afiliacion_id);

$ano_afiliacion= $rsAfiliacion->getAno();
$fvtCicloCobro = $rsAfiliacion->getFVTCicloCobro();
$fvt_monto = $rsAfiliacion->getFVT();
$asociacionCicloCobro = $rsAfiliacion->getAsociacionCicloCobro();
$aso_monto = $rsAfiliacion->getAsociacion();
$sis_monto = $rsAfiliacion->getSistemaWeb();
$sistemaWebCicloCobro = $rsAfiliacion->getSistemaWebCicloCobro();


//Manejos coleccion de afiliaciones
//$objAfiliaciones = new Afiliaciones();
//if ($_SESSION['niveluser']>9){
//    $rsAfiliados=  Afiliaciones::All_Afiliaciones_Ano($ano_afiliacion);
//}else{
//    $rsAfiliados=  Afiliaciones::All_Afiliaciones_ID($afiliacion_id);
//}
$WHEREcategoria=" ";
if ($categoria_Filtro!="TD") {
    $WHEREcategoria=" && categoria='$categoria_Filtro' ";
}    
if ($_SESSION['niveluser']>9){
    $querycount="SELECT count(*) as total FROM afiliaciones "
        . " WHERE ano=".$ano_afiliacion." "
        . " && pagado>0 "
        . $WHEREcategoria;
        
    $select="SELECT * FROM afiliaciones "
        . " WHERE ano=".$ano_afiliacion." "
        . " && pagado>0 "
        . $WHEREcategoria;
        
} else {
    $querycount="SELECT count(*) as total FROM afiliaciones "
        . " WHERE afiliacion_id=".$afiliacion_id." "
        . " && pagado>0 "
        . $WHEREcategoria;
        
    $select="SELECT * FROM afiliaciones "
        . " WHERE afiliacion_id=".$afiliacion_id." "
        . " && pagado>0 "
        . $WHEREcategoria;
        
}
//$pagina=0;
$objPaginacion = new Paginacion(20,$pagina);
$objPaginacion->setTotal_Registros($querycount);
$rrsAfiliados=$objPaginacion->SelectRecords($select);

$ixx=$objPaginacion->getInicio();
$nroPagos= 0;
$totalAso=0;$totalFvt=0;$totalWeb=0;
$lineat='';
foreach ($rrsAfiliados as $datatmp)
{
     $atleta_id=$datatmp['atleta_id'];
     $objAtleta = new Atleta();
     $objAtleta->Fetch($atleta_id);
     $sexo = $objAtleta->getSexo();
   
//    {if (($datatmp['categoria']==$categoria_Filtro || $categoria_Filtro=="TD") 
//            && $disciplina_Filtro==$objAtleta->getDisciplina()){
     {
        {
            $ixx ++;
            $rowid=$atleta_id;
            //echo "<tr id='data$rowid' style=' background-color:#fff000'>";  
            $xfvt_monto = $datatmp['fvt'];
            $xaso_monto = $datatmp['asociacion'];
            $xsis_monto = $datatmp['sistemaweb'];


            //IMPORTANTE !! 
            //Inicializamos para no acumular las afiliaciones de federacion y asociacion
            //Ya que son anuales y se pagan una sola vez
            $nroPagos ++;
            $totalFvt = $totalFvt + $xfvt_monto;
            $totalAso = $totalAso + $xaso_monto;
            $totalWeb = $totalWeb + $xsis_monto;

            $linea = "<div class='data'>";
            $linea .="<tr id='data$rowid'>";
            $linea .= "<td>".$ixx."</td>";
            $linea .= "<td>".$ano_afiliacion."</td>";
            $linea .= "<td>".$objAtleta->getCedula()."</td>";
            $linea .= "<td>".$objAtleta->getNombres()."</td>";
            $linea .= "<td>".$objAtleta->getApellidos()."</td>";
            $linea .= "<td>".$objAtleta->FechaNacimientoDDMMYYYY()."</td>";
   
            $linea .= "<td>".$objAtleta->getEstado()."</td>";
            if ($objAtleta->getSexo()=="F" || $objAtleta->getSexo()=="M"){
                $linea .= "<td>".$objAtleta->getSexo()."</td>";
            }else{
                 $linea .= "<td class='alert alert-danger'>error</td>";
            }
            $linea .= "<td>".$datatmp['categoria']."</td>";
            $linea .= "<td>".$datatmp['modalidad']."</td>";

            $objAfiliacionXML = new AfiliacionesXML();
            $objAfiliacionXML->Fetch($objAtleta->getID());
            if ($objAfiliacionXML->getVerificado() > 0) {
                $linea .= "<td> <input   type='checkbox' name='chkVerificado' data-id='opv$rowid' id='$rowid' class='edit-record' disabled checked='checked'></td>";
            } else {
                $linea .= "<td> <input  type='checkbox' name='chkVerificado' data-id='opv$rowid' id='$rowid' disabled class='edit-record' ></td>";
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


//echo "<td>".formatear_monto($totalFvt)."</td>";
//echo "<td>".formatear_monto($totalAso)."</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";
$lineat .= "<td>=======</td>";

$lineat .= "</tr>";
$lineat .= "</tbody>";
$lineat .= "</div>";
$lineat .= "</table></div>";


if ($ixx>0){
    $jsondata = array("Success" => True, "html"=>$str.$lineat,"pagination"=>$objPaginacion->Paginacion());
    
} else {
    $jsondata = array("Success" => False,  "html"=>'No hay datos registrados',"pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;



