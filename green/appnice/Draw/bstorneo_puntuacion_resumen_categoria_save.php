<?php

session_start();

require_once '../clases/Atleta_cls.php';
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funciones.php';

require_once '../sql/ConexionPDO.php';
if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}


$key_id =explode("-",  htmlspecialchars($_POST['tid'])); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo
$datastr= json_decode($_POST['datajson'],true); // Categoria

//var_dump($datastr);
//die('AQUI');
//$datos=  explode(',', $datastr);

//sleep(1);


 
// Buscamos los torneos vigentes

$array = $datastr;
for ($x=0 ; $x < count($array); $x++){
    
    $tid=$array[$x]["id"];
    $singles = $array[$x]["singles"];
    $dobles = $array[$x]["dobles"];
    $penalidad = $array[$x]["penalidad"];
    
    $objTorneo = new TorneosInscritos();
    $objTorneo->Fetch($tid);
    //var_dump($objTorneo->getMensaje());
    if ($objTorneo->Operacion_Exitosa()){
        $objTorneo->setSingles($singles);
        $objTorneo->setDobles($dobles);
        $objTorneo->setPenalidad($penalidad);
        $objTorneo->Update();
       //var_dump($objTorneo->getMensaje());

    }
    
}

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
                            echo   $strTable ;
                           
                                $nr=0;
                                // Buscamos los torneos vigentes
                                $objTorneos = new TorneosInscritos();
                                $rsColeccion_Torneos=$objTorneos->Read_Puntos($torneo_id, 0, $categoria,$sexo);
                                
                                 
                                foreach ($rsColeccion_Torneos as $row) {
                                    
                                    
                                   
                                    if ($row['pagado']>0){
                                        $nr ++;
                                        echo '<tr>';  
                                        echo '<td >'. $nr.'</td>';
                                        echo '<td >'. $row['cedula'].'</td>';
                                        echo '<td >'. $row['nombres'].'</td>';
                                        echo '<td >'. $row['apellidos'].'</td>';
                                        echo '<td >'. $row['sexo'].'</td>';
                                        echo '<td >'. $row['fecha_nacimiento'].'</td>';
                                        echo '<td >'. $row['categoria'].'</td>';
                                        echo '<td >'. $row['estado'].'</td>';
                                        echo '<td> '. select_tabla_puntos($row['torneoinscrito_id'],$row['singles'],'enabled'). '</td>';
                                        echo '<td> '. select_tabla_puntos($row['torneoinscrito_id'],$row['dobles'],'enabled'). '</td>';
                                        echo '<td> '. select_tabla_penalidad($row['torneoinscrito_id'],$row['penalidad'],'enabled'). '</td>';
                                        
                                        echo '</tr>';
                        
                                    }
                                }
                           
$strTable=
                        '</tbody>    
                        </table>
                    </div>
                </div>
        </div>';
echo $strTable;
