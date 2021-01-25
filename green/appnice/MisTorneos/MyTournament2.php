<?php
session_start();
//require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/Imagenes_cls.php';
require_once '../sql/ConexionPDO.php';
//require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Paginacion_cls.php';
require_once '../clases/Torneo_Archivos_cls.php';
require_once '../funciones/bsTemplate.php';

$atleta_id =Encrypter::decrypt($_POST['id']);
$pagina = intval(substr($_POST['pagina'],4));
//sleep(1);


//Paginacion
$objPaginacion = new Paginacion(5,$pagina);
$querycount="SELECT count(*) as total FROM torneoinscritos WHERE atleta_id =$atleta_id";
$objPaginacion->setTotal_Registros($querycount);
$total_registros=$objPaginacion->getTotal_Registros();
$select="SELECT torneo.torneo_id,torneoinscritos.categoria AS LACATEGORIA FROM torneoinscritos INNER JOIN torneo ON torneo.torneo_id=torneoinscritos.torneo_id "
        . "WHERE atleta_id =$atleta_id order by torneo.fecha_inicio_torneo desc ";
$records=$objPaginacion->SelectRecords($select);

//<!--main content start-->
    $main = [];
    $dmain =[];
    array_push($main, $dmain);
    $main_content=  bsTemplate::main_content('Mis Torneos',$main);
    
    $thead = [];
    $thead +=["Fecha"=>"glyphicon glyphicon-calendar"];
    //$thead +=["."=>"glyphicon glyphicon-time"];
    $thead +=["Ent"=>"glyphicon glyphicon-flag"];
    $thead +=["Gr"=>"glyphicon glyphicon-signal"];
    $thead +=["Doc"=>"glyphicon glyphicon-print"];
    $thead +=["Li"=>"glyphicon glyphicon-list-alt"];
    $thead +=["Fs"=>"glyphicon glyphicon-info-sign"];
    $thead +=["Dw"=>"glyphicon glyphicon-equalizer"];
    //$thead +=["Fotos"=>"glyphicon glyphicon-image"];
                  
    $table_head=bsTemplate::table_head("Mis Torneos",$thead);
    $table_footer='
                </tbody>
            </table>
        </section>
    </div>
</div>';

$strTable='';
$table_data='';           
            
