<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneo_Lista_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Torneo_Categoria_cls.php';

if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
   header('Location: ../sesion_inicio.php');
   exit;
}

//Recibimos el torneo donde se va a generar el draw y generar el listado de jugadores
$torneo_id =$_POST['tid'];
$categoria =$_POST['categoria'];
$sexo =$_POST['sexo'];

//Ubicamos la categoria para luego traer los datos 
//de la lista para obtener la categoria_id que relaciona con lista y draw
$objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
$objCategoria->Fetch($torneo_id, $categoria, $sexo);
$categoria_id=$objCategoria->get_id(); 

$nrojugadores = Torneo_Lista::Count_Jugadores($categoria_id);
//Clave compuesta de torneo para manejar id en javascript
//compuesta por torneo, categoria, sexo y ronda
$key=$torneo_id."-".$categoria."-".$sexo."-".$nrojugadores; 

$strTable =
'<div>
                <div class="table-responsive" >
                    <div  class="table">      
                        <table class="table table-bordered table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th>Lista</th>
                                    <th>RK</th>
                                    
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Fecha Nac.</th>
                                    <th>Entidad</th>
                                    <th>Draw</th>
                                   
                                </tr>
                            </thead>
                            <tbody>';

                           
                            $nr=0;
                            // Buscamos los torneos vigentes

                            $objLista = new Torneo_Lista();
                            //Buscamos la lista de jugadores para generar el draw
                            $rsdata = $objLista->ReadAll($categoria_id);
                             
                            foreach ($rsdata as $row) {
                               
                                $atleta_id=$row['jugador'];
                                $nr ++;
                                $objAtleta = new Atleta();
                                $objAtleta->Find($atleta_id);
                                if ($row['posiciondraw']>0){
                                    $posicion=$row['posiciondraw'];
                                }else{
                                    $posicion=$row['posicion'];
                                }
                               
                                
                                $strTable .= '<tr>';  
                                $strTable .= '<td >'. $row['posicion'].'</td>';
                                //$strTable .= '<td >'. $row['rk'].'</td>';
                                if ($objCategoria->getPublicar()!=1){
                                    $strTable .= '<td> '. Reglas_Juego::select_posicion_rk($row['jugador'],$row['rk'],'enabled'). '</td>';
                                }else{
                                    $strTable .= '<td> '. $row['rk']. '</td>';
                     
                                    
                                }
                                $strTable .= '<td >'. $objAtleta->getCedula().'</td>';
                                $strTable .= '<td >'. $objAtleta->getNombres().'</td>';
                                $strTable .= '<td >'. $objAtleta->getApellidos().'</td>';
                                $strTable .= '<td >'. $objAtleta->getFechaNacimiento().'</td>';
                                $strTable .= '<td >'. $objAtleta->getEstado().'</td>';
                                if ($objCategoria->getPublicar()!=1){
                                    $strTable .= '<td> '. Reglas_Juego::select_posicion_lista($nrojugadores,$row['jugador'],$posicion,'enabled'). '</td>';
                                }else{
                                    $strTable .= '<td> '.$posicion. '</td>';
                           
                                    
                                }
                                //$strTable .= '<td> '. Reglas_Juego::select_posicion_lista($nrojugadores,$row['posicion'],$posicion,'enabled'). '</td>';

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
       
    

