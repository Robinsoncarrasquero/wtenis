<?php
//header('Content-Type: text/html; charset=ISO-8859-1');
//header('Content-Type: text/html; charset=utf-8');
//Pograma para buscar una cedula y devolver un on objeto json con los datos basicos
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Atleta_cls.php';
require_once '../funciones/funciones.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneos_cls.php';
require_once "../clases/Torneo_Categoria_cls.php";
require_once '../clases/Bootstrap2_cls.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $opcion = trim(htmlspecialchars($_POST["opcion"]));
    //$opcion ="actividad";
    //Obtenemos los datos de los input
    if ($opcion=="perfil"){
        $cedula = trim(htmlspecialchars($_POST["cedula"]));

        $objAtleta = new Atleta();
        $objAtleta->Fetch(0, $cedula);
        $nombre = $objAtleta->getNombres();
        $apellido=$objAtleta->getApellidos();
        $atleta_id= $objAtleta->getID();

        //Guardamos los datos en un array
        $datos = array(
        'estado' => 'ok',
        'nombre' => $nombre, 
        'apellido' => $apellido, 
        'cedula' => $cedula,
        'atleta_id' => $atleta_id,
        'sexo' => $objAtleta->getSexo(),
        'fechan' => $objAtleta->getFechaNacimiento(),
        );
    }
    
    //Obtenemos los datos de los input
    if ($opcion=="actividad"){
        //$cedula = "28472989";
        $cedula = trim(htmlspecialchars($_POST["cedula"]));
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
        
       
        foreach ($rsHistorico as $dataRow){
            
            $rsH2H = Torneo_Draw::Historico($atleta_id,$dataRow['categoria_id']);
            //Buscamos la categoria_id del torneo
            $objCategoria = new Torneo_Categoria(0,' ',' ');
            $objCategoria->Find($dataRow['categoria_id']);
            
            $objTorneo = new Torneo();
            $objTorneo->Fetch($objCategoria->getTorneo_id());
            $strTorneo=' <div class="form-group col-md-6">
                    <!--<label for="torneo">Torneo:'.$objTorneo->getNombre().'</label><br>
                    <label for="grado">Grado:'.$objTorneo->getTipo().'</label><br>
                    <label for="grado">Fecha Inicio:'.$objTorneo->getFechaInicioTorneo().'</label> <br>
                    <label for="grado">Fecha Final :'.$objTorneo->getFechaFinTorneo().'</label>-->
                    
                    <p class="help-block">Torneo:'.$objTorneo->getNombre().'</p>
                    <p class="help-block">Grado:'.$objTorneo->getTipo().'</p>
                    <p class="help-block">Fecha Inicio:'.$objTorneo->getFechaInicioTorneo().'</p>
                    <p class="help-block">Fecha Final :'.$objTorneo->getFechaFinTorneo().'</p>'
                    
                .'</div>';
            $keytorneo=$objCategoria->getTorneo_id()."-".$objCategoria->getCategoria()."-".$objCategoria->getSexo();
            $nrt='<a  href="../Draw/Torneo_Draw_Draw.php?tid='.$keytorneo.'"</a>'.$objTorneo->getNombre();
            $link_draw='<a  href="../Draw/Torneo_Draw_Draw.php?tid='.$keytorneo.'" class="glyphicon glyphicon-list-alt"</a>';
            $thead=array(1=>"Torneo",2=>"Draw",3=>"Grado",4=>"Fecha Inicio",5=>"Fecha Final");
            $tableTorneo=  Bootstrap::Table_Head($thead, 0, FALSE, FALSE, TRUE,"alert alert-danger");
            $tableTorneo .=  Bootstrap::Table_Detail($nrt);
            $tableTorneo .=  Bootstrap::Table_Detail($link_draw);
            $tableTorneo .=  Bootstrap::Table_Detail($objTorneo->getTipo());
            $tableTorneo .=  Bootstrap::Table_Detail($objTorneo->getFechaInicioTorneo());
            $tableTorneo .=  Bootstrap::Table_Detail($objTorneo->getFechaFinTorneo());
            $tableTorneo .=  Bootstrap::Table_Footer();
            
            
            $thead=array(1=>"Round",2=>"Single",3=>"VS",4=>"Score");
            $tableRes =  Bootstrap::Table_Head($thead, 0, TRUE, TRUE, TRUE,"alert alert-info");
            
            foreach ($rsH2H as $record){
                //Buscamos el juego anterior para ubicar su contrincante y el resultado
                $objDraw1 = new Torneo_Draw();
                $objDraw1->Fetch($record['id']);

                //Buscamos el contrincante del juego para obtener el resultado
                $objDraw2 = new Torneo_Draw();
                $objDraw2->FindContrincante($objDraw1->getCategoria_id(),$objDraw1->getRonda(), $objDraw1->getPosicion());
                if ($objDraw2->getJugador()==0){
                    $vsNombre = $objDraw1->getStatus();
                    $href='';
                }else{
                    $objAtletavs = new Atleta();
                    $objAtletavs->Find($objDraw2->getJugador());
                    $vsNombre = $objAtletavs->getNombreCorto();
                    $href="BioPlayerMenu.php?id=".$objAtletavs->getID();

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
                
                //var_dump($linea);
                $tableRes .=  Bootstrap::Table_Detail_tr_open();
                $tableRes .=  Bootstrap::Table_Detail($nombrederonda);
                $tableRes .=  Bootstrap::Table_Detail($win);
                $tableRes .=  Bootstrap::Table_Detail($vsNombre,"",$href);
                $tableRes .=  Bootstrap::Table_Detail($score);
                $tableRes .=  Bootstrap::Table_Detail_tr_close();
         
            }
            $tableRes .=  Bootstrap::Table_Footer();
           
            $strHTML .= $tableTorneo . $tableRes;
           
           
        }
       
        
        //Guardamos los datos en un array
        $datos = array(
        'estado' => 'ok',
        'html' => $strHTML, 
        
        );
       
    }
    //Seteamos el header de "content-type" como "JSON" para que jQuery lo reconozca como tal
    
    header('Content-Type: application/json');
    //Devolvemos el array pasado a JSON como objeto
    echo json_encode($datos, JSON_FORCE_OBJECT);
    
}





?>



