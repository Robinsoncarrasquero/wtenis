<?php



require_once 'clases/Atletas_cls.php';

require_once 'sql/ConexionPDO.php';




$strTable =
'<section class="table-atletas ">
                <div class="table-responsive">
                    <div  class="table">      
                        <table class="table table-bordered table-hover table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th
                                    <th>Pos</th>
                                    <th>Nombre</th>
                                    <th>Apellidos.</th>
                                    <th>Estado</th>
                                    <th>Puntos</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>';
                            echo   $strTable ;
                           
                            
                                // Buscamos los torneos vigentes
                                $objTorneo = new Atleta();
                                $rsColeccion_Torneos=$objTorneo->ReadAll("MIR");
                                foreach ($rsColeccion_Torneos as $row) {
                                    
                                    $I++;
                                    echo '<tr class="success"  >  ';
                                                                  
                                    $puntos=0;  
                                    echo '<td >'. $I.'</td>';
                                    echo '<td >'. $row['nombres'].'</td>';
                                    echo '<td >'. $row['apellidos'].'</td>';
                                    echo '<td>'. $row['estado'].'</td>';
                                   
                                    echo '<td>'. $puntos.'</td>';
                                    
                                    echo '</tr>';
                        
                                }
                           
$strTable=
                        '</tbody>    
                        </table>
                    </div>
                </div>';

echo $strTable;