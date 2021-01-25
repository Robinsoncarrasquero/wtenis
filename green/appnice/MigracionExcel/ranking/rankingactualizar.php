<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
<?php
//Este programa procesa esta adecuado solo las categorias 12,14,16,18
require_once '../../clases/Atleta_cls.php';
require_once '../../clases/Ranking_detalle_cls.php';
require_once '../../clases/Ranking_cls.php';
require_once '../../clases/Torneos_Inscritos_cls.php';
require_once '../../sql/ConexionPDO.php';
require_once '../../PHPExcel/Classes/PHPExcel.php';

//Ano de afiliacion 


//$rsCategorias = Categoria::ReadAll();
$rsCategorias = array("categoria"=>"16");

foreach ($rsCategorias as $record) {
    
    //Entidad Federal
   
    $categoria=$record;
   
       
    $filefem="file/Ranking ".$categoria." Femenino.xls";
    $filemas="file/Ranking ".$categoria." Masculino.xls";
    $sexo_categoria = array($filefem =>"F",$filemas =>"M");
    print_r($sexo_categoria);
    $files_procesar= array($filefem,$filemas);
    print_r($files_procesar);
    $fechark="2019-01-01"; // FECHA DE RANKING
    Ranking::DeleteCategoria($categoria);
    foreach ($files_procesar as $file_name) {
       
        $sexo = $sexo_categoria[$file_name];
        print_r($sexo."<br>");
        print_r($file_name."<br>");
       
        if (file_exists($file_name)){
            //Abrimos el libro en excel para procesar cada estado
            print_r("<br>PROCESANDO FILE:".$file_name." <br>");
            $sheet = NULL;$objPHPExcel=NULL;
            $inputFileType=NULL;$objReader=NULL;
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
                RankingDetalle::ranking_detalle("IM",$sheet->getCell("CL" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("IMD",$sheet->getCell("CM" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("COSAT",$sheet->getCell("CQ" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("COTTEC",$sheet->getCell("CR" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("ITF",$sheet->getCell("CT" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("ATPWTA",$sheet->getCell("CV" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("TPI",$sheet->getCell("CY" . $row)->getValue(), $array_data);
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
                RankingDetalle::ranking_detalle("1G3S",$sheet->getCell("AU" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("1G3D",$sheet->getCell("AW" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G3S",$sheet->getCell("AY" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G3D",$sheet->getCell("BA" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G3S",$sheet->getCell("BD" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G3D",$sheet->getCell("BF" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G3S",$sheet->getCell("BH" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G3D",$sheet->getCell("BJ" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("1G4S",$sheet->getCell("BL" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("1G4D",$sheet->getCell("BM" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G4S",$sheet->getCell("BN" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G4D",$sheet->getCell("BO" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G4S",$sheet->getCell("BP" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G4D",$sheet->getCell("BQ" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G4S",$sheet->getCell("BS" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G4D",$sheet->getCell("BU" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("5G4S",$sheet->getCell("BW" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("5G4D",$sheet->getCell("BX" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("6G4S",$sheet->getCell("BY" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("6G4D",$sheet->getCell("BZ" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("1G4BS",$sheet->getCell("CA" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("1G4BD",$sheet->getCell("CB" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G4BS",$sheet->getCell("CD" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("2G4BD",$sheet->getCell("CE" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G4BS",$sheet->getCell("CF" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("3G4BD",$sheet->getCell("CG" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G4BS",$sheet->getCell("CH" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("4G4BD",$sheet->getCell("CJ" . $rowx)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("NE",$sheet->getCell("CN" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("IR",$sheet->getCell("CO" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("IRD",$sheet->getCell("CP" . $row)->getValue(), $array_data);
               
                RankingDetalle::ranking_detalle("TMA",$sheet->getCell("CZ" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("TTS",$sheet->getCell("DB" . $row)->getValue(), $array_data);
                RankingDetalle::ranking_detalle("TTD",$sheet->getCell("DD" . $row)->getValue(), $array_data);
               
               
                $TTP=($sheet->getCell("DG" . $row)->getValue());
                
                //printf('%0.0f',$TTP);
                //TTP=$sheet->getActiveSheet()->getStyle('DG')->getNumberFormat()->setFormatCode("#,##0.00");
                //Formateamos totall puntos (variables, cantidad de decimales,separador de decimales, separador de miles
                //$TTPUNTOS = number_format($TTP, 0, ',', ' ');
                 $TTPUNTOS = $TTP;
                 
                
//                   echo $i . "--" . $atleta_id . "--" . $cedula . "--" . $rkn ."--" . $rkr. "--" . $rke. "==" . $estado . "==" . $nom . "==" . $ape . "-" . $fechan."-"." PENAL ".$totpenal ."-"." Puntos ".$totpuntos."<br>";
                               
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
                        $objRanking->Find($atleta_id, $categoria);
                        
                        $objRanking->setAtleta_id($ObjAtleta->getID());
                        $objRanking->setCategoria($categoria);
                        $objRanking->setRknacional($rkn);
                        $objRanking->setRkregional($rkr);
                        $objRanking->setRkestadal($rke);
                        $objRanking->setFechaRankingNacional($fechark);
                        
//                        print_r(gettype($TTPUNTOS));
//                        print_r("VALOR".$TTP."<br>");
                        $objRanking->setPuntos(($TTPUNTOS));
                        if ($objRanking->Operacion_Exitosa()){
                            $objRanking->Update;
                            $objRanking->getMensaje();
                        }else{
                            $objRanking->create();
                            $objRanking->getMensaje();
                        }

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
            print_r("<br>FIN DE FILE:".$file_name." <br>");
        }
    }
    //Actualizamos Ranking de los torneos de esa categoria
    
    
}
TorneosInscritos::UpdateRanking();

?>
</body>
</html>