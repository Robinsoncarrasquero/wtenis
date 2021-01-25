<?php
session_start();
require_once '../clases/Rank_cls.php';
require_once '../sql/ConexionPDO.php';
sleep(1);

$disciplina_Filtro=$_POST['disciplina']; 
$fecha_rk_filtro= $_POST['fecha_rk']; 
$categoria_Filtro=$_POST['categoria'];
$sexo_Filtro=$_POST['sexo'];
$str_head= 
"<table class=' table table-responsive table-striped table-bordered table-condensed'>
    <thead>
        <th>#</th>
       
        <th>Fecha</th>
        <th>Disciplina</th>
        <th>Categoria</th>
        <th>Sexo</th>
        <th>Fecha Mod.</th>
        <th>Modo</th>
        
    </thead>
    <tbody>";

$rsFileRank= Rank::FileRanking($disciplina_Filtro,$categoria_Filtro,$fecha_rk_filtro,$sexo_Filtro);
$ixx=0;
$lineat='';
foreach ($rsFileRank as $datatmp)
{
    $ixx ++;
    $rowid=$datatmp['id'];
    $linea = "<div class='data'>";
    $linea .="<tr id='data$rowid'>";
    $linea .= "<td>".$ixx."</td>";
    $linea .= "<td>".$datatmp['fecha']."</td>";
    $linea .= "<td>".$datatmp['disciplina']."</td>";
    $linea .= "<td>".$datatmp['categoria']."</td>";
    $linea .= "<td>".$datatmp['sexo']."</td>";
    $linea .= "<td>".$datatmp['fecha_modificacion']."</td>";
    //$linea .= "<td>".$datatmp['migraccion']."</td>";
    if ($datatmp['procesado']) {
        $linea .= "<td><a class='delete-record glyphicon glyphicon-trash' href='#' data-id='del$rowid'></a>ok</td>";
 
    } else {
        $linea .= "<td><a class='delete-record glyphicon glyphicon-trash' href='#' data-id='del$rowid'></a></td>";
 
    }
    $linea .="</tr>";
    $linea .="</div>";
    $lineat .=$linea;
   
}


$lineat .= "</tbody>";

$lineat .= "</table>";

if ($ixx>0){
    $jsondata = array("Success" => True, "html"=>$str_head.$lineat);   
} else {    
    $jsondata = array("Success" => False,  "html"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);



