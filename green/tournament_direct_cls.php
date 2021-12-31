<?php
session_start();
require_once 'appnice/clases/Encriptar_cls.php';
require_once 'appnice/clases/Funciones_cls.php';
require_once 'appnice/clases/Torneo_Archivos_cls.php';
require_once 'appnice/clases/Torneos_Inscritos_cls.php';
require_once "appnice/clases/Torneos_cls.php";
require_once 'appnice/sql/ConexionPDO.php';

class Torneos_Directos
{
    public function __construct($mes) {
        $this->mes= $mes;
    }

    public function data()
    {
        
        $mes = $this->mes;
        //$mes= isset($_POST['mes']) ? substr($_POST['mes'],7) : '4';

        $status_filtro="all";//$_POST['status'];
        //sleep(1);
        switch ($status_filtro) {
            case "Accion":
                $status_filtro="Accion";
                break;
            case "Abierto":
                $status_filtro="Abierto";
                break;
            default:
                break;
        }
        $linea='';

                    
        // Buscamos los torneos vigentes
        $objTorneo = new Torneo();
        //$rsColeccion_Torneos=$objTorneo->ReadAll($empresa_id,TRUE,$mes);
        $rsColeccion_Torneos=$objTorneo->ReadAll(0,TRUE,$mes);
        $strDataHTML =NULL;
                
        foreach ($rsColeccion_Torneos as $row) {

            $estatus = Torneo::Estatus_Torneo($row['fechacierre'],$row['fecha_inicio_torneo'],$row['tipo'],$row['condicion']);
            $copa=$row['nombre'];
            $fecha_cierre=$row['fechacierre'];
            $fecha_retiro=$row['fecharetiros'];
            $fecha_inicio=$row['fecha_inicio_torneo'];
            $ffecha_cierre=date_format(date_create($row['fechacierre']),'d-M H:i');
            $ffecha_retiro=date_format(date_create($row['fecharetiros']),'d-M H:i');
            $ffecha_inicio=date_format(date_create($row['fecha_inicio_torneo']),'d-M H:i');
            $ffecha_fin=date_format(date_create($row['fecha_fin_torneo']),'d-M  H:i');
            $sfecha_ini=date_format(date_create($row['fecha_inicio_torneo']),'d-M-y');
            $sfecha_fin=date_format(date_create($row['fecha_fin_torneo']),'d-M-y');

            if ($status_filtro!==$estatus){
                $strData="";
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
                $href='';
                $strData='';
                switch ($estatus) {
                    case 'Abierto':
                        $href='href="appnice/Inscripcion/InscripcionPost.php?id=9999"';
                        
                        $panel_estatus='panel-success';
                        $text_alert="alert alert-success";
                        $strData = '<tr class=" "  >  ';
                        $strData .= '<td><a href="appnice/Inscripcion/InscripcionPost.php?id=9999" class="glyphicon glyphicon-hourglass inscribeme"></a></td>';
                        //echo '<td><a  target="" href="Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                        // $strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus"><a  target="" href="Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                        break;
                    case 'Cerrado':
                        $panel_estatus='panel-default';
                        $text_alert="alert alert-info";
                        $strData = '<tr class=" " >';
                        $strData .= '<td><p class="glyphicon glyphicon-ban-circle "></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                    case 'Proximo':
                        $panel_estatus='panel-default';
                        $text_alert="alert alert-info";
                        $strData = '<tr class=" " >';
                        $strData .= '<td ><p class="glyphicon glyphicon-eye-open"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                        case 'Accion':
                        $panel_estatus='panel-warning';
                        $text_alert="alert alert-warning";
                        $strData = '<tr class=" " >';
                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        $strData .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                        case 'Suspendido':
                        $panel_estatus='panel-danger';
                        $text_alert="alert alert-danger";
                        $strData = '<tr class=" " >';
                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        $strData .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                        case 'Diferido':
                        $panel_estatus='panel-info';
                        $text_alert="alert alert-info";
                        $strData = '<tr class=" " >';
                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        $strData .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                        case 'Cancelado':
                        $panel_estatus='panel-danger';
                        $text_alert="alert alert-danger";
                        $strData = '<tr class=" " >';
                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                        $strData .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                    default:
                        $panel_estatus='panel-default';
                        $text_alert="alert alert-info";
                        $strData = '<tr class=" " >';
                        //echo '<td ><p class=" glyphicon glyphicon-remove"></p></td>';
                        $strData .= '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                        //$strData .= '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                        break;
                }
                $hash_tid=urlencode(Encrypter::encrypt($row['torneo_id']));
                $hash_codigo= urlencode(Encrypter::encrypt($row['codigo']));
                $strGrado= $row['tipo'];$strNumero=$row['numero'];
                $strDataGrado= '<td data-toggle="tooltip" data-placement="bottom" title="Grado">'. $row['numero']."-". $row['tipo'].'</td>';
                $strDataCategoria= '<td data-toggle="tooltip" data-placement="bottom" title="Categoria">'. str_replace(',',"<br>",$row['categoria']).'</td>';
                $strDataEntidad = '<td data-toggle="tooltip" data-placement="bottom" title="Entidad">'. $row['entidad'].'</td>';
                $strDataFechas= "<td data-toggle='tooltip' data-placement='auto' title='Fechas del Torneo'>"
                . ""
                . "<p class='xfechacierre'>Cierre: $ffecha_cierre</p>"
                . "<p class='xfecharetiro'>Retiro: $ffecha_retiro</p>"
                . "<p class='xfechainicio'>Inicio: $ffecha_inicio</p>"
                . ""
                . "</td>";
                /* fecha de torneo
                $strData .= '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Cierre">'. $row['fechacierre'].'</td>';
                $strData .= '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Retiro">'. $row['fecharetiros'].'</td>';
                $strData .= '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Inicio">'.$row['fecha_inicio_torneo'].'</td>';
                */
                
                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "fs");
                if($rsTorneo_fs){
                    $fsheet= '<a href="appnice/Torneo/Download_Doc.php?thatid='.
                            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('fs')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon glyphicon-blackboard">F. Sheet</a>';
                }else{
                    $fsheet= '<a  class="inactivo-glyphicon glyphicon glyphicon-blackboard">F. Sheet</a>';
                }

                $Total_inscritos = TorneosInscritos::Count_Inscritos($row['torneo_id']);
                
                if ($Total_inscritos>0){
                    $listaIn= '<a target="_blank" href="Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
                    .$hash_codigo.'" class="activo-glyphicon glyphicon glyphicon-align-justify">Lista</a>';
                }else{
                    $listaIn= '<a  class=" inactivo-glyphicon glyphicon glyphicon-align-justify">Lista</a>';
                }
                
                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "la");
                if($rsTorneo_fs){
                    $listaAc= '<a href="appnice/Torneo/Download_Doc.php?thatid='.
                    $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('la')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-list">Lista Ac.</a>';
                }else{
                    $listaAc= '<a  class="inactivo-glyphicon glyphicon glyphicon-list">Lista Ac.</a>';
                } 
                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "ds");
               
