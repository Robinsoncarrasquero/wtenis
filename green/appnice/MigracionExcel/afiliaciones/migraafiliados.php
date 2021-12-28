<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
<?php

require_once '../../clases/Atleta_cls.php';
require_once '../../clases/Afiliaciones_cls.php';
require_once '../../clases/Empresa_cls.php';
require_once '../../clases/Afiliacion_cls.php';
require_once '../../sql/ConexionPDO.php';

require_once '../../PHPExcel/Classes/PHPExcel.php';

//Ano de afiliacion 
$ano_afiliacion=date("Y");

$rsEmpresa = Empresa::ReadAll();
foreach ($rsEmpresa as $record_empresa) {
    $empresa_id=$record_empresa['empresa_id'];
    //Entidad Federal
    $estado=$record_empresa['estado'];
   
    //OJO QUITAR ESTO QUE ES FORZADO
//    //Empresa
//    $empresa_id=7;
//    //Entidad federal
//    $estado='ANZ';
    $archivo="2018/Listado de Afiliaciones ".$estado.".xls";
    if (file_exists($archivo)){
        //Busca la afiliacion de ano con el ciclo 1 que es unico(1=anual,2=semestral)
        $rsAfiliacion = Afiliacion::ReadByCiclo($empresa_id,$ano_afiliacion,1);

        //En caso de haber alguna afiliacion activa en el ano se procesa de forma masiva    
        foreach ($rsAfiliacion as $dataAfiliacion) {
            $afiliacion_id=$dataAfiliacion['afiliacion_id'];



            //Abrimos el libro en excel para procesar cada estado
            $archivo = "libro1.xls";
            $archivo="2018/Listado de Afiliaciones ".$estado.".xls";
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            $i=0;

            for ($row = 2; $row <= $highestRow; $row++){ 

                $cedula= trim($sheet->getCell("C".$row)->getValue());
                $nombre= $sheet->getCell("F".$row)->getValue();
                $fechan= $sheet->getCell("J".$row)->getValue();
                $fechaa= $sheet->getCell("K".$row)->getValue();
                $fechav= $sheet->getCell("M".$row)->getValue();
                $telefono= $sheet->getCell("P".$row)->getValue();
                $arraynombre=explode(",",$nombre);


                $regex = '#^[a-z]*[0-9][a-z0-9]*$#i'; //Acepta numero y letras o solo numero pero no letras
                if(preg_match($regex, $cedula)){
                     $i++;
                    $ape=  strtoupper($arraynombre[0]);
                    $nom=  strtoupper($arraynombre[1]);
                    $fechanac = explode ('/', $fechan);

                    $ano=$fechanac[2];
                    $mes=$fechanac[1];
                    $dia=$fechanac[0];
                    $fecha_nac=$ano."-".$mes."-".$dia;

                    $fechan=trim($fecha_nac); /// fecha de nacimiento
                    //Fecha de afiliacion
                    $fechaafi = explode ('/', $fechaa);
                    $ano=$fechaafi[2];
                    $mes=$fechaafi[1];
                    $dia=$fechaafi[0];
                    $fecha_afi=$ano."-".$mes."-".$dia;
                    $fechaa=trim($fecha_afi); /// fecha de afiliacion

                    $ObjAtleta = new Atleta();
                    $ObjAtleta->Find_Cedula($cedula);
                    if ($ObjAtleta->Operacion_Exitosa()){
                        $atleta_id=$ObjAtleta->getID();
                        $sexo = $ObjAtleta->getSexo();
                    }else{
                        $ObjAtleta->setApellidos($ape);
                        $ObjAtleta->setNombres($nom);
                        $ObjAtleta->setCedula($cedula);
                        $ObjAtleta->setContrasena($cedula);
                        $ObjAtleta->setFechaNacimiento($fechan);
                        $ObjAtleta->setEstado($estado);
                        $ObjAtleta->setNacionalidadID(1);
                        $ObjAtleta->create();
                        $atleta_id=$ObjAtleta->getID();
                        $sexo = $ObjAtleta->getSexo();
                    }


                    if ($atleta_id>0){

                        

                        //Categoria del atleta a inscribir
                        $categoria = $ObjAtleta->Categoria_Afiliacion($ano_afiliacion);

                        $objAfiliacion = new Afiliaciones();
                        $objAfiliacion->Fetch($afiliacion_id, $atleta_id);
                        if (!$objAfiliacion->Operacion_Exitosa()){


                            $objAfiliacion->setAno($ano_afiliacion);
                            $objAfiliacion->setAfiliacion_id($afiliacion_id);
                            $objAfiliacion->setAtleta_id($atleta_id);
                            $objAfiliacion->setCategoria($categoria);

                            $objAfiliacion->setSexo($sexo);
                            $objAfiliacion->setAfiliarme(1);
                            $objAfiliacion->setAceptado(1);
                            $objAfiliacion->setFormalizacion(1);
                            $objAfiliacion->setPagado(1);
                            $objAfiliacion->setFecha_Pago($fechaa);
                            //Crea una nueva afiliacion
                            $objAfiliacion->create();                    
                        }else{
                            $objAfiliacion->setAfiliarme(1);
                            $objAfiliacion->setAceptado(1);
                            $objAfiliacion->setFormalizacion(1);
                            $objAfiliacion->setPagado(1);
                            $objAfiliacion->setFecha_Pago($fechaa);
                            $objAfiliacion->Update();


                        }
                        echo $i."--".$atleta_id."--".$cedula."-==".$estado."==".$nom."==".$ape."-".$fechan."-".$fechaa."-".$fechav."==".$telefono."<br>";
                    }


                }



            }
            break;
        }
    }
   
}
?>
</body>
</html>