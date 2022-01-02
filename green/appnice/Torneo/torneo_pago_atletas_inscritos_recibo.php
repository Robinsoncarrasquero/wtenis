<?php
   require_once '../conexion.php';
   require_once '../src/Cezpdf.php';
   $torneoinscrito_id=(isset($_GET['id'])) ? $_GET['id'] : null;
   
   $queEmp = "SELECT atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
            . "atleta.sexo,DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
           . "torneo.codigo,torneo.nombre as nombretorneo,torneo.monto,torneo.iva,DATE_FORMAT(torneo.fecha_inicio_torneo, '%d-%m-%Y') as fecha_inicio_torneo,"
        ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',atleta.sexo) as Categoria_Sexo,"
            . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
           . "torneoinscritos.torneoinscrito_id,torneoinscritos.pagado"
            ." FROM atleta "
        . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
        . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
        . "WHERE torneoinscritos.pagado=1 && torneoinscritos.torneoinscrito_id=". $torneoinscrito_id ;
    
    $conexion = mysqli_connect($servername, $username, $password);
    mysqli_select_db($conexion,$dbname);
     mysqli_query($conexion,'SET NAMES "utf8"');
    $resEmp = mysqli_query($conexion,$queEmp) or die(mysqli_error($conexion));
    $totEmp = mysqli_num_rows($resEmp);
    
    while($datatmp = mysqli_fetch_assoc($resEmp)) {
        
        
        $pdf =new Cezpdf('a8');
        $pdf->selectFont('../fonts/Courier.afm');
        //$pdf->ezSetCmMargins(1,1,1.5,1.5);
        
         $options = array(
                        'shadeCol'=>array(0.9,0.9,0.9),
                        'xOrientation'=>'center',
                        'width'=>500
                    );
        //$pdf->ezSetDy(0);
//        $nombres='ROBINSON ENRIQUE';
//        $apellidos='CARRASQUERO';
//        $cedula='7590029';
//        $monto=4000;
//        $torneo='IIIG31216MIR';
        
        
       $id=$datatmp['torneoinscrito_id'];
       $nombres=$datatmp['nombres'];
       $apellidos= $datatmp['apellidos'];
       $cedula=$datatmp['cedula'];
       $monto=$datatmp['monto'];
       $iva=$datatmp['iva'];
       $torneo=$datatmp['codigo'];
       $fechatorneo=$datatmp['fecha_inicio_torneo'];
        
        $txtrif='ATEM:J001897909';
        $txtrecibo = "RECIBO DE PAGO";
        $txtempresa='ASOCIACION DE TENIS';
        $txtrayado='-----------------------------';
        $pdf->ezSetMargins(0,0,4,1);
        $pdf->ezText($txtrif, 8);
        $pdf->ezText($txtempresa, 8);
        $pdf->ezText($txtrecibo, 8);
       
        $pdf->ezText($txtrayado, 8);
        $pdf->ezText("CONTROL: ".$id, 8);
        $pdf->ezText("NOMBRE: ".$nombres, 8);

        $pdf->ezText("APELLIDOS: ".$apellidos, 8);

        $pdf->ezText("CEDULA: ".$cedula, 8);

        $pdf->ezText("TORNEO: ".$torneo, 8);
        $pdf->ezText("FECHA TORNEO: ".$fechatorneo, 8);
        $pdf->ezText("MONTO: ".$monto, 8);
        $pdf->ezText("IVA: ".$iva, 8);
        $pdf->ezText("TOTAL: ".($iva + $monto), 8);

        $pdf->ezTable($data, $titles, '', $options);
        //$pdf->ezText("\n\n\n", 10);
        $pdf->ezText("Fecha: ".date("d/m/Y"), 8);

        $pdf->ezText("Hora: ".date("H:i:s"), 8);
        $pdf->ezStream();//abrir el pdf de forma automatica
    //    $output = $pdf->ezOutput(1); //Salida de archivo
    //    file_put_contents('pdf/mipdf.pdf', $output); //guardar en el server
        mysqli_close($conexion);
        //Unimos todos estos bloques y tenemos listo nuestro script para generar reportes en PDF,
        //pueden ver el ejemplo funcionando en php-mysql.php. 
        //Para finalizar les dejo los archivos del ejemplo para que lo prueben y modifiquen a sus necesidades.

  
        //Recibo($datatmp['torneoinscrito_id'],$datatmp['nombres'], $datatmp['apellidos'], $datatmp['cedula'], $datatmp['monto'],$datatmp['iva'],$datatmp['codigo'],$datatmp['fecha_inicio_torneo']);
    }
    
     mysqli_close($conexion);
    
    
        
   
?> 


