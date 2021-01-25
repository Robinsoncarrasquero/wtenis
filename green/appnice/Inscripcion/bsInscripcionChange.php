<?php
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
}else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location:../sesion_cerrar.php');
    exit;
}
   
//Servicio web
//$deshabilitado= $_SESSION['niveluser']==1 ? false : $_SESSION['deshabilitado'];
$sWEB=1;
if (!$result) {
    die('No pudo conectarse: ' . mysql_error());
}

if (@$_POST['btnProcesar']){   
    //Aqui eliminamos en las inscripciones que aun se encuentran activas antes de la fecha de cierre
    //de inscripcion. Una vez cerradas las inscripcionesse solo se permite retiro.
    if (isset($_POST['chkeliminar'])){
        // Borrar los selecionados o desincribir de torneo
        foreach($_POST['chkeliminar'] as $Datos){
            
            $array_Datos = explode (',', trim($Datos)); // convertimos un arreglo y extraemos la data
            $torneoid=  $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            $categoria=  $array_Datos[3];

            $time=time();
            $fecha =date("Y-m-d", $time);

             $t_id = (int) $torneo_inscrito_id;
            // sql to delete a record
            $sql = "DELETE FROM torneoinscritos WHERE torneoinscrito_id=$t_id";
             $result=mysql_query($sql);
            if (!$result) {
                echo "Error borrando inscripcion: " .mysql_error();
            }else{
                email_inscripcion("ELI", $torneoid, $atleta_id, $categoria);
            }
        }
        
        mysql_close($conn);
        header('Location: bsInscripcion.php');
        exit;
    }
    
    //Aqui se ejecuta los retiros donde solo cambiamos el campo "ESTATUS" a RETIRO en la tabla de inscripciones
    //cambiando solo el estatus..
    if (isset($_POST['chkretirar'])){
        // Borrar los selecionados o desincribir de torneo
        foreach($_POST['chkretirar'] as $Datos){
            
            $array_Datos = explode (',', trim($Datos)); // convertimos un arreglo y extraemos la data
            $torneoid=  $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            $categoria=  $array_Datos[3];
            $lacategoria="'$categoria'";
//            echo'<pre>';
//              var_dump($array_Datos).'</br>';
//            echo '</pre>';
//            die("ERRROR RETIRando");
            $time=time();
            $fecha =date("Y-m-d", $time);

             $t_id = (int) $torneo_inscrito_id;
            // sql to delete a record
            $sql = "UPDATE torneoinscritos SET estatus='Retiro', condicion=9 WHERE torneoinscrito_id=$t_id";
            $result=mysql_query($sql);
            if (!$result) {
                echo "Error retirando inscripcion: " .mysql_error();
            }else{
                email_inscripcion("RET", $torneoid, $atleta_id, $categoria);
            }
        }
        mysql_close($conn);
        header('Location: bsInscripcion_Retiros.php');
        exit;
    }
        
    //Aqui se realiza las inscripciones. Este codigo elimina cualquier inscripcion relacionada 
    //y luego inserta un nuevo registro de inscripcion. 
    if (isset($_POST['chkinscribir'])) 
    {
        foreach($_POST['chkinscribir'] as $Datos)
        {
            
            
            $array_Datos = explode (',', trim($Datos)); // convertimos un arreglo y extraemos la data
            $torneoid=  $array_Datos[0]; // 
            $atleta_id=$array_Datos[1];
            $torneo_inscrito_id=  $array_Datos[2];
            //Codigo de torneo que es el codigo unico para que pueda validar el registro y no
            //permita inscripciones duplicadas
            $codigo=$array_Datos[5]; 
//            if ($torneo_inscrito_id==0){
//                $categoria= (isset($_POST[$torneoid]) ? trim($_POST[$torneoid]): "XX") ;
//            }
//            foreach ($_POST['chkmodalidad'.$torneoid] as $chkModalidad)
//            {
//               $modalidad.=$chkModalidad.';';
//            }
            $ITEM="M$torneoid";
            
           //Manejamos la modalidad de Juego (SS,DD,DM)
            if (isset($_POST[$ITEM])){
               
                foreach($_POST[$ITEM] as $valor){ 
                      //var_dump($valor."<br>");
                      $array_modalidad[]=$valor;
                }
                $modalidad=  implode(",", $array_modalidad);
                $array_modalidad=NULL;
                
            }else{
                $modalidad="SS";
            }
          
            $categoria= (isset($_POST[$torneoid]) ? trim($_POST[$torneoid]): "XX") ;
            $lacategoria= "'".  substr($categoria, 0,2)."'";
            $sql="SELECT sexo FROM atleta WHERE atleta_id=$atleta_id";
            $result=mysql_query($sql);
            $record = mysql_fetch_assoc($result);
            $sexo="'".$record['sexo']."'";
       
            $time=time();
            $fecha =date("Y-m-d", $time);

            $t_id = (int) $torneo_inscrito_id;

            //$sql = "DELETE FROM torneoinscritos WHERE torneoinscrito_id=$t_id";
            //$result=mysql_query($sql);

            $fecha_rk_hoy=date("Y-m-d"); // fecha de hoy creada en objeto 
            
            //Buscamos el ultimo ranking registrado actualizado en la tabla RANK
            $sql="SELECT sexo,categoria,fecha FROM rank WHERE categoria=".$lacategoria ." and sexo=".$sexo
                    ." ORDER BY fecha DESC LIMIT 1 ";
                  
            $resultRANK=mysql_query($sql);
            $recordRANK = mysql_fetch_assoc($resultRANK);
            $fechaRANK= $recordRANK['fecha'];
            if (mysql_num_rows($resultRANK)==0){ 
                $rknacional = 999;
                $franking = $fecha_rk_hoy;
                $rkcosat = 999;
                $frcosat = $fecha_rk_hoy;
            }  else {
                
                $sql="SELECT atleta_id,rknacional,fecha_ranking,rkcosat,fecha_ranking_cosat FROM ranking "
                        . " WHERE fecha_ranking='$fechaRANK' && atleta_id=$atleta_id AND  categoria=".$lacategoria
                        . " ORDER BY fecha_ranking DESC LIMIT 1 ";

                $result=mysql_query($sql);
                if (mysql_num_rows($result)==0){ 
                    $rknacional = 999;
                    $franking = $fecha_rk_hoy;
                    $rkcosat = 999;
                    $frcosat = $fecha_rk_hoy;

    //              if (!$result) {
    //              
    //               echo "Error insertando ranking : " .$conn_error();
    //              }

                }else{
                    $record = mysql_fetch_assoc($result);
                    $rknacional = $record["rknacional"];
                    $franking = $record["fecha_ranking"];
                }
            }
            if ($t_id==0){
                $sql="INSERT INTO torneoinscritos(torneo_id,atleta_id,rknacional,categoria,sexo,fecha_ranking,afiliado,codigo,modalidad)"
                        . " VALUES($torneoid,$atleta_id,$rknacional,$lacategoria,$sexo,'".$franking."',".$sWEB.",'".$codigo."','$modalidad')";
                $result=mysql_query($sql);
               
            }else{
                $sql="UPDATE torneoinscritos set categoria=$lacategoria,rknacional=$rknacional,fecha_ranking='$franking',modalidad=$modalidad WHERE torneoinscrito_id=$t_id";
                $result=mysql_query($sql);
            }
    

            if (!$result) {
              //die('No pudo conectarse: '.$sql . mysql_error());
               //echo "Error insertando inscripcion: " .$conn_error();
               
                //header('Location: bsInscripcion.php');
                
            }
            else{
              email_inscripcion("INS", $torneoid, $atleta_id, $categoria);

            }
            
        } 
       
        mysql_close($conn);
        header('Location: bsInscripcion.php');
        exit;
        
    }
      //este funciona en el caso que el usuario haya presionado el bonto guardar pero no hizo
      //ningun cambio al formulario
      
      header("Location: bsInscripcion.php ");
      exit; 
}

?>


   

        

         
	
         
	
        
        
	
	


