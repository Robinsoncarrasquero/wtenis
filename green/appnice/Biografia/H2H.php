<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//header('Content-Type: text/html; charset=utf-8');
//Pograma para buscar una cedula y devolver un on objeto json con los datos basicos
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../funciones/funciones.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneos_cls.php';
require_once "../clases/Torneo_Categoria_cls.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //$opcion = trim(htmlspecialchars($_POST["opcion"]));
    $opcion ="actividad";
    //Obtenemos los datos de los input
    
    //Obtenemos los datos de los input
    if ($opcion=="actividad"){
        //$cedula = "28472989";
        $cedula = trim($_POST["cedula"]);
        $objAtleta = new Atleta();
        $objAtleta->Fetch(0, $cedula);
//        $atleta_id =801;
//        $objAtleta = new Atleta();
//        $objAtleta->Fetch($atleta_id,0);
        $nombre = $objAtleta->getNombres();
        $apellido=$objAtleta->getApellidos();
        $atleta_id= $objAtleta->getID();
        $cedula=$objAtleta->getCedula();
        
        $rsHistorico = Torneo_Draw::AcividadDistinct($atleta_id);
        $html='<meta charset="utf-8" >';
        $head='<div class="table-responsive" >
                    <div  class="table">      
                        <table class="table table-striped table-bordered table-condensed">
                            <thead >
                                <tr class="table-head ">
                                    <th>Ronda</th>
                                    <th>Resultado</th>
                                    <th>VS</th>
                                   
                                    <th>Score</th>
                                                                     
                                </tr>
                            </thead>
                            <tbody>';
        $detail='';
        $foot .='</tbody>    
                        </table>
                    </div>
                </div>
        </div>';
        
        
        //Guardamos los datos en un array
        $datos = array(
        'estado' => 'ok',
        'html' => $strHTML, 
            );
        foreach ($rsHistorico as $dataRow){
            
            $rsH2H = Torneo_Draw::Historico($atleta_id,$dataRow['categoria_id']);
            //Buscamos la categoria_id del torneo
            $objCategoria = new Torneo_Categoria(0,' ',' ');
            $objCategoria->Find($dataRow['categoria_id']);
            
            $objTorneo = new Torneo();
            $objTorneo->Fetch($objCategoria->getTorneo_id());
            $strTorneo=' <div class="form-group col-xs-6 col-md-4">
                    <!--<label for="torneo">Torneo:'.$objTorneo->getNombre().'</label><br>
                    <label for="grado">Grado:'.$objTorneo->getTipo().'</label><br>
                    <label for="grado">Fecha Inicio:'.$objTorneo->getFechaInicioTorneo().'</label> <br>
                    <label for="grado">Fecha Final :'.$objTorneo->getFechaFinTorneo().'</label>-->
                    
                    <p class="help-block">Torneo:'.$objTorneo->getNombre().'</p>
                    <p class="help-block">Grado:'.$objTorneo->getTipo().'</p>
                    <p class="help-block">Fecha Inicio:'.$objTorneo->getFechaInicioTorneo().'</p>
                    <p class="help-block">Fecha Final :'.$objTorneo->getFechaFinTorneo().'</p>'
                    
                .'</div>';
            
            foreach ($rsH2H as $record){
                //Buscamos el juego anterior para ubicar su contrincante y el resultado
                $objDraw1 = new Torneo_Draw();
                $objDraw1->Fetch($record['id']);

                //Buscamos el contrincante del juego para obtener el resultado
                $objDraw2 = new Torneo_Draw();
                $objDraw2->FindContrincante($objDraw1->getCategoria_id(),$objDraw1->getRonda(), $objDraw1->getPosicion());
                if ($objDraw2->getJugador()==0){
                    $vsNombre = $objDraw1->getStatus();

                }else{
                    $objAtletavs = new Atleta();
                    $objAtletavs->Find($objDraw2->getJugador());
                    $vsNombre = $objAtletavs->getNombreCorto();

                }
//                var_dump($objDraw2);
//                var_dump($objDraw1);

                
               
                $objDraww = $objDraw1;
                $objDrawl = $objDraw2;
                $score = '';
                if ($objDraww->getStatus() != "JU" && $objDraww->getStatus() != NULL) {
                    $score = $objDraww->getStatus();
                } else {
                    if ($objDraww->getS1() + $objDrawl->getS1() > 0) {
                        if ($objDraww->getT1() + $objDrawl->getT1() > 7) {
                            $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1();
                            $score .= "[" . (($objDraww->getT1() > $objDrawl->getT1()) ? $objDrawl->getT1() : $objDraww->getT1()) . "]";
                        } else {
                            $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1() . " ";
                        }
                    }
                    if ($objDraww->getS2() + $objDrawl->getS2() > 0) {
                        if ($objDraww->getT2() + $objDrawl->getT2() > 7) {
                            $score .=" " . $objDraww->getS2() . "-" . $objDrawl->getS2();
                            $score .="[" . (($objDraww->getT2() > $objDrawl->getT2()) ? $objDrawl->getT2() : $objDraww->getT2()) . "]";
                        } else {
                            $score .= " " . $objDraww->getS2() . "-" . $objDrawl->getS2() . " ";
                        }
                    }
                    if ($objDraww->getS3() + $objDrawl->getS3() > 0) {
                        if ($objDraww->getT3() + $objDrawl->getT3() > 7) {
                            $score .=" " . $objDraww->getS3() . "-" . $objDrawl->getS3();
                            $score .="[" . (($objDraww->getT3() > $objDrawl->getT3()) ? $objDrawl->getT3() : $objDraww->getT3()) . "]";
                        } else {
                            $score .= " " . $objDraww->getS3() . "-" . $objDrawl->getS3() . " ";
                        }
                    }
                }

                $win = $record['win']==1 ? "W" : "L";
                if ($score=='BYE'){
                    $win='-';
                }
                $nombrederonda=  Reglas_Juego::NombredeRonda($record['ronda']);
                $linea="<tr>";

                $linea .="<td>".$nombrederonda."</td>";
                $linea .="<td>".$win."</td>";
                //$vsNombre="alguine";
                $linea .="<td>".$vsNombre."</td>";
                
                $linea .="<td>".$score."</td>";

                $linea .="</tr>";
                $detail .=$linea;
                //var_dump($linea);



            }
            $strHTML .=$strTorneo.$head.$detail.$foot;
            //$strHTML .=$strHTML;
        }
       
        
        //Guardamos los datos en un array
        $datos = array(
        'estado' => 'ok',
        'html' => $strHTML, 
        
        );
        echo $strHTML;
    }
    //Seteamos el header de "content-type" como "JSON" para que jQuery lo reconozca como tal
    
//    header('Content-Type: application/json');
//    //Devolvemos el array pasado a JSON como objeto
//    echo json_encode($datos, JSON_FORCE_OBJECT);
    
}





?>