$nr=0;
foreach ($records as $record) {

    $objTorneo = new Torneo();
    $row=$objTorneo->RecordById($record['torneo_id']);

    if (Torneo::Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) <= Torneo::Fecha_Hoy() && Torneo::Fecha_Create($row['fechacierre']) > Torneo::Fecha_Hoy()) {

                $estatus="Open";
        } else {
            if (Torneo::Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) > Torneo::Fecha_Hoy()) {

                $estatus="Next";
            } else {

                if (Torneo::Fecha_Fin_Torneo($row['fecha_inicio_torneo']) >= Torneo::Fecha_Hoy()
                && Torneo::Fecha_ini_Torneo($row['fecha_inicio_torneo'],$row['tipo']) < Torneo::Fecha_Hoy()){

                        $estatus="Running";
                }else {
                    if (Torneo::Fecha_Fin_Torneo($row['fecha_inicio_torneo']) < Torneo::Fecha_Hoy()) {

                        $estatus="End";
                    }else{
                        $estatus="Closed";
                    }
                }
            }
        }
        
        //Filtro condicional por la fecha
        if (Torneo::Fecha_Create($row['fecha_inicio_torneo']) <= Torneo::Fecha_Hoy()){
            $mostrar=TRUE;
        }  else {
            $mostrar=FALSE;
        }
        $mostrar=TRUE;
        if($mostrar){
            switch ($estatus) {
                case 'Open':
                    $strTable .= '<tr class="small "  >  ';

                  //  $strTable .= '<td><p class="Link '.bsTemplate::icono_estatus_torneo('Open').'"></p></td>';
                    break;

                case 'Closed':
                    $strTable .= '<tr class="small " >';
                //    $strTable .= '<td><p class="'.bsTemplate::icono_estatus_torneo('Closed').'"></p></td>';
                    break;
                case 'Next':
                    $strTable .= '<tr class="small edit-record" >';
                 //   $strTable .= '<td ><p class="'.bsTemplate::icono_estatus_torneo('Next').'"></p></td>';
                    break;
                case 'Running':
                    $strTable .= '<tr class="small warning " >';
                //    $strTable .= '<td ><p class="'.bsTemplate::icono_estatus_torneo('Running').'"></p></td>';
                    break;
                default:
                    $strTable .= '<tr class="small " >';
                //    $strTable .= '<td ><p class="'.bsTemplate::icono_estatus_torneo(' ').'"></p></td>';
                    break;
            }
            $strTable .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha'>"
            . "".date_format(date_create($row['fecha_inicio_torneo']),"d-m-y").""
            . "</td>";
        
            $key= urlencode(Encrypter::encrypt($row['torneo_id']));
            $hash_tid=urlencode(Encrypter::encrypt($row['torneo_id']));
            $hash_codigo= urlencode(Encrypter::encrypt($row['codigo']));
            $strTable .= '<td >'. $row['entidad'].'</td>';
            $strTable .= '<td >'.$row['numero']."-".$row['tipo'].'<br>';
            $strTable .= '<i>'. $record['LACATEGORIA'].'</i></td>';
            // echo '<td><a data-id="co'.$row['torneo_id'].'" href="MisConstancias.php?torneo_id='.$row['torneo_id'].'" target="_blank" class="glyphicon glyphicon-print edit-record">  </a></td>';
            $strTable .= '<td><a data-id="co'.$row['torneo_id'].'" href="../Constancias/ConstanciaParticipacion.php?torneo_id='.$key.'" 
            target="_blank" class=" glyphicon glyphicon-print edit-record">  </a></td>';
            
        //Lista de Inscritos              
        $Total_inscritos = TorneosInscritos::Count_Inscritos($row['torneo_id']);
        if ($Total_inscritos>0){
            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos">
            <a target="_blank" href="../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
            .$hash_codigo.'" class="activo-glyphicon glyphicon glyphicon-align-justify"></a></td>';
        }else{
            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos Vacia">
             <a  class=" inactivo-glyphicon glyphicon glyphicon-align-justify">  </a></td>';
        }    
        $strTable .=$strDatali;
        //FSheet
        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "fs");
        if($rsTorneo_fs){
            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet"> 
            <a href="../Torneo/Download_Doc.php?thatid='.
            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('fs')).'" target="_blank" 
            class="activo-glyphicon glyphicon glyphicon-info-sign">  </a></td>';
        }else{
            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> 
            <a  class="inactivo-glyphicon glyphicon glyphicon-info-sign">  </a></td>';
        }
        $strTable .=$strDatafs;

        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "ds");
        $strDraw="<td>";
        if($rsTorneo_fs){
            $draws= '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles">
            <a href="../Torneo/Download_Doc.php?thatid='.
            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('ds')).'" target="_blank" 
            class="activo-glyphicon glyphicon glyphicon-file">  </a></p>';
        }else{
            $draws = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles No Disponible">
            <a  class="inactivo-glyphicon glyphicon glyphicon-file">  </a></p>';
        }
        $strDraw .=$draws;
    
        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "dd");
        if($rsTorneo_fs){
            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles">
            <a href="../Torneo/Download_Doc.php?thatid='.
            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('dd')).'" target="_blank" 
            class="activo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
        }else{
            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles No Disponible">
            <a  class="inactivo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
        }   
        $strDraw .=$drawd;
        $strDraw .="</td>";
        $strTable .=$strDraw;

        //Galeria
        $folder="../uploadFotos/torneos/".$row['torneo_id']."/";
        $key=  $row['codigo'].",".$row['torneo_id'];
        $ghref="../Galerias/Galeria.php?tid=".$key;
        if(Imagenes::findGaleria($folder)){
            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria">
            <a href="'.$ghref.'" target="_blank" class="activo-glyphicon glyphicon glyphicon-picture">  </a></td>';
        }else{
            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria No Disponible">
            <a  class="inactivo-glyphicon glyphicon glyphicon-picture">  </a></td>';
        }
        //$strTable .=$strGaleria;
        $strFecha = "<td data-toggle='tooltip' data-placement='auto' title='Fecha'>"
        . ""
        . "<mark>".date_format(date_create($row['fecha_inicio_torneo']),"d-m-y")."</mark>"
        . "<p>to<p>"
        . "<mark>".date_format(date_create($row['fecha_fin_torneo']),"d-m-y")."</mark>"
        . "</td>";
    
        $strTable .= '</tr>';
        $table_data =$strTable;
        $nr++;
        
        }

}
$texto =' '
. 'Ahora puedes imprimir la constancia de participacion '
. 'de torneo en la columna <mark>(Doc)</mark>con el icono <a class="glyphicon glyphicon-print"></a> ';
$notaspanel = bsTemplate::panel('<i class="icon_printer  label label-warning"></i>Constancia',$texto,'alert alert-info','col-lg-6');

if ($nr>0){
    $texto =' '
    . "Torneos que ha inscrito ($total_registros) ";
    $notaspanel .= bsTemplate::panel('<i class="icon_document label label-warning"></i>Torneos',$texto,'alert alert-success','col-lg-6');
}


$lineaOut=$main_content . $table_head  . $table_data . $table_footer . $notaspanel;
//$lineaOut=$table_data;
if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
