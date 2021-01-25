<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Encriptar_cls.php';

if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: ../Login.php');
 }

$empresa_id =$_SESSION['empresa_id'];

$objEmpresa = new Empresa();
$objEmpresa->Find($empresa_id);
$entidad=$objEmpresa->getEstado();
if ($_SESSION['niveluser']==99){
    $empresa_id=0;
}

$mes=$_POST['mes'];
//sleep(1);

$strTable =
'
                <div class="table-responsive">
                    <div  class="table">      
                        <table class="table table-bordered table-hover table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th>
                                    <th>Status</th>
                                    <th>Ent.</th>
                                    <th>Num.</th>
                                    <th>Grado</th>
                                    <th>Cat.</th>
                                    <th>Fecha</th>
                                    <th>Torneo</th>
                                    <th>Accion</th>
                                    <th>Firmas <br> Pago</th>
                                    <th>Lista de <br>Retiros
                                    <br>Inscritos
                                    <br>Confirmados</th>
                                    <th>Fsheet</th>
                                    <th>Lista <br> Aceptacion</th>
                                    <th>Draw Sin</th>
                                    <th>Draw Dob</th>
                                    <th>Puntos</th>
                                    <!--<th>Galeria</th>-->
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>';
                            echo   $strTable ;
                           
                            
                                // Buscamos los torneos vigentes
                                $objTorneo = new Torneo();
                                $rsColeccion_Torneos=$objTorneo->ReadAll($empresa_id,FALSE,$mes,'A',$entidad);
                                foreach ($rsColeccion_Torneos as $row) {
                                    $hash_key= urlencode(Encrypter::encrypt($row['torneo_id']));
                                    $hash_codigo= urlencode(Encrypter::encrypt($row['codigo']));
                                    if (Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) <= Fecha_Hoy() && Fecha_Create($row['fechacierre']) > Fecha_Hoy()) {

                                            $estatus="Open";
                                    } else {
                                        if (Fecha_Apertura_Calendario($row['fechacierre'],$row['tipo']) > Fecha_Hoy()) {

                                            $estatus="Next";
                                        } else {
                                            //Aqui mantenemos la fecha entre dos intervalos para el running
                                            //Cuando comienza y terminael torneo
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
                                    if ($row['estatus']!='A'){
                                        $estatus="Disabled";   
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
                                    
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-hourglass"></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                            break;
                                        
                                        case 'Closed':
                                            echo '<tr class=" " >';
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-ban-circle "></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                       
                                            break;
                                        case 'Next':
                                            echo '<tr class=" " >';
                                            echo '<td ><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-eye-open"></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                       
                                            break;
                                        case 'Running':
                                            echo '<tr class="warning " >';
                                            //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                            echo '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                            echo '<td>'.$estatus.'</td>';
                                            break;
                                        case 'Disabled':
                                            echo '<tr class="danger"  >  ';
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-ban-circle "></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                       
                                            break;
                                        case 'Suspendido':
                                            echo '<tr class="danger " >';
                                            //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-flag "></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                   
                                            break;
                                         case 'Diferido':
                                            echo '<tr class="info " >';
                                            //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-flag "></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                   
                                            break;
                                         case 'Cancelado':
                                            echo '<tr class="danger " >';
                                            //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                                            echo '<td><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-flag "></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                   
                                            break;
                                        
                                        default:
                                            echo '<tr class=" " >';
                                            echo '<td ><a target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'" class=" glyphicon glyphicon-remove"></a></td>';
                                            echo '<td><a  target="_blank" href="bsTorneo_Update.php?tid='.$row['torneo_id'].'"</a>'.$estatus.'</td>';
                                       
                                            break;
                                    }

                                    echo '<td >'. $row['entidad'].'</td>';
                                    echo '<td >'. $row['numero'].'</td>';
                                     echo '<td >'. $row['tipo'].'</td>';
                                    echo '<td>'. $row['categoria'].'</td>';
//                                    echo '<td data-toggle="tooltip" title="'.$row['fecha_inicio_torneo'].'">'. fecha_date_dmYYYY($row['fecha_inicio_torneo']).'</td>';
//                                    echo '<td data-toggle="tooltip" title="'.$row['fechacierre'].'">'. $row['fechacierre'].'</td>';
//                                    echo '<td data-toggle="tooltip" title="'.$row['fecharetiros'].'">'. $row['fecharetiros'].'</td>';
//                                  
                                    echo '<td>';
                                    echo '<p data-toggle="tooltip" title="Inicio">Inicio: '.$row['fecha_inicio_torneo'].'</p>';
                                    echo '<p data-toggle="tooltip" title="Cierre">Cierre: '. $row['fechacierre'].'</p>';
                                    echo '<p data-toggle="tooltip" title="Retiro">Retiro: '. $row['fecharetiros'].'</p>';
                                    echo '</td>';             
                                    
                                    echo '<td>'. $row['nombre'].'</td>';
                                    if ($empresa_id==$row['empresa_id'] || $empresa_id==0){
                                    echo '<td>'
                                        . '<a href="bsTorneo_Update.php" target="_blank" data-id="'.$row['torneo_id'].'" class="update-record glyphicon glyphicon-edit">Editar</a></br>'
                                        . '<a href="#" target="_blank" data-id="'.$row['torneo_id'].'" class="delete-record glyphicon glyphicon-trash">Borrar</a>'
                                        . '</td>';
                                    }else{
                                       echo '<td><a  target="_blank" href="bsTorneo_Subir_Draw.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-edit">Editar</a></br>'
                                       . '</td>';
                                     
                                    }    
                                    echo '<td><a target="_blank" href="bsTorneos_Pago_Atletas_Inscritos.php?t='.$row['codigo'].'" class="glyphicon glyphicon-usd"></a></td>';
                                   
                                    echo '<td><a target="_blank" href="AdminTorneosConsultaAtletasInscritos.php?t='.
                                    $row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                    /*echo '<td><a target="_blank" href="AdminTorneosConsultaAtletasInscritos.php?t='.
                                            $row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                    echo '<td><a target="_blank" href="AdminTorneosConsultaAtletasInscritos.php?t='.
                                           $row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                    */
                                    echo '<td><a href="Download_Doc.php?thatid='.$hash_key.'&thatdoc='.urlencode(Encrypter::encrypt("fs")).'" target="_blank" class="glyphicon glyphicon-calendar">  </a></td>';
                                    
                                    echo '<td><a href="Download_Doc.php?thatid='.$hash_key.'&thatdoc='.urlencode(Encrypter::encrypt("la")).'" target="_blank" class="glyphicon glyphicon-list-alt">  </a></td>';
                                    echo '<td><a href="Download_Doc.php?thatid='.$hash_key.'&thatdoc='.urlencode(Encrypter::encrypt("ds")).'" target="_blank" class="glyphicon glyphicon-indent-left">  </a></td>';
                                    echo '<td><a href="Download_Doc.php?thatid='.$hash_key.'&thatdoc='.urlencode(Encrypter::encrypt("dd")).'" target="_blank" class="glyphicon glyphicon-indent-left">  </a></td>';
                                    echo '<td><a href="bstorneo_puntuacion_menu_categorias.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
//                                    echo '<td><a target="" href="../SubirFotosGalerias/index.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-picture"></a></td>';
//                                    
                                   
                                    echo '</tr>';
                        
                                }
                           
$strTable=
                        '</tbody>    
                        </table>
                    </div>
                </div>';

echo $strTable;
