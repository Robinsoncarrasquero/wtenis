<?php

session_start();
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/Imagenes_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Paginacion_cls.php';
require_once '../clases/Torneo_Archivos_cls.php';

$atleta_id =Encrypter::decrypt($_POST['id']);
$pagina =  intval(substr($_POST['pagina'],4));
//sleep(1);

//Paginacion
$objPaginacion = new Paginacion(5,$pagina);
$querycount="SELECT count(*)as total FROM torneoinscritos WHERE atleta_id =$atleta_id";
$objPaginacion->setTotal_Registros($querycount);
$total_registros=$objPaginacion->getTotal_Registros();
$select="SELECT torneo.*,torneoinscritos.categoria AS LACATEGORIA FROM torneoinscritos INNER JOIN torneo ON torneo.torneo_id=torneoinscritos.torneo_id "
        . "WHERE atleta_id =$atleta_id order by torneo.fecha_inicio_torneo desc ";
$records=$objPaginacion->SelectRecords($select);
            
    
    $strTable = '<div class="col-sm-12 col-sm-8">';
   
    $strTable .='
            <div class="table"> 
            <table class="table table-striped table-responsive">

                <thead >        
                    <tr class="table-head ">
                        <th><p class="glyphicon glyphicon-dashboard"<p></th>
                        <th>Ent</th>
                        <th>Grado</th>
                        <th>Doc</th>
                        <th>LI</th>
                        <th>FS</th>
                        <th>Draw</th>
                        
                        <th>Fotos</th>
                        <th>Fecha</th>
                     </tr>
                </thead>';
                
                 //echo   $strTable ;
                           
                            
                $habilitado= $_SESSION['SWEB'];
                $nr=0;
                foreach ($records as $record) {

                    $objTorneo = new Torneo();
                    $row=$objTorneo->RecordById($record['torneo_id']);

                    if (Fecha_Apertura_Calendario($row['fechacierre']) <= Fecha_Hoy() && Fecha_Create($row['fechacierre']) > Fecha_Hoy()) {

                             $estatus="Open";
                     } else {
                         if (Fecha_Apertura_Calendario($row['fechacierre']) > Fecha_Hoy()) {

                             $estatus="Next";
                         } else {

                             if (Fecha_Fin_Torneo($row['fecha_inicio_torneo']) >= Fecha_Hoy()
                                && Fecha_ini_Torneo($row['fecha_inicio_torneo'],$row['tipo']) < Fecha_Hoy()){

                                     $estatus="Running";
                             }else {
                                 if (Fecha_Fin_Torneo($row['fecha_inicio_torneo']) < Fecha_Hoy()) {

                                     $estatus="End";
                                 }else{
                                     $estatus="Closed";
                                 }
                             }
                         }
                     }
                        if($habilitado){
                             $mostrar=TRUE;
                        }else{
                            if (Fecha_Create($row['fecha_inicio_torneo']) < Fecha_Hoy()){
                               $mostrar=TRUE;
                            }  else {
                               $mostrar=FALSE;
                            }
                        }
                        if($mostrar){
                            switch ($estatus) {
                                case 'Open':
                                    $strTable .= '<tr class="success"  >  ';

                                    $strTable .= '<td><p class="Link glyphicon glyphicon-ok"></p></td>';
                                    //echo '<td><a class=" edit-record" target="" href="../Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                                    break;

                                case 'Closed':
                                    $strTable .= '<tr class=" " >';
                                    $strTable .= '<td><p class="glyphicon glyphicon-remove-sign"></p></td>';
                                    //echo '<td>'.$estatus.'</td>';
                                    break;
                                case 'Next':
                                    $strTable .= '<tr class=" edit-record" >';
                                    $strTable .= '<td ><p class="glyphicon glyphicon-eye-open"></p></td>';
                                   // echo '<td>'.$estatus.'</td>';
                                    break;
                                case 'Running':
                                   $strTable .= '<tr class="warning " >';
                                   $strTable .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                   //echo '<td>'.$estatus.'</td>';
                                   break;
                                default:
                                    $strTable .= '<tr class=" " >';
                                    $strTable .= '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                                    //echo '<td>'.$estatus.'</td>';
                                    break;
                            }
                            $key= urlencode(Encrypter::encrypt($row['torneo_id']));
                            $hash_tid=urlencode(Encrypter::encrypt($row['torneo_id']));
                            $hash_codigo= urlencode(Encrypter::encrypt($row['codigo']));
                            $strTable .= '<td >'. $row['entidad'].'</td>';
                            $strTable .= '<td>'.$row['numero']."-".$row['tipo'].'<br>';
                            $strTable .= '<strong><mark class="badge" >'. $record['LACATEGORIA'].'</mark></strong></td>';
                            // echo '<td><a data-id="co'.$row['torneo_id'].'" href="MisConstancias.php?torneo_id='.$row['torneo_id'].'" target="_blank" class="glyphicon glyphicon-print edit-record">  </a></td>';
                            $strTable .= '<td><a data-id="co'.$row['torneo_id'].'" href="../Constancias/ConstanciaParticipacion.php?torneo_id='.$key.'" target="_blank" class="glyphicon glyphicon-print edit-record">  </a></td>';
                            
                        //Lista de Inscritos              
                        $Total_inscritos = TorneosInscritos::Count_Inscritos($row['torneo_id']);
                        if ($Total_inscritos>0){
                            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos"><a target="_blank" href="../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
                            .$hash_codigo.'" class="activo-glyphicon glyphicon glyphicon-align-justify"></a></td>';
                        }else{
                            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos Vacia"> <a  class=" inactivo-glyphicon glyphicon glyphicon-align-justify">  </a></td>';
                        }    
                        $strTable .=$strDatali;
                        //FSheet
                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "fs");
                        if($rsTorneo_fs){
                            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet"> <a href="../Torneo/Download_Doc.php?thatid='.
                                    $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('fs')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon glyphicon-blackboard">  </a></td>';
                        }else{
                            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> <a  class="inactivo-glyphicon glyphicon glyphicon-blackboard">  </a></td>';
                        }
                        $strTable .=$strDatafs;

                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "ds");
                        $strDraw="<td>";
                        if($rsTorneo_fs){
                            $draws= '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles"><a href="../Torneo/Download_Doc.php?thatid='.
                            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('ds')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-file">  </a></p>';
                        }else{
                            $draws = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-file">  </a></p>';
                        }

                        $strDraw .=$draws;
                        //$strDraw .="</td>"; 
                        //$strDraw .="<td>";
                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "dd");
                        if($rsTorneo_fs){
                            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles"><a href="../Torneo/Download_Doc.php?thatid='.
                           $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('dd')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
                        }else{
                            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
                        }   
                        $strDraw .=$drawd;
                        $strDraw .="</td>";
                        $strTable .=$strDraw;

                        //Galeria
                        $folder="../uploadFotos/torneos/".$row['torneo_id']."/";
                        $key=  $row['codigo'].",".$row['torneo_id'];
                        $ghref="../Galerias/Galeria.php?tid=".$key;
                        if(Imagenes::findGaleria($folder)){
                            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria"><a href="'.$ghref.'" target="_blank" class="activo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                        }else{
                            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                        }
                        $strTable .=$strGaleria;
                        $strTable .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha'>"
                        . ""
                        //. "<p class='fechacierre'>Cierre: ". date_format(date_create($row['fechacierre']),"d-m-Y")."</p>"
                        //. "<p class='fecharetiro'>Retiro: ".date_format(date_create($row['fecharetiros']),"d-m-Y")."</p>"
                        . "<mark>".date_format(date_create($row['fecha_inicio_torneo']),"d-m-Y")."</mark>"
                        . ""
                        . "</td>";
                        $strTable .= '</tr>';

                        $nr++;

                        }

                }

$strTable .=
                        '   
                        </table>
                </div>';
      

        
 $strTable .=  '</div>';
 
   
  //Lado derecho
    $strTable .= '<div class="col-xs-12 col-sm-4">';
    $strTable .= '<div class="notas-left ">';

    $strTable .=  '<h5 class="alert alert-warning">'. Bootstrap_Class::texto("Mensaje:").''
            . '<br><br> Ahora puedes imprimir la constancia de participacion '
            . 'de torneo en la columna <mark>(Doc)</mark>con el icono <a class="glyphicon glyphicon-print"></a> '
            . '.</h5>';
    if ($nr>0){
    
        $strTable .= ''
                . '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Mensaje:").
                "<br><br>Torneos que ha inscrito ($total_registros).</h5>"
                . '';
    }

    $strTable .= '</div>';
    $strTable .= '</div>';
$lineaOut=$strTable;

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
