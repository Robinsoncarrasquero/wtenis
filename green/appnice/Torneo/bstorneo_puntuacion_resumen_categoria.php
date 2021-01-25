<?php

session_start();

require_once '../clases/Atleta_cls.php';
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funciones.php';
require_once '../sql/ConexionPDO.php';
require_once '../dompdf/autoload.inc.php';

if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<8){
    header('Location: sesion_usuario.php');
    exit;
}
// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
mb_http_output('UTF-8');  

$torneo_id =$_POST['tid']; 
$categoria=$_POST['catid']; // Categoria
$sexo=$_POST['sexo']; // Categoria

//sleep(1);


$strTable =
'<div>
                <div class="table-responsive">
                    <div  class="table">      
                        <table class="table table-bordered table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th>
                                    
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Sexo</th>
                                    <th>Fecha Nac.</th>
                                    <th>Categoria</th>
                                    <th>Estado</th>
                                    <th>Singles</th>
                                    <th>Dobles</th>
                                    <th>Penalidad</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>';

                           
                                $nr=0;
                                // Buscamos los torneos vigentes
                                
                                $rsColeccion_Torneos=  TorneosInscritos::Read_Puntos($torneo_id, 0, $categoria,$sexo);
                                
                                foreach ($rsColeccion_Torneos as $row) {
                                   //if ($row['pagado']>0){
                                   {     $nr ++;
                                        
                                        $strTable .= '<tr>';  
                                        $strTable .= '<td >'. $nr.'</td>';
                                        $strTable .= '<td >'. $row['cedula'].'</td>';
                                        $strTable .= '<td >'. $row['nombres'].'</td>';
                                        $strTable .= '<td >'. $row['apellidos'].'</td>';
                                        $strTable .= '<td >'. $row['sexo'].'</td>';
                                        $strTable .= '<td >'. $row['fecha_nacimiento'].'</td>';
                                        $strTable .= '<td >'. $row['categoria'].'</td>';
                                        $strTable .= '<td >'. $row['estado'].'</td>';
                                        $strTable .= '<td> '. select_tabla_puntos($row['torneoinscrito_id'],$row['singles'],'enabled'). '</td>';
                                        $strTable .= '<td> '. select_tabla_puntos($row['torneoinscrito_id'],$row['dobles'],'enabled'). '</td>';
                                        $strTable .= '<td> '. select_tabla_penalidad($row['torneoinscrito_id'],$row['penalidad'],'enabled'). '</td>';
                                        
                                        $strTable .= '</tr>';
                        
                                    }
                                }
                           
$strTable .=
                        '</tbody>    
                        </table>
                    </div>
                </div>
        </div>';

    echo $strTable;
       
    

