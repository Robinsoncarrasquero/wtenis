<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../conexion.php';
// Create connection
if (MODO_DE_TEST!=0){
    die("No se puede ejecutar Conexion failed: " . $conn->connect_error);
    
}
 // Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script
mb_internal_encoding('UTF-8');

// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador
mb_http_output('UTF-8');  
$conn = new mysqli($servername, $username, $password, $dbname);
//$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// Datos de las atletas para crear el ranqking por categoria
//header('Content-Type: text/html; charset=iso-8859-1');
//header('Content-Type: text/html; charset=utf8');
$file18fem='../migracionexcel/1418/2018/smallpdf.com Ranking 18 Femenino 20180104.xlsx - XML.csv';
$file18mas='../migracionexcel/1418/2018/smallpdf.com Ranking 18 Masculino 20180104.xlsx - XML.csv';
$file14fem='../migracionexcel/1418/2018/smallpdf.com Ranking 14 Femenino 20180104.xlsx - XML.csv';
$file14mas='../migracionexcel/1418/2018/smallpdf.com Ranking 14 Masculino 20180104.xlsx - XML.csv';
$file14= array($file14fem,$file14mas);
$file18= array($file18fem,$file18mas);
//$file1418= array($file14mas,$file14fem);

$file1418= array($file14fem,$file14mas,$file18fem,$file18mas);
// Datos de los atletas para crear el ranking por categoria
$file12fem='../migracionexcel/1216/2018/smallpdf.com Ranking 12 Femenino 20180104.xlsx - XML.csv';
$file12mas='../migracionexcel/1216/2018/smallpdf.com Ranking 12 Masculino 20180104.xlsx - XML.csv';
$file16fem='../migracionexcel/1216/2018/smallpdf.com Ranking 16 Femenino 20180104.xlsx - XML.csv';
$file16mas='../migracionexcel/1216/2018/smallpdf.com Ranking 16 Masculino 20180104.xlsx - XML.csv';
$file12= array($file12fem,$file12mas);
$file16= array($file16fem,$file16mas);
$file1216=array($file12fem,$file12mas,$file16fem,$file16mas);
// Datos de los atletas para crear el ranking por categoria
$filePNfem='../migracionexcel/0810/2018/smallpdf.com Ranking PN Femenino 20180201.xlsx - XML.csv';
$filePNmas='../migracionexcel/0810/2018/smallpdf.com Ranking PN Masculino 20180201.xlsx - XML.csv';
$filePVfem='../migracionexcel/0810/2018/smallpdf.com Ranking PV Femenino 20180201.xlsx - XML.csv';
$filePVmas='../migracionexcel/0810/2018/smallpdf.com Ranking PV Masculino 20180201.xlsx - XML.csv';
$filePN= array($filePNfem,$filePNmas);
$filePV= array($filePVfem,$filePVmas);
$filePNPV= array($filePNfem,$filePNmas,$filePVfem,$filePVmas);
$la_categoria = array($filePNfem =>"PN-F",$filePVfem =>"PV-F",$file12fem =>"12-F",$file14fem =>"14-F",$file16fem =>"16-F",$file18fem =>"18-F"
        ,$filePNmas =>"PN-M",$filePVmas =>"PV-M",$file12mas =>"12-M",$file14mas =>"14-M",$file16mas =>"16-M",$file18mas =>"18-M");
$fechark="'2018-02-01'"; // FECHA DE RANKING
 
