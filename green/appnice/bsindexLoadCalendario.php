<?php
require_once 'clases/Noticias_cls.php';
require_once "clases/Empresa_cls.php";
require_once "clases/Torneos_cls.php";
require_once 'funciones/funcion_fecha.php';
require_once 'clases/Torneo_Archivos_cls.php';
require_once 'clases/Torneos_Inscritos_cls.php';
require_once 'sql/ConexionPDO.php';
require_once 'funciones/Imagenes_cls.php';
require_once 'clases/Encriptar_cls.php';

if ($_SERVER['REQUEST_METHOD']=='GET'){
    die();
}

$empresa_id =$_POST['empresa_id'];
$mes=$_POST['mes'];
//sleep(1);


$strTable =
' <div>
    <div class="table-torneo ">
                <div class="table-responsive">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th>
                                    <th>Status</th>
                                    <th>Grado</th>
                                    <th>Categ</th>
                                    <th>Ent.</th>
                                    <th>Cierre</th>
                                    <th>Retiros</th>
                                    <th>Inicio</th>
                                    <th>FS</th>
                                    <th>LI</th> 
                                    <th>LA</th> 
                                    <th>DS</th>
                                    <th>DD</th>
                                    <th>Fotos</th>
                                    
                                </tr>
                            </thead>
                            <tbody>';
                            echo   $strTable ;
                            
                            // Buscamos los torneos vigentes
                            $objTorneo = new Torneo();
                            //$rsColeccion_Torneos=$objTorneo->ReadAll($empresa_id,TRUE,$mes);
                            $rsColeccion_Torneos=$objTorneo->ReadAll(0,TRUE,$mes);
                            foreach ($rsColeccion_Torneos as $row) {

                                $hash_codigo= urlencode(Encrypter::encrypt($row['torneo_id']));

                                if (Torneo::Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) <= Torneo::Fecha_Hoy() && Torneo::Fecha_Create($row['fechacierre']) > Torneo::Fecha_Hoy()) {

                                        $estatus="Open";
                                } else {
                                    if (Torneo::Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) > Torneo::Fecha_Hoy()) {

                                        $estatus="Next";
                                    } else {

                                        //Aqui mantenemos la fecha entre dos intervalos para el running
                                        //Cuando comienza y terminael torneo
                                        if (Torneo::Fecha_Fin_Torneo($row['fecha_inicio_torneo']) >= Torneo::Fecha_Hoy()
                                            && Fecha_ini_Torneo($row['fecha_inicio_torneo'],$row['tipo']) < Torneo::Fecha_Hoy()){

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
                                        echo '<tr class="success"  >  ';
                                        echo '<td><a target="" href="Inscripcion/bsInscripcion.php" class="glyphicon glyphicon-hourglass"></a></td>';
                                        //echo '<td><a  target="" href="Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                                        echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus"><a  target="" href="Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                                        break;
                                     case 'Closed':
                                        echo '<tr class=" " >';
                                        echo '<td><p class="glyphicon glyphicon-ban-circle "></p></td>';
                                         echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                    case 'Next':
                                        echo '<tr class=" " >';
                                        echo '<td ><p class="glyphicon glyphicon-eye-open"></p></td>';
                                        echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                     case 'Running':
                                        echo '<tr class="warning " >';
                                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                        echo '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                         echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                     case 'Suspendido':
                                        echo '<tr class="danger " >';
                                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                        echo '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                        echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                     case 'Diferido':
                                        echo '<tr class="info " >';
                                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                        echo '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                         echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                     case 'Cancelado':
                                        echo '<tr class="danger " >';
                                        //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                        echo '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                        echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                    default:
                                        echo '<tr class=" " >';
                                        //echo '<td ><p class=" glyphicon glyphicon-remove"></p></td>';
                                        echo '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                                        echo '<td data-toggle="tooltip" data-placement="auto" title="Estatus">'.$estatus.'</td>';
                                        break;
                                }
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Grado">'. $row['numero']."-". $row['tipo'].'</td>';
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Categoria">'. $row['categoria'].'</td>';
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Entidad">'. $row['entidad'].'</td>';
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Cierre">'. $row['fechacierre'].'</td>';
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Retiro">'. $row['fecharetiros'].'</td>';
                                echo '<td data-toggle="tooltip" data-placement="bottom" title="Fecha Inicio">'.$row['fecha_inicio_torneo'].'</td>';
                                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "fs");
                                if($rsTorneo_fs){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet"> <a href="Torneo/Download_Doc.php?thatid='.
                                            urlencode(Encrypter::encrypt($row['torneo_id'])).
                                    '&thatdoc='.urlencode(Encrypter::encrypt('fs')).'" target="_blank" class="glyphicon glyphicon-thumbs-up">  </a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> <a  class="text-muted glyphicon glyphicon-blackboard">  </a></td>';
                                }
                                $Total_inscritos = TorneosInscritos::Count_Inscritos($row['torneo_id']);
                                if ($Total_inscritos>0){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos"><a target="_blank" href="Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
                                    .  urlencode(Encrypter::encrypt($row['codigo'])).'" class="glyphicon glyphicon-thumbs-up"></a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos Vacia"> <a  class="text-muted glyphicon glyphicon-align-justify">  </a></td>';
                                }
                                //echo '<td><a target="_blank" href="Torneo/bsTorneo_Listado_Atletas_pdf.php?torneo='.$row['codigo'].'&sexo=&categoria=&chk=0'.'" class="glyphicon glyphicon-list-alt"></a></td>';
                                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "la");
                                if($rsTorneo_fs){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Aceptacion"><a href="Torneo/Download_Doc.php?thatid='.
                                    urlencode(Encrypter::encrypt($row['torneo_id'])).
                                    '&thatdoc='.urlencode(Encrypter::encrypt('la')).'" target="_blank" class="glyphicon glyphicon-thumbs-up">  </a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Aceptacion Vacia"><a  class="text-muted glyphicon glyphicon-list">  </a></td>';
                                } 
                                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "ds");
                                if($rsTorneo_fs){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Draw Singles"><a href="Torneo/Download_Doc.php?thatid='.
                                    urlencode(Encrypter::encrypt($row['torneo_id'])).
                                    '&thatdoc='.urlencode(Encrypter::encrypt('ds')).'" target="_blank" class="glyphicon glyphicon-thumbs-up">  </a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Draw Singles No Disponible"><a  class="text-muted glyphicon glyphicon-file">  </a></td>';
                                }
                                $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "dd");
                                if($rsTorneo_fs){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Draw Dobles"><a href="Torneo/Download_Doc.php?thatid='.
                                    urlencode(Encrypter::encrypt($row['torneo_id'])).
                                    '&thatdoc='.urlencode(Encrypter::encrypt('dd')).'" target="_blank" class="glyphicon glyphicon-thumbs-up">  </a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Draw Dobles No Disponible"><a  class="text-muted glyphicon glyphicon-duplicate">  </a></td>';
                                }   
                                //Galeria
                                $folder="uploadFotos/torneos/".$row['torneo_id']."/";
                                $key=  Encrypter::encrypt($row['torneo_id'].",".$row['torneo_id']);
                                $key=  $row['codigo'].",".$row['torneo_id'];
                                $ghref="Galerias/Galeria.php?tid=".$key;
                                if(Imagenes::findGaleria($folder)){
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Galeria"><a href="'.$ghref.'" target="_blank" class="glyphicon glyphicon-thumbs-up">  </a></td>';
                                }else{
                                    echo '<td data-toggle="tooltip" data-placement="bottom" title="Galeria No Disponible"><a  class="text-muted glyphicon glyphicon-picture">  </a></td>';
                                }   
                                echo '</tr>';
                            }

$strTable=
                        '</tbody>    
                    </table>
                   
                    </div>
                   </div>
                </div>';

echo $strTable;
