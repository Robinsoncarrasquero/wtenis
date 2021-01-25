<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../conexion.php';
// Create connection
if (MODO_DE_TEST!=1){
    die("No se puede ejecutar Conexion failed: " . $conn->connect_error);
    
}
    
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// Datos de las atletas para crear el ranqking por categoria
header('Content-Type: text/html; charset=iso-8859-1');
$file35fem='../migracionexcel/35/2016/smallpdf.com Ranking 35 Femenino 20161130.xlsx - XML.csv';
$file35mas='../migracionexcel/35/2016/smallpdf.com Ranking 35 Masculino 20161130.xlsx - XML.csv';

$file35= array($file35fem,$file35mas);

$la_categoria = array($file35fem =>"35-F",$file35mas =>"35-M");
$fechark="'2016-11-30'"; // FECHA DE RANKING

foreach($file35 as $item){
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
    
    while (!feof($fp)) { // loop hasta que se llegue al final del archivo
        $loop++;
        $line = fgets($fp); // guardamos toda la línea en $line como un string
        // dividimos $line en sus celdas, separadas por la coma
        // e incorporamos la línea a la matriz $field
        $field[$loop] = explode (',', $line);
        // generamos la salida HTML
        $rkn = $field[$loop][0]; // ranking nacional
        $rkr = $field[$loop][0]; // ranking regional
        $rke = $field[$loop][0]; // ranking estadal
       
        
        $estado = 'MIR'; //ereg_replace("[^A-Z]", "", $field[$loop][3]); 
       
        $cedula =  $field[$loop][1]; 
        
        $apellidos = trim(ereg_replace("[^A-Z]", " ", $field[$loop][2]));
        $nombres = trim(ereg_replace("[^A-Z]", " ", $field[$loop][3]));
  
        $fechanac  = str_replace('/', '-', $field[$loop][4]);
              
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

//        echo '<pre>';
//        var_dump($fecha_nacimiento).'</br>';
//        echo '</pre>';
        echo '
        if ($fechanac.lenght()>2) {
           $fechan=$fechanac[2].'-'.$fechanac[1].'-'.$fechanac[3]
         <div>
        
         <div>Ranking Estadal: '.$field[$loop][0].'</div>
         <div>Estado: '.$estado.'</div>
         <div>Cedula: '.$cedula.'</div>
         <div>Apellidos: '.$apellidos.'</div>
         <div>Nombres: '.$nombres.'</div>
         <div>Fecha Nacimiento: '.$fn.'</div>
         </div>
          <br/>
        ';
        $sw=TRUE;
        IF ($sw){
         //STR_TO_DATE( '01-09-1986', '%d-%m-%Y' );
        $c1=$cedula;$c2=$nombres;$c3=$apellidos;$c4=$estado;$c5=$fn;$c6=1;
        //$sql="INSERT INTO atleta(cedula,nombres,apellidos,estado,fecha_nacimiento,nacionalidad_id) VALUES($cedula,$nombres,$apellidos,$estado,'2013/01/17',1)";
        
        $sql ="SELECT atleta_id FROM atleta WHERE cedula='$cedula'"; // determinamos que la cedula existe
        $result=mysqli_query($conn,$sql);
        // actualizar atleta
        if (mysqli_num_rows($result) ==0){
            
            $sql="INSERT INTO atleta(cedula,nombres,apellidos,estado,fecha_nacimiento,nacionalidad_id,sexo,contrasena) "
                . "VALUES("."'".$c1."',"."'".$c2."',"."'".$c3."',"."'".$c4."',"."'".$c5."',".$c6.",'".$sexo."',"."'".$c1."')";
           
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
            $nom="'".$c2."'";
            $ape="'".$c3."'";
            $edo="'".$c4."'";
            //$sql="UPDATE  atleta SET nombres=$nom,apellidos=$ape,estado=$edo WHERE atleta_id=$atleta_id";
            $sql="UPDATE  atleta SET estado=$edo WHERE atleta_id=$atleta_id";
            
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
                echo '</pre>';

                if (mysqli_query($conn,$sql)){
                   echo "Actualizado ranking exitosamente".'</br>';
                }else {
                   echo "Error ranking No Actualizado " . $conn->error.'</br>';
                   exit;
                }
                
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