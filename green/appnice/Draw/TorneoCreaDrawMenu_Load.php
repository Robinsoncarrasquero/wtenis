<?php

session_start();

require_once '../clases/Noticias_cls.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';

$empresa_id =$_SESSION['empresa_id'];
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
                                    <th>Modal.</th>
                                    <th>Grado</th>
                                    <th>Categoria</th>
                                    <th>Inicio</th>
                                   
                                    <th>Cierre</th>
                                    <th>Retiros</th>
                                    <th>Torneo</th>
                                                                     
                                    <th>Fsheet</th>
                                    <th>Lista</th>
                                    <th>Qualy</th>
                                    <th>Singles</th>
                                    <th>Dobles</th>
                                    
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>';
                            echo   $strTable ;
                           
                            
                                // Buscamos los torneos vigentes
                                $objTorneo = new Torneo();
                                $rsColeccion_Torneos=$objTorneo->ReadAll($empresa_id,TRUE,$mes,'Todos');
                                foreach ($rsColeccion_Torneos as $row) {
                                    
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
                                        $estatus="Deshabilitado";   
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

                                    echo '<td >'. $row['modalidad'].'</td>';
                                    echo '<td >'. $row['tipo'].'</td>';
                                    echo '<td>'. $row['categoria'].'</td>';
                                    echo '<td data-toggle="tooltip" title="'.$row['fecha_inicio_torneo'].'">'. fecha_date_dmYYYY($row['fecha_inicio_torneo']).'</td>';
                                    echo '<td data-toggle="tooltip" title="'.$row['fechacierre'].'">'. $row['fechacierre'].'</td>';
                                    echo '<td data-toggle="tooltip" title="'.$row['fecharetiros'].'">'. $row['fecharetiros'].'</td>';
                                 
                                    echo '<td>'. $row['codigo'].'</td>';
                                    
                                    
                                           
                                   
                                    echo '<td><a href="../bsDescargar_PDF.php?id='.$row['torneo_id'].'&doc=fsheet "'.' target="_blank" class="glyphicon glyphicon-calendar">  </a></td>';
                                    echo '<td><a target="" href="TorneoListaAceptacionMenuCategorias.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                
                                    echo '<td><a target="" href="TorneoCreaDrawMenuCategorias.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                
                                    echo '<td><a target="" href="TorneoCreaDrawMenuCategorias.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                    echo '<td><a target="" href="TorneoCreaDrawMenuCategorias.php?tid='.$row['torneo_id'].'" class="glyphicon glyphicon-list-alt"></a></td>';
                                   
                                    echo '</tr>';
                        
                                }
                           
$strTable=
                        '</tbody>    
                        </table>
                    </div>
                </div>';

echo $strTable;
