<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Paginacion_cls.php';

/* 
 Lista de pagos formalizados para el servicio web
 */
      
$afiliacion_id=$_POST['id'];

$chkFiltro=$_POST['chkFiltro']; //Confirmacion de pagos o Por pagar

//Paginacion
$pagina= intval(substr($_POST['pagina'],4));


$str_head=

"<table class='table table-responsive table-striped table-bordered table-condensed'>
            <thead>
                <th>#</th>
                <th>A&ntildeo</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha.Nac.</th>
                <th>Asociaciones</th>
                <th>Asociacion</th>
                <th>Estado</th>
                <th>Sexo</th>
                <th>Cat.</th>
                <th>Modal.</th>
                <th>Formalizar</th>
                <th>Ficha</th>
            </thead>";
            
//$strlinea .= $str_head;
            
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
                        $querycount ='SELECT count(*) as total FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0  ORDER BY fecha_pago desc';
                        $qselect ='SELECT * FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        formalizacion>0 ORDER BY fecha_pago desc';

                        break;
                    case 0: //Afiliaciones no formalizadas
                        $querycount ='SELECT count(*) as total FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        afiliarme>0 && formalizacion!=1 ORDER BY fecha_pago desc';
                        $qselect ='SELECT * FROM afiliaciones WHERE afiliacion_id='.$afiliacion_id.' && 
                        afiliarme>0 && formalizacion!=1 ORDER BY fecha_pago desc';
    
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

                $ixx=0; $nr= 0;
                $totalAso=0;$totalFvt=0;$totalWeb=0;
                
                foreach ($rrsAfiliados as $datatmp)
                {
                    $atleta_id=$datatmp['atleta_id'];
                    $objAtleta = new Atleta();
                    $objAtleta->Fetch($atleta_id);
                    $sexo = $objAtleta->getSexo();
                    $fecha =date('Y-m-d');
                    $contador ++;
                    $rowid=$datatmp['afiliaciones_id'];
                    $strlinea = "<div class='data'>";
                    if($datatmp['formalizacion']>0){
                        $strlinea .= "<tr id='data$rowid'>";  
                        $xfvt_monto=$datatmp['fvt'];
                        $xaso_monto=$datatmp['asociacion'];
                        $xsis_monto=$datatmp['sistemaweb'];
                    }else{
                         $strlinea .= "<tr id='data$rowid'>";  
                        $xfvt_monto=$fvt_monto;
                        $xaso_monto=$aso_monto;
                        $xsis_monto=$sis_monto;
                    } 
                    $nr ++;
                    $totalFvt = $totalFvt + $xfvt_monto;
                    $totalAso = $totalAso + $xaso_monto;
                    $totalWeb = $totalWeb + $xsis_monto;
                  
                    $strlinea .= "<td>".$contador."</td>";
                    $strlinea .= "<td>".$ano_afiliacion."</td>";
                    $strlinea .= "<td>".$objAtleta->getCedula()."</td>";
                    $strlinea .= "<td>".$objAtleta->getNombres()."</td>";
                    $strlinea .= "<td>".$objAtleta->getApellidos()."</td>";
                    $strlinea .= "<td>".$objAtleta->FechaNacimientoDDMMYYYY()."</td>";
                    $strlinea .= "<td>".$xfvt_monto.' '.$fvtCicloCobro." </td>";
                    $strlinea .= "<td>".$xaso_monto.' '.$asociacionCicloCobro."</td>";
                    $strlinea .= "<td>".$objAtleta->getEstado()."</td>";
                    if ($objAtleta->getSexo()=="F" || $objAtleta->getSexo()=="M"){
                        $strlinea .= "<td>".$objAtleta->getSexo()."</td>";
                    }else{
                         $strlinea .= "<td class='alert alert-danger'>x</td>";
                    }
                    $strlinea .= "<td>".$datatmp['categoria']."</td>";
                    $strlinea .= "<td>".$datatmp['modalidad']."</td>";
                    if ($datatmp['formalizacion']>0 ) { 
                        if ($datatmp['pagado']>0){
                            $strlinea .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record'  checked='checked' disabled></td>";
                        }else {
                            $strlinea .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record'  checked='checked'></td>";
                        }
                   }else{
                        $strlinea .= "<td> <input  type='checkbox' name='micheckbox' data-id='$rowid' id='$rowid' class='edit-record' ></td>";
                    }
                   $strlinea .= "<td > <a class='edit-href glyphicon glyphicon-pencil' target='blank_' href='../Ficha/FichaDatosBasicos.php?id=$atleta_id' data-id='f$rowid'></a></td>";
                   $strlinea .= "</tr>";
                   $acum_linea_out .=$strlinea;

                }
            }
            $strlinea = "<tr>";
            $strlinea .= "<td>$nr</td>";
            $strlinea .= "<td>****</td>";
            $strlinea .= "<td>**********</td>";
            $strlinea .= "<td>********************</td>";
            $strlinea .= "<td>TOTALES</td>";
            $strlinea .= "<td>=======></td>";
            $strlinea .= "<td>".formatear_monto($totalFvt)."</td>";
            $strlinea .= "<td>".formatear_monto($totalAso)."</td>";
//            $strlinea .= "<td>".formatear_monto($totalWeb)."</td>";
            $strlinea .= "<td>*** </td>";
            $strlinea .= "<td>***</td>";
            $strlinea .= "<td>***</td>";
            $strlinea .= "<td>***</td>";
            $strlinea .= "<td>***</td>";
            $strlinea .= "<td>***</td>";
            $strlinea .= "</tr>";
            $strlinea .= "</tbody>";
            $strlinea .= "</div>";
             
           
            $strlinea .='</table>
            </div>';
        //    echo $str_line;    
        
        $lineaOut=$str_head . $acum_linea_out . $strlinea;
        
        
        if ($nr>0){
            $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
        } else {    
            $jsondata = array("Success" => False, "html"=>"No hay datos Registrados","pagination"=>"");
        }
        
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata, JSON_FORCE_OBJECT);
        exit;
        
