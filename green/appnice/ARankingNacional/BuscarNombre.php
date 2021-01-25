<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Paginacion_cls.php';

$search= htmlspecialchars($_POST['search']);
//El boton de paginacion viene en cero al inicio
$pagina= intval(substr($_POST['pagina'],4));
//Paginacion 
$objPaginacion = new Paginacion(5,$pagina);
$countRecord="SELECT COUNT(*) as total FROM atleta"
               . " WHERE (cedula LIKE '%$search%' ||  apellidos LIKE '%$search%')";
$objPaginacion->setTotal_Registros($countRecord);
$selectRecord="SELECT atleta_id,sexo,nombres,apellidos FROM atleta"
               . " WHERE (cedula LIKE '%$search%' ||  apellidos LIKE '%$search%')";
$records=$objPaginacion->SelectRecords($selectRecord);

$strTableHead =
'
                    <div  class="table">      
                        <table class="table table-responsive  table-condensed">
                            
                            <tbody>';
                            $linea ="";
                            $nr=0;
                            $np=0;
//                            while ($row = mysql_fetch_array($result)) {
                            $jdata=array();
                            $html='';    
                            foreach ($records as $row) {
                                $nr ++;
                                $linea .= '<tr>';  

                                $hash= $row['atleta_id'];
                                $linea .= '<td >'. $row['atleta_id'].'</td>';
                                $linea .= '<td >'. $row['nombres']." ".$row['apellidos'].'</td>';

                                $linea .= '</tr>';
                                $dato = array("value"=>$row['atleta_id'],"texto"=>$row['nombres']." ".$row['apellidos']);
                                array_push($jdata,$dato);
                                $html .= '<div><a class="suggest-element" sexo="'.$row['sexo'].'" data="'. ($row['apellidos']." ".$row['nombres']).'" id="'.($row['atleta_id']).'">'. ($row['apellidos'])." ".utf8_encode($row['nombres']).'</a></div>';

                                             
                            }
                           
$strTableFooter=
                    '</tbody>    
            </table>';

$lineaOut .= $strTableHead.$linea.$strTableFooter;


if ($nr>0){
    $jsondata = array("Success" => True, "tabla"=>$jdata,"html"=>$lineaOut,"html2"=>$html,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "tabla"=>$jdata,"html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