                if($rsTorneo_fs){
                    $draws= '<a href="appnice/Torneo/Download_Doc.php?thatid='.
                    $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('ds')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-file">Draw SG.</a>';
                }else{
                    $draws = '<a  class="inactivo-glyphicon glyphicon glyphicon-file">Draw SG.</a>';
                }
                               
                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "dd");
                if($rsTorneo_fs){
                    $drawd = '<a href="appnice/Torneo/Download_Doc.php?thatid='.
                    $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('dd')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-duplicate">Draw DB.</a>';
                }else{
                    $drawd = '<a  class="inactivo-glyphicon glyphicon glyphicon-duplicate">Draw DB.  </a>';
                }   
               
                //Galeria
                $folder="uploadFotos/torneos/".$row['torneo_id']."/";
                
                $key=  $hash_codigo.",".$row['torneo_id'];
                $ghref="Galerias/Galeria.php?tid=".$key;
                // if(Imagenes::findGaleria($folder)){
                //     $strDataga= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria"><a href="'.$ghref.'" target="_blank" class="activo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                // }else{
                //     $strDataga= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                // }   
                
                
                switch ($row['tipo']) {
                    case 'G1':
                        $single='16';
                        $doble='8';
                        break;
                    case 'G2':
                        $single='32';
                        $doble='16';
                        break;
                    case 'G3':
                        $single='48';
                        $doble='24';
                        break;
                    case 'G4':
                        $single='64';
                        $doble='32';
                        break;
                    default:
                        $single='ND';
                        $doble='ND';
                        break;
                }
                
                $col1='<div class="col-md-1 timg"><img src="images/tennis_p_small.png" alt="" />'.$row['numero']." - ".$strGrado.'  </br>'.$row['categoria'].'</div>';
                $col2="<div class='col-md-2 t1'><p>$ffecha_inicio</p></div>";
                $col3='<div class="col-md-3 t2"><p>'.$copa.'</p> </div>';
                $col4='<div class="col-md-2 t3"><p>'.$row['entidad'].'</p></div>';
                //$col5="<div class='col-md-2 t4'><p>SGL $single <br />DBL $doble</p></div>";
                $col5="<div class='col-md-2 t4'>$listaAc</br>$fsheet</br>$draws </br>$drawd</div>";
                $col6='<div class="col-md-2 t5"><a '.$href.'>'.$estatus.'</a></div>';
                $col7='<div class="acc-footer"></div>';
        
                $linea .=$col1 . $col2 . $col3 . $col4 . $col5 . $col6 . $col7;
            }
                
                    
        }
        $colh=
                '
                <div class="col-md-1 acc-title">Cat.</div>
                <div class="col-md-2 acc-title">Fecha</div>
                <div class="col-md-3 acc-title">Torneo</div>
                <div class="col-md-2 acc-title">Entidad</div>
                <div class="col-md-2 acc-title">Reportes</div>
                <div class="col-md-2 acc-title">Estatus</div>
               
            
            ';
        $data = $colh . $linea; 
        // if ($strDataHTML==NULL){
        //     $jsondata= array("Success"=>FALSE,"Mensaje"=>"<p id='info-torneo' >No hay Informacion para el Estatus $status_filtro en el Mes  $mes </p>",'html'=>"");   
        // }else{
        //     $jsondata= array("Success"=>TRUE,"Mensaje"=>"Informacion disponible",'html'=>$HTMLDATA);
        // }
        // header('Content-type: application/json; charset=utf-8');
        // echo json_encode($jsondata, JSON_FORCE_OBJECT);
        if ($data){
            return ($data);
    
        }else{
            return false;
        }
    }
}