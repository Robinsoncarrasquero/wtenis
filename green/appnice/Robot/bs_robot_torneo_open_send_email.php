<?php
session_start();
date_default_timezone_set('America/Caracas');
require_once "../clases/Empresa_cls.php";
require_once "../clases/Atleta_cls.php";
require_once "../clases/Empresa_cls.php";
require_once "../clases/Afiliacion_cls.php";
require_once "../clases/Afiliaciones_cls.php";
require_once "..clases/Torneos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';


$head ='<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Mis Torneos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    

    <style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
p{
font-size:medium;color:blue;
}
span{
  
  color: black;
}
</style>

   

  	
</head>
<body>';

$strHead =
'
                    
                        <table class=3D"content" text-align cellspacing=3D"100" cellpadding=3D"0"
 border=3D"0" style=3D"padding-right:20px" tr:nth-child(even) {background-color: #f2f2f2} th {
    background-color:  #4CAF50;color: white;}>
    <thead >
        <tr ">
            <!--<th><p class="glyphicon glyphicon-dashboard"<p></th>-->
            <th>Estatus</th>
            <!--<th>Modal.</th>-->
            <th>Grado</th>
            <th>Categoria</th>
            <th>Inicio</th>

            <th>Cierre</th>
            <th>Retiros</th>
            <th>Torneo</th>
            <th>Entidad</th>

           <!-- <th>Apuntar</th>
           <th>Fsheet</th>

            <th>Pre Inscritos</th>
            <th>Confirmados</th>
            <th>Draw Singles</th>
            <th>Draw Dobles</th>-->

        </tr>
    </thead>
    <tbody>';
//Busca la afiliacion activa de la tabla de afiliacion
$objAfiliacion = new Afiliacion();

//Busca una coleccion de empresas
$objEmpresa= new Empresa();
$rsEmpresas=$objEmpresa->ReadAll();
foreach ($rsEmpresas as $rsEmpresa) 
    {
    $b=0;
    $strRow='';
    $mes=date('m');
    
    $empresa_id=$rsEmpresa['empresa_id'];
    $estado=$rsEmpresa['estado'];
    
  
    // Buscamos los torneos vigentes
    $objTorneo = new Torneo();
    $rsColeccion_Torneos=$objTorneo->ReadAll($empresa_id,TRUE,$mes);
      
    foreach ($rsColeccion_Torneos as $row) {
        if ($row['torneo_id']==235) {
         
        //if (Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) == Fecha_Hoy() && Fecha_Create($row['fechacierre']) > Fecha_Hoy()) {
            $estatus="Open";
            switch ($row['condicion']) {
                    case "X":
                       $estatus='Cancelado';
                       break;
                    case "S":
                        $estatus='Suspendido';
                        break;
                    case "D":
                        $estatus='Diferido';
                        break;
                    default:

                        break;
                }

                switch ($estatus) {
                    case 'Open':
                        $strRow= '<tr class="success"  >  ';
                        //$strRow .='<td><a target="" href="http://atem.tenis.net.ve/app/bsinscripcion.php" class="glyphicon glyphicon-hourglass"></a></td>';
                        $strRow .='<td><a  target="" href="http://atem.tenis.net.ve/app/bsinscripcion.php" </a>'.$estatus.'</td>';
                        break;

                    case 'Closed':
                        $strRow = '<tr class=" " >';
                        //$strRow .= '<td><p class="glyphicon glyphicon-remove-sign "></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                    case 'Next':
                        $strRow = '<tr class=" " >';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-eye-open"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                     case 'Running':
                        $strRow = '<tr class="warning " >';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                       // $strRow .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                     case 'Suspendido':
                        $strRow = '<tr class="danger " >';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                     case 'Diferido':
                        $strRow = '<tr class="info " >';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                     case 'Cancelado':
                        $strRow = '<tr class="danger " >';
                        //$strRow .= '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        $strRow .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;

                    default:
                        $strRow = '<tr class=" " >';
                        //$strRow .= '<td ><p class=" glyphicon glyphicon-remove"></p></td>';
                        //$strRow .= '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                        $strRow .= '<td>'.$estatus.'</td>';
                        break;
                }
                $categoria_torneo=$row['categoria'];
                $torneo=$row['nombre'];
                //$strRow .= '<td >'. $row['modalidad'].'</td>';
                $strRow .= '<td >'. $row['tipo'].'</td>';
                $strRow .= '<td>'. $row['categoria'].'</td>';
                $strRow .= '<td> '.$row['fecha_inicio_torneo'].'</td>';
                $strRow .= '<td>'.$row['fechacierre'].'</td>';
                $strRow .= '<td>'.$row['fecharetiros'].'</td>';

                $strRow .= '<td>'. $row['nombre'].'</td>';
                $strRow .= '<td>'. $estado.'</td>';
                $strRow .= '</tr>';

                $strFoot=
                    '</tbody>    
                    </table>';
                $envia_correo=0;
                $b=0;

                //Busca la afiliacion activa de la tabla de afiliacion
                $objAfiliacion = new Afiliacion();
                //Busca la afiliacion activa de la coleccion
                $objAfiliacion->Fetch($empresa_id);
                
                //Coleccion de atletas de un estado o Asociacion
                $rsAtletas = Atleta::ReadAll($estado);
                foreach ($rsAtletas as $record) {
                   
                    $afiliacion_id=$objAfiliacion->get_ID();
                    $atleta_id=$record['atleta_id'];
                    
                    //Busca la afiliacion del afiliado para revisar si esta confiirmada 
                    $objAfiliado= new Afiliaciones();
                    $objAfiliado->Fetch($afiliacion_id, $atleta_id); 
                    
                    
                    //Tabla de atletas
                    $objAtleta= new Atleta();
                    $objAtleta->Fetch($atleta_id);
                    
                    $array_mi_Categoria=explode(",",$objAtleta->Categoria_Torneo()); //Devuelve varias categorias que puede jugar
                    $array_Categoria= explode(',',$categoria_torneo); //Array de categorias del torneo
                    $envia_correo=0;

                    for ($x = 0; $x < count($array_Categoria); $x++) { // vamos a imprimir las categorias en el elemento select
                        $buscar = $array_Categoria[$x];
                        if (in_array($buscar, $array_mi_Categoria, true)) {

                            $envia_correo = 1;
                        }
                    }
                    if ($envia_correo>0 && $objAfiliado->getPagado()>0){

                        $b = $b + 1;        # Add assignment operator

                        $mensaje="<p ><b>Estimado(a) <span>". $objAtleta->getNombreCompleto()."</span>, le informamos que ya estan abiertas la inscripciones del siguiente torneo<b>:</p>";
                        $mensaje .= $head .$strHead .$strRow . $strFoot;

                        $asunto="Apertura de Torneo: ".$row['nombre'];
                        $para=$objAtleta->getEmail();
                        $para="robinson.carrasquero@gmail.com";

                        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $cabeceras .= 'From: info@tenis.net.ve';
                        if (MODO_DE_PRUEBA==0){
                           $enviado = mail($para, $asunto, $mensaje, $cabeceras);
                        }else{
                            echo $mensaje;
                        }
                    }
                }


        }

    }
}
                           

                    

 
//if ($enviado)
//  echo 'Email enviado correctamente';
//else
//  echo 'Error en el envío del email';
//
//echo 'CORREO ENVIADOS :'.$b;