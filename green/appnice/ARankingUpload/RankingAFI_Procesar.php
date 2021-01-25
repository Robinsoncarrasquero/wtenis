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

//sleep(1);
//$disciplina_Filtro='TDC';//$_GET['d']; 
//$fecha_rk_filtro= "2019-06-22";//$_GET['f']; 
//$categoria_Filtro='12';//$_GET['c']; 
$disciplina_Filtro=$_POST['disciplina']; 
$fecha_rk_filtro= $_POST['fecha_rk']; 
$categoria_Filtro=$_POST['categoria']; 
$sexo_Filtro=$_POST['sexo']; 

$rsFileRank= Rank::FileRanking($disciplina_Filtro,$categoria_Filtro,$fecha_rk_filtro,$sexo_Filtro);
$jdata=array();

///var_dump($rsFileRank);
//Seleccionamos la disciplina y la categoria
if ($disciplina_Filtro=='TDC'){
    switch ($categoria_Filtro) {
        case "PV":
            rkpacpv($rsFileRank,$jdata);
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
if (count($jdata)>0){
    $jsondata = array("Success" => TRUE,"Mensaje"=>"Registros Procesados :".$jdata["registros"]); 
}else{
    $jsondata = array("Success" => FALSE,  "Mensaje"=>"No hay Registros Procesados");
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);


//Funcion para procesar el archivo de Junior
function rkjunior($rsFileRank,&$jdata){
    
   $jj=0;$datajj=0;
    foreach ($rsFileRank as $rk_record) {
        
        $categoria=$rk_record['categoria'];
        $disciplina=$rk_record['disciplina'];
        $file_excel=$rk_record['carpeta'].$rk_record['filename'];
        $sexo = $rk_record['sexo'];
        $files_procesar= array($file_excel);
        $fechark=$rk_record['fecha']; // FECHA DE RANKING
        $rank_id=$rk_record['id']; // FECHA DE RANKING
        if (!$rk_record['procesado']){
            Ranking::DeleteCategoriaByRank_id($rank_id);
        }
        
        foreach ($files_procesar as $file_name){      
            if (file_exists($file_name) && !$rk_record[procesado] ){
                

                //Abrimos el libro en excel para procesar cada estado
                $jj++;
                //$sheet = NULL;$objPHPExcel=NULL;
                //$inputFileType=NULL;$objReader=NULL;
                $inputFileType = PHPExcel_IOFactory::identify($file_name);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($file_name);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $i = 0;

                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowx=$row-1;
                    $rkn = trim($sheet->getCell("C" . $row)->getValue());
                    $rkr = $sheet->getCell("F" . $row)->getValue();
                    $rke = $sheet->getCell("G" . $row)->getValue();
                    $estado = $sheet->getCell("H" . $row)->getValue();
                    $cedula = $sheet->getCell("J" . $row)->getValue();
                    $arraynombre = explode(",",$sheet->getCell("K" . $rowx)->getValue());
                    $fechan = $sheet->getCell("Q" . $rowx)->getValue();
                    $totpenal=$sheet->getCell("N" . $rowx)->getValue();
                    $array_data=[];
                    
                    //Internacionales
                    RankingDetalle::ranking_detalle("COSAT",$sheet->getCell("DC" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("COTTEC",$sheet->getCell("DD" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1ITFN",$sheet->getCell("DG" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1ITFND",$sheet->getCell("DH" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2ITFN",$sheet->getCell("DI" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2ITFND",$sheet->getCell("DM" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("ITF",$sheet->getCell("DO" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("ATPWTA",$sheet->getCell("DQ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TPI",$sheet->getCell("DS" . $row)->getValue(), $array_data);
                    
                    //Nacionales
                    RankingDetalle::ranking_detalle("1G1S",$sheet->getCell("R" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G1D",$sheet->getCell("U" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G1S",$sheet->getCell("W" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G1D",$sheet->getCell("X" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G1S",$sheet->getCell("Z" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G1D",$sheet->getCell("AA" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G2S",$sheet->getCell("AB" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G2D",$sheet->getCell("AC" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2S",$sheet->getCell("AD" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2D",$sheet->getCell("AE" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2S",$sheet->getCell("AF" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2D",$sheet->getCell("AH" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2S",$sheet->getCell("AJ" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2D",$sheet->getCell("AM" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2S",$sheet->getCell("AO" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2D",$sheet->getCell("AR" . $rowx)->getValue(), $array_data);
                   
                    
                    //G2B NUEVA COLUMNA
                    RankingDetalle::ranking_detalle("1G2BS",$sheet->getCell("AT" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G2BD",$sheet->getCell("AV" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2BS",$sheet->getCell("AX" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2BD",$sheet->getCell("BA" . $rowx)->getValue(), $array_data);
                    
                    //G3
                    RankingDetalle::ranking_detalle("1G3S",$sheet->getCell("BC" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G3D",$sheet->getCell("BD" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3S",$sheet->getCell("BF" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3D",$sheet->getCell("BH" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3S",$sheet->getCell("BK" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3D",$sheet->getCell("BM" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3S",$sheet->getCell("BO" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3D",$sheet->getCell("BQ" . $row)->getValue(), $array_data);
                    
                   
                    //G4
                    RankingDetalle::ranking_detalle("1G4S",$sheet->getCell("BS" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G4D",$sheet->getCell("BT" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4S",$sheet->getCell("BU" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4D",$sheet->getCell("BV" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4S",$sheet->getCell("BW" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4D",$sheet->getCell("BX" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4S",$sheet->getCell("CA" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4D",$sheet->getCell("CC" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4S",$sheet->getCell("CE" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4D",$sheet->getCell("CF" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4S",$sheet->getCell("CH" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4D",$sheet->getCell("CJ" . $rowx)->getValue(), $array_data);
                    //
                    //G4B
                    RankingDetalle::ranking_detalle("1G4BS",$sheet->getCell("CL" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G4BD",$sheet->getCell("CM" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4BS",$sheet->getCell("CN" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4BD",$sheet->getCell("CO" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4BS",$sheet->getCell("CP" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4BD",$sheet->getCell("CQ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4BS",$sheet->getCell("CR" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4BD",$sheet->getCell("CT" . $rowx)->getValue(), $array_data);
                    
                    
                    //Master
                    RankingDetalle::ranking_detalle("IMS",$sheet->getCell("CV" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("IMD",$sheet->getCell("CW" . $row)->getValue(), $array_data);
                   
                    //otros
                    RankingDetalle::ranking_detalle("NE",$sheet->getCell("CZ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("IRS",$sheet->getCell("DA" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("IRD",$sheet->getCell("DB" . $row)->getValue(), $array_data);
                    
                    //Penalidad
                    RankingDetalle::ranking_detalle("PENA",$sheet->getCell("N" . $rowx)->getValue(), $array_data);
                    
                    //Totales
                    RankingDetalle::ranking_detalle("TMA",$sheet->getCell("DU" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TTS",$sheet->getCell("DW" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TTD",$sheet->getCell("DY" . $row)->getValue(), $array_data);
                    
                   
                    //$TTP=($sheet->getCell("DG" . $row)->getValue());
                    $TTP=implode("",explode(".",($sheet->getCell("EA" . $row)->getValue())));                
                    $TTPUNTOS = $TTP;


                    //echo $i . "--" . $atleta_id . "--" . $cedula . "--" . $rkn ."--" . $rkr. "--" . $rke. "==" . $estado . "==" . $nom . "==" . $ape . "-" . $fechan."-"." PENAL ".$totpenal ."-"." Puntos ".$totpuntos."<br>";

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

                        $ObjAtleta = new Atleta();
                        $ObjAtleta->Fetch(0, $cedula);
                        if ($ObjAtleta->Operacion_Exitosa()) {
                            $atleta_id = $ObjAtleta->getID();
                            //$ObjAtleta->setFechaNacimiento($fechan);
                            $ObjAtleta->setEstado($estado);
                            //$ObjAtleta->setSexo($sexo);
                            $ObjAtleta->Update();
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
                            $objRanking->setPuntos($TTPUNTOS);
                            $objRanking->setPenalidad(intval($totpenal));
                            $objRanking->create();
                            $datajj++;
//                            $dataj = array("atleta_id"=>$atleta_id,"rk"=>$rkn); 
//                            array_push($jdata, $dataj);
//                            //echo $i . "--" . $atleta_id . "--" . $cedula . "--" . $rkn ."--" . $rkr. "--" . $rke. "==" . $estado . "==" . $nom . "==" . $ape . "-" . $fechan."-"." PENAL ".$totpenal ."-"." Puntos ".$totpuntos."<br>";
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
                $objRank->Find($rank_id);
                if ($objRank->Operacion_Exitosa()){
                    $objRank->setProcesado(1);
                    $objRank->Update();
                }
                $objRank=NULL;
                //print_r("<br>FIN DE FILE:".$file_name." <br>");
                //print_r("<br>TIME:". date('H:i:s', time() - date('Z'))." <br>");
            }
        }
         
        //Actualizamos Ranking de los torneos de esa categoria
        TorneosInscritos::UpdateRankingByDate($disciplina,$fechark,$categoria,$sexo);
        
        
    }
    $jdata = array("registros"=>$datajj); 
    
    
    
    
    
}

//Funcion para procesar Pelota a Colores(PN Y PV)
function rkpacpv($rsFileRank,&$jdata) {
    $jj=0;$datajj=0;
    foreach ($rsFileRank as $rk_record) {
        $disciplina=$rk_record['disciplina'];
        $categoria=$rk_record['categoria'];
        $file_excel=$rk_record['carpeta'].$rk_record['filename'];
        $sexo = $rk_record['sexo'];
        $files_procesar= array($file_excel);
        $fechark=$rk_record['fecha']; // FECHA DE RANKING
        $rank_id=$rk_record['id']; // FECHA DE RANKING
        if (!$rk_record['procesado']){
            Ranking::DeleteCategoriaByRank_id($rank_id);
        }
        
        foreach ($files_procesar as $file_name){      
            if (file_exists($file_name) && !$rk_record[procesado] ){
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
                    RankingDetalle::ranking_detalle("1G3S",$sheet->getCell("AI" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G3D",$sheet->getCell("AK" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3S",$sheet->getCell("AM" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3D",$sheet->getCell("AN" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3S",$sheet->getCell("AO" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G3D",$sheet->getCell("AP" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3S",$sheet->getCell("AR" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G3D",$sheet->getCell("AU" . $row)->getValue(), $array_data);
                    
                    
                    //G4
                    RankingDetalle::ranking_detalle("1G4S",$sheet->getCell("AW" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G4D",$sheet->getCell("AZ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4S",$sheet->getCell("BB" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4D",$sheet->getCell("BD" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4S",$sheet->getCell("BF" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4D",$sheet->getCell("BG" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4S",$sheet->getCell("BH" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4D",$sheet->getCell("BK" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4S",$sheet->getCell("BN" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4D",$sheet->getCell("BQ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4S",$sheet->getCell("BR" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4D",$sheet->getCell("BU" . $rowx)->getValue(), $array_data);
                    
                    //Nacional por equipo
                    RankingDetalle::ranking_detalle("NE",$sheet->getCell("BW" . $row)->getValue(), $array_data);
                    
                    //Master
                    RankingDetalle::ranking_detalle("IMS",$sheet->getCell("BY" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("IMD",$sheet->getCell("BZ" . $rowx)->getValue(), $array_data);

                   
                    //Penalidad
                    RankingDetalle::ranking_detalle("PENA",$sheet->getCell("M" . $rowx)->getValue(), $array_data);
                   
                    RankingDetalle::ranking_detalle("TTS",$sheet->getCell("CA" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TTD",$sheet->getCell("CD" . $rowx)->getValue(), $array_data);

                    $TTP=implode("",explode(".",($sheet->getCell("CF" . $rowx)->getValue())));                
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
                            $atleta_id = $ObjAtleta->getID();
                            $ObjAtleta->setFechaNacimiento($fechan);
                            $ObjAtleta->setEstado($estado);
                            $ObjAtleta->setSexo($sexo);
                            $ObjAtleta->Update();

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
    $jdata = array("registros"=>$datajj); 
    
    
}
//Funcion para procesar Pelota a Colores(PN)
function rkpacpn($rsFileRank,&$jdata) {
    $jj=0;$datajj=0;
    foreach ($rsFileRank as $rk_record) {
        $disciplina=$rk_record['disciplina'];
        $categoria=$rk_record['categoria'];
        $file_excel=$rk_record['carpeta'].$rk_record['filename'];
        $sexo = $rk_record['sexo'];
        $files_procesar= array($file_excel);
        $fechark=$rk_record['fecha']; // FECHA DE RANKING
        $rank_id=$rk_record['id']; // FECHA DE RANKING
        if (!$rk_record['procesado']){
            Ranking::DeleteCategoriaByRank_id($rank_id);
        }
        
        foreach ($files_procesar as $file_name){      
            if (file_exists($file_name) && !$rk_record[procesado] ){
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
    
                    $fechan = $sheet->getCell("Q" . $rowx)->getValue();
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
                    RankingDetalle::ranking_detalle("1G2S",$sheet->getCell("R" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G2D",$sheet->getCell("T" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2S",$sheet->getCell("W" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G2D",$sheet->getCell("Z" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2S",$sheet->getCell("AD" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G2D",$sheet->getCell("AF" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2S",$sheet->getCell("AH" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G2D",$sheet->getCell("AJ" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2S",$sheet->getCell("AL" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G2D",$sheet->getCell("AN" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G2S",$sheet->getCell("AP" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G2D",$sheet->getCell("AQ" . $rowx)->getValue(), $array_data);
                    
                    //G3
                    RankingDetalle::ranking_detalle("1G3S",$sheet->getCell("AS" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G3D",$sheet->getCell("AT" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3S",$sheet->getCell("AM" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G3D",$sheet->getCell("AN" . $row)->getValue(), $array_data);
                    //RankingDetalle::ranking_detalle("3G3S",$sheet->getCell("AV" . $row)->getValue(), $array_data);
                    //RankingDetalle::ranking_detalle("3G3D",$sheet->getCell("AY" . $row)->getValue(), $array_data);
                    //RankingDetalle::ranking_detalle("4G3S",$sheet->getCell("AZ" . $row)->getValue(), $array_data);
                    //RankingDetalle::ranking_detalle("4G3D",$sheet->getCell("BC" . $row)->getValue(), $array_data);
                    
                    
                    //G4
                    RankingDetalle::ranking_detalle("1G4S",$sheet->getCell("AZ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("1G4D",$sheet->getCell("BC" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4S",$sheet->getCell("BE" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("2G4D",$sheet->getCell("BF" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4S",$sheet->getCell("BH" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("3G4D",$sheet->getCell("BJ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4S",$sheet->getCell("BL" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("4G4D",$sheet->getCell("BN" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4S",$sheet->getCell("BO" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("5G4D",$sheet->getCell("BQ" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4S",$sheet->getCell("BT" . $row)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("6G4D",$sheet->getCell("BW" . $rowx)->getValue(), $array_data);
                    
                    //Nacional por equipo
                    RankingDetalle::ranking_detalle("NE",$sheet->getCell("BZ" . $row)->getValue(), $array_data);
                    
                    //Master
                    //RankingDetalle::ranking_detalle("IMS",$sheet->getCell("BY" . $rowx)->getValue(), $array_data);
                    //RankingDetalle::ranking_detalle("IMD",$sheet->getCell("BZ" . $rowx)->getValue(), $array_data);

                   
                    //Penalidad
                    RankingDetalle::ranking_detalle("PENA",$sheet->getCell("N" . $rowx)->getValue(), $array_data);
                   
                    RankingDetalle::ranking_detalle("TTS",$sheet->getCell("CB" . $rowx)->getValue(), $array_data);
                    RankingDetalle::ranking_detalle("TTD",$sheet->getCell("CD" . $rowx)->getValue(), $array_data);

                    $TTP=implode("",explode(".",($sheet->getCell("CE" . $rowx)->getValue())));                
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
                            $atleta_id = $ObjAtleta->getID();
                            $ObjAtleta->setFechaNacimiento($fechan);
                            $ObjAtleta->setEstado($estado);
                            $ObjAtleta->setSexo($sexo);
                            $ObjAtleta->Update();

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
    $jdata = array("registros"=>$datajj); 
    
    
}