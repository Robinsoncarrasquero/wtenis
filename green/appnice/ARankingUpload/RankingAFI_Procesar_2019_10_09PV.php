<?php
session_start();
require_once '../clases/Rank_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Ranking_detalle_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../PHPExcel/Classes/PHPExcel.php';
//Programa para procesar los archivo s ranking subidos
die();
//sleep(1);
//print_r('PROCESANDO :');
//$_GET['d'];
$fecha_desde=$_GET['fdesde'];
$fecha_hasta=$_GET['fhasta'];
//$RRank= Rank::ReadAll();
$mySelect =  " SELECT fecha,sexo,filename,categoria  FROM rank WHERE categoria ='PV' && fecha>='$fecha_desde' && fecha<='$fecha_hasta'";
//var_dump($mySelect);     
///$mySelect .=($sql_order==NULL) ? ";" : $sql_order;
$model = new Conexion;
$conn=$model->conectar();
$SQL = $conn->prepare($mySelect);
$SQL->execute();
$RRank = $SQL->fetchAll();

// foreach ($RRank as $row) {
//     # code...
//     if ($row['categoria']=='PV'){ 
        
//             print_r($row['filename']); 
//             print_r('<br>');    
            
//     }
    
// }
echo '</br>';
$zdata=[];  
foreach ($RRank as $row) {
    # code...
    if ($row['categoria']=='PV'){ 
        print_r($row['filename']); 
        echo '</br>';    
        procesar($row['fecha'],$row['sexo']);     
        $zdata .=['procesado'=>$row['filename']];   
    }
    
}
  //Generamos un json de respuesta
    if (count($zdata)>0){
        $jsondata = array("Success" => TRUE,"Mensaje"=>"Registros Procesados :".count($zdata)); 
    }else{
        $jsondata = array("Success" => FALSE,  "Mensaje"=>"No hay Registros Procesados");
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
  

function procesar($fecha,$sexo){
    $disciplina_Filtro='TDC';//$_GET['d']; 
    $fecha_rk_filtro= $fecha; //"2019-09-03";//$_GET['f']; 
    $categoria_Filtro='PV';//$_GET['c']; 
    $sexo_Filtro=$sexo;//'M'; 

    /*
    $disciplina_Filtro=$_POST['disciplina']; 
    $fecha_rk_filtro= $_POST['fecha_rk']; 
    $categoria_Filtro=$_POST['categoria']; 
    $sexo_Filtro=$_POST['sexo']; 
    */
    $rsFileRank=null;
    $rsFileRank= Rank::FileRanking($disciplina_Filtro,$categoria_Filtro,$fecha_rk_filtro,$sexo_Filtro);
    $jdata=array();
    foreach ($rsFileRank as $record) {
        $filename=($record['filename']);
    }
    
    //var_dump($filename);
    //Seleccionamos la disciplina y la categoria
    if ($disciplina_Filtro=='TDC'){
        switch ($categoria_Filtro) {
            case "PV":
                $jdata=rkpacpv($rsFileRank,$jdata);
                break;
            case "PN":
                rkpacpn($rsFileRank,$jdata);
                break;
            case "12":
            case "14":
            case "16":
            case "18":
            default:
                rkjunior($rsFileRank,$jdata);
                break;
        }
    }
    //Generamos un json de respuesta
    // if (count($jdata)>0){
    //     $jsondata = array("Success" => TRUE,"Mensaje"=>"Registros Procesados :".$jdata["registros"],'Procesado:'=>$filename); 
    // }else{
    //     $jsondata = array("Success" => FALSE,  "Mensaje"=>"No hay Registros Procesados");
    // }
    //header('Content-type: application/json; charset=utf-8');
    //echo json_encode($jsondata, JSON_FORCE_OBJECT);
    
    unset ($rsFileRank);
    unset($jdata); 
    return;
}


//Funcion para procesar Pelota a Colores(PN Y PV)
function rkpacpv($rsFileRank) {
            
    $jj=0;$datajj=0;
    foreach ($rsFileRank as $rk_record) {
        $disciplina=$rk_record['disciplina'];
        $categoria=$rk_record['categoria'];
        $file_excel=$rk_record['carpeta'].$rk_record['filename'];
        $sexo = $rk_record['sexo'];
        $files_procesar= array($file_excel);
        $fechark=$rk_record['fecha']; // FECHA DE RANKING
        $rank_id=$rk_record['id']; // FECHA DE RANKING
        if (file_exists($file_excel) )//&& !$rk_record['procesado'])
        {
            Ranking::DeleteCategoriaByRank_id($rank_id);
        }
        
        foreach ($files_procesar as $file_name){      
            if (file_exists($file_name))//  && !$rk_record['procesado'] )
            {
                         //Abrimos el libro en excel para procesar cada estado
                $sheet = NULL;$objPHPExcel=NULL;
                $inputFileType=NULL;$objReader=NULL;
                $inputFileType = PHPExcel_IOFactory::identify($file_name);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($file_name);
                $sheet = $objPHPExcel->getSheet(0);
                $jj++;
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $i = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowx=$row-1;
                    $rkn = trim($sheet->getCell("B" . $row)->getValue());
                    $rkr = $sheet->getCell("E" . $row)->getValue();
                    $rke = $sheet->getCell("F" . $row)->getValue();
                    $estado = $sheet->getCell("G" . $row)->getValue();
                    $cedula = $sheet->getCell("I" . $row)->getValue();
                    $arraynombre = explode(",",$sheet->getCell("J" . $rowx)->getValue());
    
                    $fechan = $sheet->getCell("O" . $rowx)->getValue();
                    $totpenal=$sheet->getCell("M" . $rowx)->getValue();
                    $array_data=[];
                    
                    //Internacionales
    //                RankingDetalle::ranking_detalle("IM",$sheet->getCell("CL" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("IMD",$sheet->getCell("CM" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("COSAT",$sheet->getCell("CQ" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("COTTEC",$sheet->getCell("CR" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("ITF",$sheet->getCell("CT" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("ATPWTA",$sheet->getCell("CV" . $row)->getValue(), $array_data);
    //                RankingDetalle::ranking_detalle("TPI",$sheet->getCell("CY" . $row)->getValue(), $array_data);
                    //G2 Nacionales
                    RankingDetalle::ranking_detalle("1G2S",$sheet->getCell("P" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G2D",$sheet->getCell("R" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2S",$sheet->getCell("T" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2D",$sheet->getCell("V" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2S",$sheet->getCell("W" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2D",$sheet->getCell("Y" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2S",$sheet->getCell("Z" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2D",$sheet->getCell("AB" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2S",$sheet->getCell("AD" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2D",$sheet->getCell("AE" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G2S",$sheet->getCell("AG" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G2D",$sheet->getCell("AH" . $rowx)->getValue(), $array_data);
                    
                    //G3
                    RankingDetalle::ranking_detalle("1G3S",$sheet->getCell("AI" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G3D",$sheet->getCell("AK" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3S",$sheet->getCell("AM" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3D",$sheet->getCell("AN" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3S",$sheet->getCell("AO" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3D",$sheet->getCell("AP" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3S",$sheet->getCell("AR" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3D",$sheet->getCell("AU" . $rowx)->getValue(), $array_data);
                    
                    
                    //G4
                    RankingDetalle::ranking_detalle("1G4S",$sheet->getCell("AW" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G4D",$sheet->getCell("AZ" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4S",$sheet->getCell("BB" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4D",$sheet->getCell("BD" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4S",$sheet->getCell("BF" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4D",$sheet->getCell("BG" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4S",$sheet->getCell("BH" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4D",$sheet->getCell("BK" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4S",$sheet->getCell("BN" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4D",$sheet->getCell("BQ" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4S",$sheet->getCell("BR" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4D",$sheet->getCell("BU" . $rowx)->getValue(), $array_data);
                    
                    //Nacional por equipo
                    RankingDetalle::ranking_detalle("NE",$sheet->getCell("BW" . $rowx)->getValue(), $array_data);
                    
                          
                    //Penalidad
                    RankingDetalle::ranking_detalle("PENA",$sheet->getCell("M" . $rowx)->getValue(), $array_data);
                   
                    RankingDetalle::ranking_detalle("TTS",$sheet->getCell("BY" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TTD",$sheet->getCell("CA" . $rowx)->getValue(), $array_data);

                    $TTP=implode("",explode(".",($sheet->getCell("CC" . $rowx)->getValue())));                
                    $TTPUNTOS = $TTP;

              
                    $regex = '#^[a-z]*[0-9][a-z0-9]*$#i'; //Acepta numero y letras o solo numero pero no letras
                    if (preg_match($regex, $cedula)) {
                        $i++;
                        $ape = strtoupper($arraynombre[0]);
                        $nom = strtoupper($arraynombre[1]);
                        $fechanac = explode ('-', $fechan);

                        $ano=$fechanac[2];
                        $mes=$fechanac[1];
                        $dia=$fechanac[0];
                        $fecha_nac=$ano."-".$mes."-".$dia;
                        $fechan=trim($fecha_nac); /// fecha de nacimiento
                        //print_r($fecha_nac);
                        $ObjAtleta = new Atleta();
                        $ObjAtleta->Fetch(0, $cedula);
                        if ($ObjAtleta->Operacion_Exitosa()) {
                            // $atleta_id = $ObjAtleta->getID();
                            // $ObjAtleta->setFechaNacimiento($fechan);
                            // $ObjAtleta->setEstado($estado);
                            // $ObjAtleta->setSexo($sexo);
                            // $ObjAtleta->Update();

                        } else {
                            $ObjAtleta->setApellidos($ape);
                            $ObjAtleta->setNombres($nom);
                            $ObjAtleta->setCedula($cedula);
                            $ObjAtleta->setFechaNacimiento($fechan);
                            $ObjAtleta->setSexo($sexo);
                            $ObjAtleta->setEstado($estado);
                            $ObjAtleta->setNacionalidadID(1);
                            $ObjAtleta->create();
                            $atleta_id = $ObjAtleta->getID();

                        }

                        if ($ObjAtleta->getID()>0){
                            $objRanking = new Ranking();
                            $objRanking->setAtleta_id($ObjAtleta->getID());
                            $objRanking->setFechaRankingNacional($fechark);
                            $objRanking->setDisciplina($disciplina);
                            $objRanking->setCategoria($categoria);
                            $objRanking->setRank_id($rank_id);
                            $objRanking->setRknacional($rkn);
                            $objRanking->setRkregional($rkr);
                            $objRanking->setRkestadal($rke);
                            
                            $objRanking->setPuntos(($TTPUNTOS));
                            $objRanking->create();
                            
                            
                            $datajj++;
//                            $dataj = array("atleta_id"=>$atleta_id,"rk"=>$rkn); 
//                            array_push($jdata, $dataj);
                            //echo $i . "--" . $atleta_id . "--" . $cedula . "--" . $rkn ."--" . $rkr. "--" . $rke. "==" . $estado . "==" . $nom . "==" . $ape . "-" . $fechan."-"." PENAL ".$totpenal ."-"." Puntos ".$totpuntos."<br>";
                            foreach ($array_data as $codigo=>$puntos) {
                                $tpuntos = (intval($puntos));
                                if ($tpuntos>0){
                                    // echo $codigo . "=>" . $tpuntos . "<br>";
                                    $objRankingDetalle = new RankingDetalle();
                                    $objRankingDetalle->setCodigo($codigo);
                                    $objRankingDetalle->setDescripcion($codigo);
                                    $objRankingDetalle->setPuntos($tpuntos);
                                    $objRankingDetalle->setRanking_id($objRanking->ID());
                                    $objRankingDetalle->create();

                                    //echo "number:".$objRanking->ID()."Torneo:". $codigo . "=>" . $puntos . "<br>";
                                }

                            }
                        }
                    }
                    
                }
                $objRank = new Rank();
                $objRank->Find($rk_record['id']);
                if ($objRank->Operacion_Exitosa()){
                    $objRank->setProcesado(1);
                    $objRank->Update();
                }
//                print_r("<br>FIN DE FILE:".$file_name." <br>");
            }
        }
        //Actualizamos Ranking de los torneos de esa categoria
        TorneosInscritos::UpdateRankingByDate($disciplina,$fechark,$categoria,$sexo);
    }
    $sheet = NULL;$objPHPExcel=NULL;
    $inputFileType=NULL;$objReader=NULL;
    $sheet = null;
                
    return array("registros"=>$datajj);
    
}