<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/AfiliacionesXML_cls.php';
sleep(1);

$afiliacion_id=$_POST['id'];

$chkFiltro=$_POST['chkFiltro']; //Confirmacion de pagos o Por pagar

$str= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>A&ntildeo</th>

                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha.Nac.</th>
                <!-- <th>Federacion</th>
                <th>Asociacion</th>
                <th>Web</th> -->
                <th>Estado</th>
                <th>Sexo</th>
                <th>Cat.</th>
                <th>Modal.</th>
                <th>Verificado</th>
                <th>Editar</th>
                </thead>";
                    
                
 
            
//echo $str;
            
//Buscado la data de la afiliacion
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Find($afiliacion_id);


$afiliacion_id = $rsAfiliacion->get_ID();
$ano_afiliacion= $rsAfiliacion->getAno();
$fvtCicloCobro = $rsAfiliacion->getFVTCicloCobro();
$fvt_monto = $rsAfiliacion->getFVT();
$asociacionCicloCobro = $rsAfiliacion->getAsociacionCicloCobro();
$aso_monto = $rsAfiliacion->getAsociacion();
$sis_monto = $rsAfiliacion->getSistemaWeb();
$sistemaWebCicloCobro = $rsAfiliacion->getSistemaWebCicloCobro();


//Manejos coleccion de afiliaciones
$objAfiliaciones = new Afiliaciones();


//Buscamos las Afiliaciones Formalizadas ante la asociacion

$rsAfiliados=$objAfiliaciones->rsAfiliacionesWebFormalizadas($afiliacion_id);

$ixx=0; $nroPagos= 0;
$totalAso=0;$totalFvt=0;$totalWeb=0;
$lineat='';
foreach ($rsAfiliados as $datatmp)
{
    $atleta_id=$datatmp['atleta_id'];
    $objAtleta = new Atleta();
    $objAtleta->Fetch($atleta_id);
    $sexo = $objAtleta->getSexo();
    
    //Buscamos en el historico a ver si ya fue procesado
    
    $objXML = new AfiliacionesXML();
    $objXML->Fetch($atleta_id);
    if ($objXML->Operacion_Exitosa() && $objXML->getExportado() == 1) {
        $procesar = false;
    } else {
        $procesar = true;
    }
  

    //Es un nuevo afiliado con la categoria 2 desde el modulo de Preafiliacion
    if ($procesar){
        $ixx ++;
        $rowid=$atleta_id;
        //echo "<tbody>";
        
       
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
      
        if ($objXML->getVerificado() > 0) {
            $linea .= "<td> <input   type='checkbox' name='chkVerificado' data-id='opv$rowid' id='$rowid' class='edit-record'  checked='checked'></td>";
        } else {
            $linea .= "<td> <input  type='checkbox' name='chkVerificado' data-id='opv$rowid' id='$rowid' class='edit-record' ></td>";
        }
        $linea .= "<td > <a class='edit-href glyphicon glyphicon-pencil' target='blank_' href='../Ficha/FichaDatosBasicos.php?id=$rowid' data-id='h$rowid'></a></td>";
        $linea .= "</tr>";
        $lineat .= $linea;


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
    $jsondata = array("Sucess" => True, "html"=>$str.$lineat);
    
} else {
    $jsondata = array("Sucess" => False,  "html"=>'');
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);