//$fechadeleterk="'2017-01-27'"; // Fecha para eliminar ranking 1216
$fechadeleterk="'2017-12-31'"; // Fecha para eliminar ranking 1418
$swdelete_rk =TRUE;
foreach($filePNPV as $item){
    echo $item . '<br />';
    $categoria_ = $la_categoria[$item];
    $categoria_sexo = explode("-",$categoria_);
    $categoria=$categoria_sexo[0]; // Buscamos la categoria del archivo en el array
    $sexo=$categoria_sexo[1];  // F=Femenino M=Masculino
    
    echo '<pre>';
    var_dump($categoria_sexo).'</br>';
    echo '</pre>';
    $fp = fopen($item,'r');
    if (!$fp) {
        echo 'ERROR: No ha sido posible abrir el archivo. Revisa su nombre y sus permisos.';
        exit;}
    $loop = 0; // contador de líneas
     $sql="DELETE FROM ranking WHERE categoria='".$categoria."' and fecha_ranking<=$fechadeleterk";
     $result=mysqli_query($conn,$sql);
               
    while (!feof($fp)) { // loop hasta que se llegue al final del archivo
        $loop++;
        $line = fgets($fp); // guardamos toda la línea en $line como un string
        // dividimos $line en sus celdas, separadas por la coma
        // e incorporamos la línea a la matriz $field
        $field[$loop] = explode (',', $line);
        // generamos la salida HTML
        $rkn = $field[$loop][0]; // ranking nacional
        $rkr = $field[$loop][1]; // ranking regional
        $rke = $field[$loop][2]; // ranking estadal
        
        $estado = ereg_replace("[^A-Z]", "", $field[$loop][3]); 
        $estado = substr($field[$loop][3],0,3); 
        $cedula = trim(ereg_replace($estado, " ", $field[$loop][3])); 
        $cedula = trim($cedula,"."); 
        $apellidos = trim(ereg_replace("[^A-Z]", " ", $field[$loop][4]));
        $nombres = trim(ereg_replace("[^A-Z]", " ", $field[$loop][5]));
        $ape = trim(ereg_replace("^[a-zA-ZñÑáéíóúÁÉÍÓÚ]", ' ', $field[$loop][4]));
        $nom = trim(ereg_replace("^[a-zA-ZñÑáéíóúÁÉÍÓÚ]", ' ', $field[$loop][5]));
        //$ape = trim($field[$loop][4]);
        //$nom = trim($field[$loop][5]);
        $ape = mysql_real_escape_string(trim(str_replace('"', '', $field[$loop][4])));
        $nom = mysql_real_escape_string(trim(str_replace('"', '', $field[$loop][5])));
        
        $fechanac  = str_replace('/', '-', $field[$loop][6]);
              
        if (substr($fechanac,0,1)=="-"){ 
         $fechanac=substr($fechanac,1);
         
        }
        $fechanac  = trim($fechanac);
        $fechanac = explode ('-', $fechanac);
        
        $ano=$fechanac[2];
        $mes=$fechanac[1];
        $dia=$fechanac[0];
        
        if ($ano<10)
            $ano=2000+$ano;
        else if($ano<=99)
            $ano=1900+$ano;

//        if (checkdate($mes,$dia,$ano))
//          echo "La fecha ingresada es correcta</br>;";
//        else
//          echo "La fecha no es válida </br>;";



        $fecha_nac=$ano."-".$mes."-".$dia;
        $fn=trim($fecha_nac); /// fecha de nacimiento
//        echo '<pre>';
//        var_dump($nombres).'</br>';
//        var_dump($estado).'</br>';
//        var_dump($fn).'</br>';
//        var_dump($fn).'</br>';
//        echo '</pre>';
        //ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha_nacimiento, $mifecha); 
        //$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 

        //echo '<pre>';
        //var_dump($fecha_nacimiento).'</br>';
        //echo '</pre>';
        //echo '
        //if ($fechanac.lenght()>2) {
        //   $fechan=$fechanac[2].'-'.$fechanac[1].'-'.$fechanac[3]
        // <div>
        // <div>Ranking Nacional: '.$field[$loop][0].'</div>
        // <div>Ranking Regional: '.$field[$loop][1].'</div>
        // <div>Ranking Estadal: '.$field[$loop][2].'</div>
        // <div>Estado: '.$estado.'</div>
        // <div>Cedula: '.$cedula.'</div>
        // <div>Apellidos: '.$apellidos.'</div>
        // <div>Nombres: '.$nombres.'</div>
        // <div>Fecha Nacimiento: '.$fecha_nacimiento.'</div>
        // </div>
        //';
        
         //STR_TO_DATE( '01-09-1986', '%d-%m-%Y' );
        //$nombres=  html_entity_decode($nombres, ENT_QUOTES |  ENT_HTML5,  "UTF-8" );
        //$apellidos=html_entity_decode($apellidos, ENT_QUOTES | ENT_HTML5,  "UTF-8");
        
            
        $nom= utf8_decode($nom);
        $ape=  utf8_decode($ape);
        
        
        echo '<pre>';
            var_dump($nom).'</br>';
            var_dump($ape).'</br>';
        echo '</pre>';
        $c1=$cedula;$c2=$nom;$c3=$ape;$c4=$estado;$c5=$fn;$c6=1;
        //$sql="INSERT INTO atleta(cedula,nombres,apellidos,estado,fecha_nacimiento,nacionalidad_id) VALUES($cedula,$nombres,$apellidos,$estado,'2013/01/17',1)";
        
        $sql ="SELECT atleta_id FROM atleta WHERE cedula='$cedula'"; // determinamos que la cedula existe
        $result=mysqli_query($conn,$sql);
        //mysqli_query('SET NAMES "utf8"');
        // actualizar atleta
        if (mysqli_num_rows($result) ==0){
            
            $sql="INSERT INTO atleta(cedula,nombres,apellidos,estado,fecha_nacimiento,nacionalidad_id,sexo,contrasena) "
                . "VALUES("."'".$c1."',"."'".$c2."',"."'".$c3."',"."'".$c4."',"."'".$c5."',".$c6.",'".$sexo."','".$c1."')";
           
            if (mysqli_query($conn,$sql)) {
                    echo "Nuevo Atleta insertado exitosamente".mysqli_insert_id($conn)."</br>";
                    $atleta_id=mysqli_insert_id($conn);  
                    echo '<pre>';
                    var_dump($atleta_id).'</br>';
                    echo '</pre>';
                   
            }
        }else
        {
            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
            $atleta_id= $row['atleta_id'];
          
            $nom="'".  $c2."'";
            $ape="'".  $c3."'";
            $edo="'".$c4."'";
           
            
            //$sql="UPDATE  atleta SET nombres=$nom,apellidos=$ape,estado=$edo WHERE atleta_id=$atleta_id";
            $sql="UPDATE  atleta SET estado=$edo WHERE atleta_id=$atleta_id";
            //mysqli_query('SET NAMES "utf8"');
             if (mysqli_query($conn,$sql)){
                   echo "Actualizado datos de Atleta exitosamente".'</br>';
                }else {
                   echo "Error modificando datos de atleta, No Actualizado " . $conn->error.'</br>';
                   exit;
                }
            
        }
        //actualizar ranking
        if ($atleta_id>0){
            $cate="'".$categoria."'";
            $sql ="SELECT ranking_id FROM ranking WHERE atleta_id=$atleta_id AND categoria=$cate"; // determinamos que ranking existe
            $result=mysqli_query($conn,$sql);
            
            echo '<pre>';
            var_dump($sql).'</br>';
            var_dump($result).'</br>';
            echo '</pre>';
            if (mysqli_num_rows($result) ==0){
                $sql="INSERT INTO ranking(atleta_id,categoria,rknacional,rkregional,rkestadal,fecha_ranking) "
                              ."VALUES($atleta_id,$cate,$rkn,$rkr,$rke,$fechark)";
                echo '<pre>';
                var_dump($sql).'</br>';
                echo '</pre>';
                if (mysqli_query($conn,$sql)){
                   echo "Nuevo ranking registrado exitosamente".'</br>';
                }else {
                   echo "Error Ranking NO REGISTRADO: " . $conn->error.'</br>';
                   exit;
                }
            }else {
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                $ranking_id= $row['ranking_id'];
                $sql="UPDATE  ranking SET rknacional=$rkn,rkregional=$rkr,rkestadal=$rke,fecha_ranking=$fechark WHERE ranking_id=$ranking_id";
                echo '<pre>';
                var_dump($sql).'</br>';
                var_dump($atleta_id).'</br>';
                 var_dump($rkn).'</br>';
                echo '</pre>';

                if (mysqli_query($conn,$sql)){
                   echo "Actualizado ranking exitosamente".'</br>';
                }else {
                   echo "Error ranking No Actualizado " . $conn->error.'</br>';
                   exit;
                }
                
            }
        }
        

       $fp++; // necesitamos llevar el puntero del archivo a la siguiente línea
    }
    
}

fclose($fp);
mysqli_close($conn);
echo 'FIN DE PROCESO';
?>