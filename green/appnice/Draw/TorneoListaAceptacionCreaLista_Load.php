<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Grado_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';

if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
   header('Location: ../sesion_inicio.php');
   exit;
}

//Recibimos el torneo donde se va a generar el draw y generar el listado de jugadores
$torneo_id =$_POST['tid'];
$categoria =$_POST['categoria'];
$sexo =$_POST['sexo'];

$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
$grado=$objTorneo->getTipo();
//$grado="G1";

$objGrado = new Grado();
$objGrado->Fetch($grado);

$strTable =
'<div>
                <div class="table-responsive" >
                    <div  class="table">      
                        <table class="table table-bordered table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th>Posicion</th>
                                    <th>Cedula</th>
                                    <th>Apellidos</th>
                                    <th>Nombre</th>
                                    <th>Entidad</th>
                                    <th>Ranking</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead>
                            <tbody>';

                           
                            $nr=0;
                            // Buscamos los el grado del torneo
                            $objGrado = new Grado();
                            $objGrado->Fetch($grado);
                            
                            $maindraw = $objGrado->getMainDraw() - $objGrado->getMainDrawQualy();
                            $qualy=$objGrado->getMainDrawQualy()*4;
                            $topeQLY = $objGrado->getMainDraw() - $objGrado->getMainDrawQualy() - $objGrado->getMainDrawWildCard() ;
                            //Buscamos la lista de jugadores para generar el draw
                            $rsdata=  TorneosInscritos::ListaAceptacion($torneo_id, $categoria,$sexo);
                            
                            foreach ($rsdata as $row) {
                               
                                $atleta_id=$row['atleta_id'];
                                $nr ++;
                                $rr=$nr;
                                $objAtleta = new Atleta();
                                $objAtleta->Find($atleta_id);
                                $status= $row['condicion']==0 ? 1 : $row['condicion']; 
                                
//                                                              
                                //Main draw y Maind draw WC 1,2
                                if ($status<=2 || $nr<=$maindraw && $objGrado->getMainDrawQualy()>0){
                                    $status= $row['condicion']==0 ? 1 : $row['condicion']; 
                                    $md += 1;
                                    $rr=$md;
                                }
//                              //Qualy 3 y QWC 4
                                $topeq=$maindraw+$objGrado->getQualy();
                                if ($status==3 || $status==4 || $nr>$maindraw && $nr<=$topeq && $objGrado->getMainDrawQualy()>0){
                                    $status= $row['condicion']==0 ? 3 : $row['condicion']; 
                                    $qly += 1;
                                    $rr=$qly;
                                }
                                 
                                //Alterno 5
                                if ($nr>$topeq || $status==5){
                                    $status= $row['condicion']==0 ? 5 : $row['condicion']; 
                                    $alt += 1;
                                    $rr=$alt;
                                }
                                if($status==6){
                                    $status= $row['condicion']==0 ? 6 : $row['condicion']; 
                                    $ret +=1;
                                    $rr=$ret;
                                }

                                
                                
                                
                               
                                
                                $strTable .= '<tr>';  
                                $strTable .= '<td >'. $rr.'</td>';
                               
                              
                              
                               $rk= $row['rknacional']==999 ? 0 : $row['rknacional'];
                                    
                               
                                $strTable .= '<td >'. $objAtleta->getCedula().'</td>';
                                $strTable .= '<td >'. $objAtleta->getNombres().'</td>';
                                $strTable .= '<td >'. $objAtleta->getApellidos().'</td>';
                                $strTable .= '<td >'. $objAtleta->getEstado().'</td>';
                                $strTable .= '<td> '. $rk. '</td>';
//                                if ($objCategoria->getPublicar()!=1){
//                                    $strTable .= '<td> '. Reglas_Juego::select_posicion_lista($nrojugadores,$row['atleta_id'],$posicion,'enabled'). '</td>';
//                                }else{
//                                    $strTable .= '<td> '.$posicion. '</td>';
//                                 }
                                //$strTable .= '<td> '.$status. '</td>';
                                $strTable .= '<td> '. Reglas_Juego::select_posicion_lista_aceptacion($atleta_id,$status,'enabled'). '</td>';

                                $strTable .= '</tr>';

                                
                            }
                           
$strTable .=
                        '</tbody>    
                        </table>
                    </div>
                </div>
        </div>';


    echo $strTable;


?>
       
    

