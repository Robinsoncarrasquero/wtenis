<?php
session_start();
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';

require_once '../clases/AfiliacionesXML_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Disciplina_cls.php';

sleep(1);


$afiliacion_id=$_POST['id']; //Id de afiliacion
$categoria_Filtro=$_POST['categoria']; //categoria
$disciplina_Filtro=$_POST['disciplina']; //modalidad filtro
$apellidos_Filtro=  htmlspecialchars($_POST['apellidos']); //modalidad filtro


$str= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>A&ntildeo</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha.Nac.</th>
                <th>Estado</th>
                <th>Sexo</th>
                <th>Cat.</th>
                <th>Disciplina.</th>
                <th>Ficha</th>
                </thead>";
                    
                
 
            
//echo $str;
            
//Buscado la data de la afiliacion
$rsAfiliacion = new Afiliacion();
$rsAfiliacion->Find($afiliacion_id);

$ano_afiliacion= $rsAfiliacion->getAno();


if ($_SESSION['niveluser']>9){
    $rsAfiliados= Atleta::LikeApellido($apellidos_Filtro);
   
}else{
    
    $estado=$_SESSION['estado'];//Estado de la asociacion activa
    $rsAfiliados= Atleta::LikeApellido($apellidos_Filtro,$estado);
    
}

$ixx=0; $nroPagos= 0;
$totalAso=0;$totalFvt=0;$totalWeb=0;
$lineat='';
foreach ($rsAfiliados as $datatmp)
{
     $atleta_id=$datatmp['atleta_id'];
     $objAtleta = new Atleta();
     $objAtleta->Fetch($atleta_id);
     $sexo = $objAtleta->getSexo();
     $objAfiliacion = new Afiliaciones();
     $objAfiliacion->Find_Afiliacion_Atleta($objAtleta->getID(),$ano_afiliacion);
    if ($objAfiliacion->getPagado()>0){
       
        {
            $ixx ++;
            $rowid=$atleta_id;
                
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
            $linea .= "<td>".$objAfiliacion->getCategoria()."</td>";
            $linea .= "<td>".$objAfiliacion->getModalidad()."</td>";
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


$lineat .= "</tr>";
$lineat .= "</tbody>";
$lineat .= "</div>";
$lineat .= "</table></div>";


if ($ixx>0){
    $jsondata = array("Success" => True, "html"=>$str.$lineat);
    
} else {
    $jsondata = array("Success" => False,  "html"=>'No hay datos');
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;



