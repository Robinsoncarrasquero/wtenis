<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Paginacion_cls.php';

$afiliacion_id=$_POST['id'];

$chkFiltro=$_POST['chkFiltro']; //Confirmacion de pagos o Por pagar
//Paginacion
$pagina= intval(substr($_POST['pagina'],4));


$str_head=
"<table class='table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>Afiliacion</th>

                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>

                <th>Fecha.Nac.</th>
                <th>Asociaciones</th>
                <th>Asociacion</th>
                <!-- <th>Web</th> -->
               
                <th>Estado</th>
                <th>Sexo</th>
                <th>Cat.</th>
                <th>Modal.</th>
                <th>Federar</th>
                <th>Ficha</th>
                </thead>";
                    
                
 
            
//echo $strHead;
            
            //Buscado la data de la afiliacion
            $rsAfiliacion = new Afiliacion();
            $rsAfiliacion->Find($afiliacion_id);
           
            {
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
                
                switch ($chkFiltro) {
                    case 1://Afiliaciones Formalizadas
                        $rsAfiliados=$objAfiliaciones->rsAfiliacionesWebFormalizadas($afiliacion_id);
                        $querycount ='SELECT count(*) as total FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0 && pagado>0 ORDER BY fecha_pago desc';
                        $qselect ='SELECT * FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0 && pagado>0 ORDER BY fecha_pago desc';

                        break;
                    case 0: //Afiliaciones no formalizadas
                        $rsAfiliados=$objAfiliaciones->rsAfiliacionesWebNoFormalizadas($afiliacion_id);
                        $querycount ='SELECT count(*) as total FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0 && pagado!=1 ORDER BY fecha_pago desc';
                        $qselect ='SELECT * FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0 && pagado!=1 ORDER BY fecha_pago desc';
    
                        break;
                    
                    default:
                       
                        break;
                }
                //Instanciacion de Paginacion                
                $objPaginacion = new Paginacion(9,$pagina);
                $objPaginacion->setTotal_Registros($querycount);
                $rrsAfiliados=$objPaginacion->SelectRecords($qselect);
                //Iniciamos el contador de lineas segun el inicio de paginacion
                $contador=$objPaginacion->getInicio();


                $nr= 0;
                $acum_linea_out='';
                $totalAso=0;$totalFvt=0;$totalWeb=0;
                foreach ($rrsAfiliados as $datatmp)
                {
                    $atleta_id=$datatmp['atleta_id'];
                    $contador ++;    
                    $nr ++;
                    
                    $objAtleta = new Atleta();
                    $objAtleta->Fetch($atleta_id);
                    $sexo = $objAtleta->getSexo();
                
                    $rowid=$datatmp['afiliaciones_id'];
                    //$str_line .= "<tbody>";
                    $str_line = "<div class='data'>";
                    if($datatmp['pagado']>0){
                         if ($datatmp['conciliado']==0){
                            //$str_line .= "<tr id='data$rowid' style=' background-color:#00ffff'>"; 
                            $str_line .= "<tr id='data$rowid' >"; 
                        }else{
                            $str_line .= "<tr id='data$rowid' style=' background-color:#fff000'>"; 
                           
                        }
                        //$str_line .= "<tr id='data$rowid' style=' background-color:#fff000'>";  
                        $xfvt_monto=$datatmp['fvt'];
                        $xaso_monto=$datatmp['asociacion'];
                        $xsis_monto=$datatmp['sistemaweb'];
                    }else{
                        $str_line .= "<tr id='data$rowid'>";  
                        $xfvt_monto=$fvt_monto;
                        $xaso_monto=$aso_monto;
                        $xsis_monto=$sis_monto;
                    } 
                    
                    $totalFvt = $totalFvt + $xfvt_monto;
                    $totalAso = $totalAso + $xaso_monto;
                    $totalWeb = $totalWeb + $xsis_monto;
                    
                    $str_line .= "<td>".$contador."</td>";
                    $str_line .= "<td>".$ano_afiliacion."</td>";
                    // $str_line .= "<td>".$datatmp['fecha_registro']."</td>";
                    $str_line .= "<td>".$objAtleta->getCedula()."</td>";
                    $str_line .= "<td>".$objAtleta->getNombres()."</td>";
                    $str_line .= "<td>".$objAtleta->getApellidos()."</td>";
                    $str_line .= "<td>".$objAtleta->FechaNacimientoDDMMYYYY()."</td>";

                    $str_line .= "<td>".$xfvt_monto." </td>";
                    $str_line .= "<td>".$xaso_monto."</td>";
//                    $str_line .= "<td>".$xsis_monto.' '.$sistemaWebCicloCobro."</td>";

                    $str_line .= "<td>".$objAtleta->getEstado()."</td>";
                    //$str_line .= "<td>".$objAtleta->getSexo()."</td>";
                    if ($objAtleta->getSexo()=="F" || $objAtleta->getSexo()=="M"){
                        $str_line .= "<td>".$objAtleta->getSexo()."</td>";
                    }else{
                         $str_line .= "<td class='alert alert-danger'>x</td>";
                    }
                    $str_line .= "<td>".$datatmp['categoria']."</td>";

                    $str_line .= "<td>".$datatmp['modalidad']."</td>";
                    
                    if ($chkFiltro == 0) {
                        $str_line .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record'  ></td>";
                    } else {
                        if ($datatmp['conciliado'] > 0) {
                            $str_line .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record'  checked='checked' disabled></td>";
                        } else {
                            $str_line .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record'  checked='checked'></td>";
                        }
                    }
                    $str_line .= "<td > <a class='edit-href glyphicon glyphicon-pencil' target='blank_' href='../Ficha/FichaDatosBasicos.php?id=$atleta_id' data-id='f$rowid'></a></td>";
          
                   
                    $str_line .= "</tr>";
                    $acum_linea_out .= $str_line;
  //                  echo $str_line;

                    }
            }
            $str_line = "<tr>";
            $str_line .= "<td>$nr</td>";
            $str_line .= "<td>****</td>";
            $str_line .= "<td>**********</td>";
            $str_line .= "<td>********************</td>";
            $str_line .= "<td>TOTALES</td>";
            $str_line .= "<td>=======></td>";
    
            $str_line .= "<td>".formatear_monto($totalFvt)."</td>";
            $str_line .= "<td>".formatear_monto($totalAso)."</td>";
            $str_line .= "<td>".formatear_monto($totalWeb)."</td>";
            $str_line .= "<td>*** </td>";
            $str_line .= "<td>***</td>";
            $str_line .= "<td>***</td>";
            $str_line .= "<td>***</td>";
            $str_line .= "<td>***</td>";
           
            $str_line .= "</tr>";
            $str_line .= "</tbody>";
            $str_line .= "</div>";
$str_line .='</table>
    </div>';
//    echo $str_line;    

$lineaOut=$str_head . $acum_linea_out . $str_line;


if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos Registrados","pagination"=>"");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
exit;


