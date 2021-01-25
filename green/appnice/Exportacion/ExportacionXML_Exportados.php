<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/AfiliacionesXML_cls.php';
//Este programa presenta los registros exportados a un arhivo xml basados por lote
//para que el usuario pueda desprocesar el registro exportado.
sleep(1);

$lote=$_POST['id'];



$str= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha.Nac.</th>
                <th>Asoc.</th>
                <th>Sexo</th>
                <th>Exportado</th>
               
                </thead>";
                    
   
//Buscamos las Afiliaciones Formalizadas ante la asociacion

$rsAfiliados=  AfiliacionesXML::LoteRegistrosExportados($lote);

$ixx=0; $nroPagos= 0;
$totalAso=0;$totalFvt=0;$totalWeb=0;
$lineat='';
foreach ($rsAfiliados as $datatmp)
{
    $atleta_id=$datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    $sexo = $objAtleta->getSexo();
    
   
    //Es un nuevo afiliado con la categoria 2 desde el modulo de Preafiliacion
    {
        $ixx ++;
        $rowid=$atleta_id;
        //echo "<tbody>";
        $linea = "<div class='data'>";
        
       
        $linea .= "<tr id='data$rowid' >";
        $linea .= "<td>".$ixx."</td>";
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
        
        $linea .= "<td> <input  type='checkbox' name='chkExportado' data-id='ope$rowid' id='$rowid' class='edit-record'  checked='checked'></td>";
        $linea .= "</tr>";
        $lineat .= $linea;


    }
}
$lineat .= "</tbody>";
$lineat .= "</div>";
$lineat .= "</table></div>";


if ($ixx>0){
    $jsondata = array("Sucess" => True, "html"=>$str.$lineat);
    
} else {
    $jsondata = array("Sucess" => False,  "html"=>'');
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);




