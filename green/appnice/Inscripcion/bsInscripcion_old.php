<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Torneos_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Modalidad_cls.php';
require_once '../clases/Bootstrap_Class_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

if (isset($_SESSION['logueado']) and $_SESSION['logueado']) {
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
   
} else {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
}
if ($_SESSION['niveluser'] > 8) {
    header('Location: ../sesion_inicio.php');
    exit;
}
error_reporting(0);
$afiliado = $_SESSION['afiliado'];
$sweb= $_SESSION['SWEB'];
//print_r("AFILIADO --> :".$afiliado);

//Validamos que la afiliacion sea confirmada
$atleta_id=$_SESSION['atleta_id'];
if($_SESSION['niveluser']==1){
   $nombre="(** ".$_SESSION['nombre']." **)";
    
}

$cedulaid=$cedula;
//mb_http_output('UTF-8');

header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inscripcion</title>
        <meta name="description" content="Sitio web para Inscripciones onLine de Torneos de Tenis de Campo y Tenis de Playa">
        <link rel="stylesheet" href="Normalize.css">
        <link rel="stylesheet" href="css/tenis_estilos.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="shortcut icon" href="<?php echo $_SESSION['favicon']?> " />
           
    </head>
    <style>
        
        .loader{

            background-image: url("images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }
        nav.navbar {
            background-color:    #000;
        }
        .jumbotron{
           background-color:<?php echo $_SESSION['bgcolor_jumbotron']?>;
           color: <?php echo $_SESSION['color_jumbotron']?>;
        }
        iframe{
            width: 100%;
        }
        .mensaje {
        float:left;
        margin:0;
        padding:5px;
	//position:relative ; /* Hacemos que la posición en pantalla sea fija para que siempre se muestre en pantalla*/
	 /* Establecemos la barra en la izquierda */
	top: 5px; /* Bajamos la barra 200px de arriba a abajo */
	z-index: 2000; /* Utilizamos la propiedad z-index para que no se superponga algún otro elemento como sliders, galerías, etc */
}

                // Use as-is
        
       .title-table{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
                color: <?php echo $_SESSION['color_jumbotron'] ?>;
            }
            .table-head{
                background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
                color: <?php echo $_SESSION['color_jumbotron'] ?>;

            }
            
    </style>
<body>
 

<?php  
//Container

echo '<div class="container-fluid">'; //Container main
    
    //Presentar los iconos de la pagina
    echo '<div class="col-md-12">';
      Bootstrap::master_page();
    echo '</div>'; //Container    
    
    //Presentar un Usuario
    echo '<div class="col-md-12">';
    echo '<h6>Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '</div>'; //Container    
           
        
    //Para generar las miga de pan mediante una clase estatica
   $arrayNiveles=array(
       array('nivel'=>1,'titulo'=>'Inicio','url'=>'../bsPanel.php','clase'=>' '),
       array('nivel'=>2,'titulo'=>'Retiros','url'=>'../Inscripcion/bsInscripcion_Retiros.php','clase'=>' '),
       array('nivel'=>3,'titulo'=>'Mis Torneos','url'=>'../MisTorneos/MisTorneos.php','clase'=>''),
       array('nivel'=>4,'titulo'=>'Inscripcion','url'=>'../Inscripcion/bsInscripcion.php','clase'=>'active')
       );
       echo Bootstrap::breadCrum($arrayNiveles);
 
    //Conectamos
    $conn =  mysql_connect($servername, $username, $password);
    $result=mysql_select_db($dbname,$conn);
    if (!$result) {
        die('No pudo conectarse: ' . mysql_error());
    }
    
    //division dos lados lef y right
echo '<div class="col-lg-12">'; 
   
    

//Lado left 8 celdas
echo '<div class="col-lg-8 col-lg-offset-4>'; 
$strhead=' 
   
   <form action="bsInscripcionChange.php" method="post" >
           <div class="row"> 
            <div class="col-xs-12">
              <section class="table-torneo ">
                <div class="table-responsive">
                    <div  class="table">      
                        <table class="table table-bordered table-hover table-condensed ">
                           <thead >
                                <tr class="table-head ">
                                    <th><p class="glyphicon glyphicon-dashboard"<p></th>
                                    <th>Entidad</th>
                                    <th>Grado</th>
                                    <th>Cierre</th>
                                    <th>Retiros</th>
                                    <th>Inicio</th>
                                    <th>Categ</th>
                                    <th>Juego</th>
                                    <th>Apuntar</th>
                                    <th>Borrar</th>
                                    <th>Lista</th>
                                   
                                </tr>
                            </thead>';
                            
echo $strhead;
  
  
  $consulta_mysql = "SELECT * FROM atleta WHERE cedula='".$cedulaid."'";
  //$result_atleta = $conn>query($consulta_mysql); mysqli
  //while($fila = $result_atleta->fetch_assoc()) mysqli
  $result_atleta = mysql_query($consulta_mysql);
  $nrtorneos=0;//Cuenta los torneos disponible para el usuario
  while ($fila = mysql_fetch_assoc($result_atleta )) 
                
    {
      $atleta_id=$fila["atleta_id"];
      $cedula=$fila["cedula"];
      $nombre= $fila["nombres"];
      $apellido= $fila["apellidos"];
      $fechan= $fila["fecha_nacimiento"];
      $mi_ano_Nacimiento = anodeFecha($fechan); // ANO DE NACIMIENTO
      $atleta_estado=$fila["estado"]; // Asociacion o Entidad Federal
      
    
//       
      //consulta en la tabla de torneos activos para inscribirse
      
      if (($_SESSION['niveluser']==1)){
        //$consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' and  ADDDATE(fechacierre, INTERVAL 5 DAY)>= Now()  order by fechacierre";
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A'
                            and condicion IS NULL
                            and  ADDDATE(fecha_inicio_torneo, INTERVAL 30 DAY)>= now()
                            and  ADDDATE(NOW(), INTERVAL 30 DAY)>= fecha_fin_torneo 
                            order by fecha_inicio_torneo";
        
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A'"
                . " && (condicion='C' || condicion IS NULL)"
                . " &&  ADDDATE(fecha_inicio_torneo, INTERVAL 10 DAY)>= Now()  "
                . " &&  ADDDATE(NOW(), INTERVAL 40 DAY)>= fecha_fin_torneo "
                . " order by fechacierr,eempresa_id";
       
      }else{
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' "
                . " && condicion='C' "
                . " && fechacierre>= now() "
                . " order by fechacierre,empresa_id";
      }
      
    //$resultado_SQL_torneo = $conn>query($consulta_mysql2); mysqli
//      $resultado_SQL_torneo = mysql_query($consulta_mysql2);mysqli
//      while($filator = $resultado_SQL_torneo->fetch_assoc()) mysqli
      $result_torneo = mysql_query($consulta_mysql2);
      $record_encontrados=0;
      while($filator = mysql_fetch_assoc($result_torneo)){
       
        $torneo_id=$filator["torneo_id"];
        $codigo_torneo=$filator["codigo"];
        $codigo_unico=$filator["codigo_unico"];
        $grado_torneo=$filator["tipo"];
        $nombre_torneo=$filator["nombre"];
        $categoria_torneo=trim($filator["categoria"]);
        $modal_torneo=$filator["modalidad"];
        $condicion=$filator["condicion"];
        $entidad=$filator["entidad"];
        $numero=$filator["numero"];
        $fechadecierre= $filator["fechacierre"]; //fecha que se presenta en la pantalla
        
        $fecha_inicio_torneo= $filator["fecha_inicio_torneo"]; //fecha que se presenta en la pantalla
        
        $fecha_retiros= $filator["fecharetiros"]; //fecha que se presenta en la pantalla
        $estatus="Inscrito";
        $date_hoy=date_create(); // fecha del servidor 
        $fecha_hoy= date_timestamp_get($date_hoy);
        $date_bd = date_create($filator["fechacierre"]); // fecha cierre de inscripciones 
        $fecha_cierre =date_timestamp_get($date_bd);
        
        $date_bd= date_create($filator["fechainicio"]); // fecha inicio de inscripciones
        $fecha_inicio =date_timestamp_get($date_bd);
       
       if ($_SESSION['niveluser']==1){
            $fhoy= date_create();
            $fhoy= date_format($fhoy,"Y-m-d");
            $fecha_cierre = Fecha_Cierre_Admin($fecha_inicio_torneo);
            $fecha_inicio = Fecha_Inicio_Admin($fhoy);
          
        }else{
            $fecha_inicio = Fecha_Apertura_Calendario($filator["fechacierre"],$filator["tipo"]);
        }
        
        $dias_diferencia=intval(($fecha_hoy-$fecha_cierre)/86400);
        
       
        //Ranking del grado del torneo
        
        
       
        $array_Categoria= explode(',',trim($filator["categoria"]));
        $array_ranking=NULL;
        for($x=0;$x<count($array_Categoria);$x++){
            //Tomamos la categoria de la subcategoria(12B)
            $rk_categoria=  substr($array_Categoria[$x],0,2);
            
            $sqlrk="SELECT rknacional,fecha_ranking FROM ranking  "
                . "WHERE atleta_id=$atleta_id AND categoria='".$rk_categoria."'"
                ." ORDER BY fecha_ranking DESC LIMIT 1";
            $result_rkn = mysql_query($sqlrk);
            $recordRanking = mysql_fetch_array($result_rkn);
            if ($recordRanking){
                $rkn = $recordRanking["rknacional"];
            }else{
                $rkn=999;
            }
            $array_ranking[]=$rkn;
        }
        //Combinamos el arreglo de ranking y categoria como clave
        $array_ranking_categoria = array_combine( $array_ranking,$array_Categoria);
        
        
        //Buscamos ranking de la categoria Natural
        $la_categoria_natural= categoria_natural(($mi_ano_Nacimiento));
        $sqlrk="SELECT rknacional,fecha_ranking FROM ranking  "
                . "WHERE atleta_id=$atleta_id AND categoria='".$la_categoria_natural."'"
                ." ORDER BY fecha_ranking DESC LIMIT 1";
        $result_rkn = mysql_query($sqlrk);
        $recordRanking = mysql_fetch_array($result_rkn);
        if ($recordRanking){
            $rkn = $recordRanking["rknacional"];
        }else{
            $rkn=999;
        }
                       
        
        //20181001
        //
        //Categoria de juego
        $array_Categoria= explode(',',trim($filator["categoria"])); //Array de categoria
        $array_Ano_Nacidos = explode ('-', $filator["anodenacimiento"]); // Array Ano de Nacimiento permitido en el torneo
        $array_Ano_Categoria= array_combine ($array_AnodeNacimiento , $array_Categoria ); // une dos arreglos y devuelve uno asociativo
        $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 
        
        
        
        if ($array_Ano_Nacidos[0]!=Null && count($array_Ano_Nacidos)>0 ){
            $contador= $array_Ano_Nacidos[1]-$array_Ano_Nacidos[0];
            if ($contador>0 && $contador<99){
                for ($x=0;$x<=$contador;$x++){
                    $array_ano_nacimiento[]=  strval($array_Ano_Nacidos[0] + $x);
                    $array_ano_categoria[]=  (count($array_Categoria)<$contador ? $array_Categoria[0] : $array_Categoria[$x]);
                    
                    
                }
                $array_Ano_Categoria= array_combine ($array_ano_nacimiento , $array_ano_categoria ); // une dos arreglos y devuelve uno asociativo
       
                $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 
        
            }
//                   echo  "<pre>";
//                    var_dump($mi_Categoria_Estricta);
//                    var_dump($array_Ano_Categoria);
//                    
//                    echo "</pre>"; 
//                    die();
                   
            if (in_array($mi_ano_Nacimiento , $array_ano_nacimiento,true)) { // buscamos un string en el arreglo
                $puedeInscribir=true;
            }else{
                $puedeInscribir=false;
            }
            
        } else{
            // Evalua por categoria natural y grado
            //$mis_Categoria=categoria_Torneo($mi_ano_Nacimiento);
            $mis_Categoria=  Categoria_Grado_Torneo($mi_ano_Nacimiento, $array_ranking_categoria, $grado_torneo, $rkn);
            $array_mi_Categoria=explode(',',$mis_Categoria);
            $mi_Categoria_Estricta=NULL;

            
            $puedeInscribir=false;
            for ($x=0 ; $x < count($array_Categoria); $x++){
                if (in_array($array_Categoria[$x],$array_mi_Categoria,true)){
                    $puedeInscribir=true;
                }
            }
        }
        
        //Los torneos Nacionales o Regionales estan permitidos solo para los afiliados
        //y los estadales para todos los atletas del pais.
        $empresa_id=$_SESSION['empresa_id'];
        
        //idempre del Administrador de la asociaicon con clave master
        $empresa_id_admin=$_SESSION['empresa_id_admin'];
        
        
            
        $torneo_permitido=true;
        //El afiliado tiene solicitado el servicio pero aun no la ha pagado
        //por tanto se le permite ver las inscripciones de forma inhabilitado
        
      
        //Busca el estado que oferta los torneos G4
        if ($torneo_permitido){
           //ACTIVAR CUADO HAY NUEVAS ASOCIACIONES
           $sql2 = "SELECT estado FROM empresa WHERE  empresa_id=".$filator["empresa_id"]; 
          
           $result2 = mysql_query($sql2);
           $row = mysql_fetch_array($result2);
            if ($row){
                $asociacion=$row["estado"];
            }else{
                $asociacion="N/A";
            }
           
        }
   
        if ( $fecha_hoy>$fecha_inicio &&  $fecha_hoy <$fecha_cierre && $puedeInscribir && $torneo_permitido){
          $nrotorneos++;
            
            $record_encontrados ++;
            $consulta_mysql = "SELECT modalidad,categoria,torneoinscrito_id,pagado FROM torneoinscritos "
                    . "WHERE torneo_id=$torneo_id AND atleta_id=$atleta_id";
            $resultado_SQL_inscritos = mysql_query($consulta_mysql);

            $row = mysql_fetch_array($resultado_SQL_inscritos);
            
            $array_modalidad=NULL;
            if ($row){
                $flaginscrito=true;
                $array_modalidad=  explode(",",$row["modalidad"]);
                $categoriainscrita=$row["categoria"];
                $torneo_inscrito_id=$row["torneoinscrito_id"];
                $torneopagado = $row["pagado"];
               
                
            }else{
                 $flaginscrito=false;
                 
                 $torneo_inscrito_id=0;
                 $categoriainscrita=($mi_Categoria_Estricta!=NULL) ? $mi_Categoria_Estricta : NULL;
                 $torneopagado = 0;
                 $array_modalidad[]='SS';
            }
            
            if ($flaginscrito){
               $estatus="Ok";
               $chk="checked";
               $chkinscribe="disabled";
               $chkdesinscribe=" ";
                if ($torneopagado>0){
                    $chkdesinscribe="disabled";
                    $estatus = "Confirmado";
                }
                if ($_SESSION['niveluser']==1){
                    $chkinscribe=" ";
                }
            }else{
               $estatus="Open";
               $chk=" ";
               $chkinscribe=" ";
               $chkdesinscribe="disabled";
            }
            
           
            //Devuelve un arreglo con la table row a imprimir
            $array_tr= Torneo::Estatus_Inscripcion($estatus);

            //Determina el estatus del torneo(Factorizado)
            $estatus_torneo=  Torneo::Estatus_Torneo($fechadecierre, $fecha_inicio_torneo, $grado_torneo, $condicion);
            
            $deshabilitado= $_SESSION['niveluser']==1 ? FALSE : $_SESSION['deshabilitado'];
            if ($deshabilitado){
                //Validamos si la afiliacion esta confirmada
                $estatus = "Inactivo";
                $chk = "";
                $chkinscribe = "disabled";
                $chkdesinscribe = "disabled";
                $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                echo $array_tr[0];//echo '<tr class=" " >';
                echo $array_tr[1];//echo "<td><p class='glyphicon glyphicon-lock'></p></td>";
                
            }else{
                if  ($flaginscrito) {
                    if ($torneopagado>0){
                        $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                        echo $array_tr[0];//echo '<tr class="warning"  >  ';
                        echo $array_tr[1];//echo "<td><p class='glyphicon glyphicon-usd'></p></td>";
                    }else {
                        $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                        echo $array_tr[0];//'<tr class="success"  >  ';
                        echo $array_tr[1];//'<td><p class=" glyphicon glyphicon-ok"  ></p></td>  ';
                    }
                    
                }else{
//                    echo '<tr class=" " >';
//                    echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";
                   //Estatus abierto
                   $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                   echo $array_tr[0];//echo '<tr class=" " >';
                   echo $array_tr[1];//echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";
                   
                }
            }
                
                
            
            //LLENAMOS LA LINEA CON LOS DATOS
            if ($modal_torneo=="TDP"){
               $modalidad="Tenis de Playa" ;
            }else{
               $modalidad="Tenis de Campo" ;
            }
            
//            echo "<td data-toggle='tooltip' data-placement='auto' title='Estatus'>$estatus_torneo</td>";
            echo "<td data-toggle='tooltip' data-placement='auto' title='Entidad o Estado'>$entidad</td>";
            echo "<td data-toggle='tooltip' data-placement='auto' title='Grado'>$numero-$grado_torneo</td>";
//            echo "<td data-toggle='tooltip' data-placement='auto' title='Torneo'>$nombre_torneo</td>";
            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Cierre'>$fechadecierre</td>";
            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Retiro'>$fecha_retiros</td>";
            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Inicio'>$fecha_inicio_torneo</td>";
            echo '<td data-toggle="tooltip" data-placement="auto" title="Categoria">';
            $readonly='readonly';
            //Aqui imprimimos el Select para las opciones
            echo "<select $chkinscribe name='".$torneo_id."'>";
            if ($mi_Categoria_Estricta!=NULL){
                    
                 // Caso Estricto cuando los atletas deben jugar una categoria segun el ano de nacimiento
                 // manejado en el caso de un Master que son solo los nacidos en un ano(2000(26) 2002(14) y 2004(12)
                 // se deshabilita las opciones para que el usuario no puede cambiar la categoria que es por defecto
                 // definida en la carga.
                 for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
                    if ($array_Categoria[$x]!=$categoriainscrita){
                       echo "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                    }else{
                       echo "<option selected value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                    }
                }
                
             }else{
                    
                 
                // Caso no estricto el usuario puede seleccionar cualquier categoria de juego.
                // solo se pone en default la que ya ha seleccionado.
//                for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
//                    $selectedx= ($array_Categoria[$x]!=$categoriainscrita ? " " :" selected  ");
//                    echo "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
//                }
                
                for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
               
                    if (in_array($array_Categoria[$x],$array_mi_Categoria,true)){
                       $selectedx= ($array_Categoria[$x]!=$categoriainscrita ? " " :" selected  ");
                       echo "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                       
                    }else{
                        echo "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        
                       
                    }
                }
            }
            $dato=$torneo_id.",".$atleta_id.",".$torneo_inscrito_id.",".$categoriainscrita.",INS,".$codigo_unico;
             echo '</select>';
            echo "</td>";
           
            
            //Controlamos la modalidad de juego(single,doble,mixto)
            //Aqui se toma una categoria cualquiera. Considerando que las categorias
            //siempre juegan las mismas modalidades.
            //El solo hecho que una categoria tenga una modalidad definida
            //para la inscripcion;todas la asumen por defecto.
            
            //Tomamos la categoria en la posicion inicial[0] de $array_Categoria[0]
            //segun lo definido anteriormente.
            $rsmodalidades=NULL;
            $rsmodalidades =  Modalidad::ReadByCategoria($array_Categoria[0]);
            echo '<td data-toggle="tooltip" data-placement="auto" title="Ctrl + Click">';
            echo '<select multiple name="M'.$torneo_id.'[]" >';
            
            foreach ($rsmodalidades as $value) {
                $select=" ";
                if (in_array($value[modalidad],$array_modalidad,true)){
                   $select=" selected ";
                }
                echo '<option '. $select .'value="'.$value[modalidad].'">'.$value[descripcion].'</option>';
            }
             
            echo '</select>';
            echo "</td>";
            
            //Check de Apuntar y Borrar
            echo "<td> <input  type=\"checkbox\"  name=\"chkinscribir[]\" value=\"$dato\" $chk $chkinscribe></td> ";
            echo "<td> <input  type=\"checkbox\"  name=\"chkeliminar[]\" value=\"$dato\" $chkdesinscribe ></td> ";
            
           
            if (!$deshabilitado){
                echo "<td><a href='../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t=".
                        urlencode(Encrypter::encrypt($codigo_torneo)). "' target='_blank'</a>Ver</td>";
            }else{
                echo "<td><a  target='_blank'</a>Ver</td>";
            }
            
           
            echo '</tr>';
            

        }
      }
    
  }
  
//mysqli_close($conn);mysqli
mysql_close($conn);


  echo "</table>";
 
 echo "                      </div>";
 echo "                   </div>";
 echo "              </section>";
 echo "          </div>";
 echo "       </div>";
 if ($nrotorneos>0){
 echo '<div class="pull-right ">
        <!-- <a  href="sesion_usuario.php"> <button type="button" class="btn btn-info" >Regresar</button></a> -->
          <input  type="submit" name="btnProcesar" value="Guardar" class="btn btn-primary" > 
        
        </div> ';
 
 }else{
    
    echo '<p class="alert alert-warning">'.Bootstrap_Class::texto("Mensaje :").' No hay Torneos disponibles en este momento.</P>';
    
 } 

 //Lado 2 Right
//    echo '<div class="col-lg-4">';
//        echo '<div class="mensaje">';
//        echo '<p class="alert alert-warning">'.Bootstrap_Class::texto("Notificacion :","success").' '
//               . 'En los torneos G1. G2, G3 y G4, solo podr&aacute inscribir un solo evento '
//               . 'en la misma fecha del calendario.</P>';
//
//        echo '</div>'; 
//        echo '<div class="mensaje">';
//            echo '<p class="alert alert-info">'.Bootstrap_Class::texto("Inscripcion :","success").' Para inscribir sigue los siguientes pasos:<br>
//                     1. Seleccione la categoria y la columna (Apuntar)<br>
//                     2. Luego pulsa el boton (Guardar).<br>
//                     3. El torneo seleccionado aparece de color verde agua</p>';
//        echo '</div>'; 
//    echo '</div>'; 
// 
// echo "</div>";
// 
 
 
 echo "</form>"; 
echo "</div> ";   //Container main

 
 
           
?>

<script>

//var myVar = setInterval(myTimer, 1000);

function myTimer() {
    var d = new Date();
    document.getElementById("hora").innerHTML = "Fecha: "+ myfecha(0)+" - "+"Hora: " + d.toLocaleTimeString();
    //document.getElementById("hora").innerHTML = myfecha()+"</br>"+d.toDateString() +"</br>"+"HORA: " + d.toLocaleTimeString();
}
function myfecha(conMeses){
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var f=new Date();
    if (conMeses===1){
        return  (f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    }else{
        return  (f.getDate()+ "/" + (f.getMonth()+1) +  "/" + f.getFullYear());
    }
}
function selectcategoria(obj) {
var valorSeleccionado = obj.options[obj.selectedIndex].value; 
   <?php 
    $categoriainscrita="<script> document.write(valorSeleccionado) </script>";
    $dato=$torneo_id.",".$atleta_id.",".$torneo_inscrito_id.",".$categoriainscrita.",INS";
    
  ?>
//   if ( valorSeleccionado == 1 ) {
//      // document.location = 'http://mipagina1.com' ;
//   }
//   if ( valorSeleccionado == 2 ) {
//      // document.location = 'http://mipagina2.com' ;
//   }
// etc..
}
</script>
</body>

</html>







 