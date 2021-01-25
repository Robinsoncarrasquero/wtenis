<?PHP
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_fecha.php';
//require '../funciones/funcion_excepciones.php';
require_once '../src/Cezpdf.php';

header('Content-Type: text/html; charset=utf-8');
//$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$estatus=(isset($_GET['estatus'])) ? $_GET['estatus'] : null; // Inscrito o Retirado

$chkpagado=(isset($_GET['chk'])) ? $_GET['chk']: 1;

if ($codigo_torneo!=null)
{ 
    $codigo_torneo=strtoupper(mysql_real_escape_string($codigo_torneo));
    $categoria=  strtoupper($categoria);
    $categoria=mysql_real_escape_string($categoria);
    $sexo=  strtoupper($sexo);
    $sexo=mysql_real_escape_string($sexo);
    
    //Obtenemos los registros desde MySQL
    //Ahora procedemos a extraer los registros de nuestra base de datos, 
    //en este caso solo obtenemos el nombre, dirección y telefono de la tabla empresa de nuestra base de datos.
    $conexion = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname, $conexion);
    mysql_query('SET NAMES "utf8"');
    //mysqli_query($conexion, 'SET NAMES "utf8"');
    //$codigo_torneo = mysql1_real_escape_string($conexion, $codigo_torneo);
    //$categoria = mysql1_real_escape_string($conexion, $categoria);
    $categoria = trim($categoria);
    $codigo_torneo = trim($codigo_torneo);
    $sql = "SELECT tipo_torneo,nombre as nombre_torneo FROM torneo where codigo='".$codigo_torneo."'";
    $result = mysql_query($sql, $conexion) or die(mysql_error());
    $record = mysql_fetch_assoc($result);
    $nombre_torneo=$record['nombre_torneo'];
  
    $queEmp = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, atleta.cedula,"
            . "atleta.sexo,DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%Y') as fechanac,"
        ."torneoinscritos.categoria as categoria, CONCAT(torneoinscritos.categoria,'-',atleta.sexo) as Categoria_Sexo,"
            . "torneoinscritos.fecha_registro,torneoinscritos.fecha_ranking,"
            . "torneoinscritos.pagado,torneo.fecha_fin_torneo,torneo.empresa_id,"
            . "torneoinscritos.afiliado,torneoinscritos.modalidad,"
        .'torneoinscritos.rknacional as elranking '
        ."FROM atleta "
        . "INNER JOIN torneoinscritos on atleta.atleta_id=torneoinscritos.atleta_id "
        . "INNER JOIN torneo on torneoinscritos.torneo_id=torneo.torneo_id "
        . "WHERE torneo.codigo='$codigo_torneo'";
   
        if ($estatus!=null){
            $queEmp .=" AND torneoinscritos.estatus='". $estatus."'";
        }
        if ($sexo!=null){
          $queEmp .=" AND atleta.sexo='".$sexo."'";
        }
        if ($categoria!=null) {
             $queEmp .=" AND torneoinscritos.categoria='".$categoria."' ";
        }
        if ($chkpagado==0){
           $queEmp .=" AND torneoinscritos.pagado=1 ";
        }
          
    
    $queEmp.=" ORDER BY Categoria_Sexo,elranking";
    $resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
    $totEmp = mysql_num_rows($resEmp);
    //Creando el array de datos, títulos y opciones
    //A continuación procedemos a crear matrices que luego utilizaremos en la creación de nuestro PDF, en el caso que deseemos incluir una tabla con con datos debemos crear una matriz con estos datos, en nuestro caso asignamos los resultados de la consulta y le agregamos un campo adicional con un numero correlativo. Lo siguiente es crear la matriz con los nombres de la tabla, en este caso llamamos a esta matriz $titles en donde a cada campo agregado a la matriz de datos le hacemos corresponder un nombre que aparecerá como titulo de la fila. La tercera matriz indica los colores de las celdas, la orientación y el ancho de la tabla.
    $ixx = 0;
    $ano_afiliacion=date("Y");
   
    while($datatmp = mysql_fetch_assoc($resEmp)) {
        $ixx++;
        $atleta_id=$datatmp['atleta_id'];
        $afiliado=$datatmp['afiliado'];
        $empresa_id=$datatmp['empresa_id'];
        $fecha_fin_torneo=$datatmp['fecha_fin_torneo'];
        $confirmado= ($datatmp['pagado']) ? "Y" :"N";
        //Aqui controlamos para que los no afiliados salgan en listado despues de 2 horas de cerrado el
        //las inscripciones
        $data[] = array_merge($datatmp, array('num'=>$ixx,'confirmado'=>$confirmado));
        
    }
     
    $titles = array(
                    'num'=>'<b>#</b>',
                    'cedula'=>'<b>Cedula</b>',
                    'apellidos'=>'<b>Apellidos</b>',
                    'nombres'=>'<b>Nombres</b>',
                    'fechanac'=>'<b>Fec.Nac</b>',
                    'Categoria_Sexo'=>'<b>Cat</b>',
                    'elranking'=>'<b>Rk</b>',
                    'estado'=>'<b>Edo</b>',
                    'confirmado'=>'<b>Confirmado</b>'
                );
    $options = array(
                    'shadeCol'=>array(0.9,0.9,0.9),
                    'xOrientation'=>'center',
                    'width'=>500
                );
    //Imprimiendo los Resultados
    //Una vez que tenemos todos los datos preparados procedemos a generar el PDF con toda la información que deseamos. 
    //Iniciamos esto creando un titulo y subtitulo de texto, 
    //luego escribimos los resultados de la consulta con la función ezTable a la cual se pasamos los datos, títulos y opciones. 
    //Finalmente al final del documento agregamos la fecha y hora de la generación del documento.

    switch ($sexo){
        case "F":
            $txttit2= "Categoria(".$categoria." FEM.)";
            break;
        case "M":
            $txttit2= "Categoria(".$categoria." MAS.)";
            break;
        default :
            $txttit2= "";
            
    }

    $txtsistit = "FEDERACION VENEZOLANA DE TENIS";
       
    if ($estatus!=null){
        $txttit  = "Listado de Atletas Retirados del Torneo:$nombre_torneo($codigo_torneo) $txttit2\n";       
    } else{
        $txttit  = "Listado de Atletas Inscritos en el Torneo:$nombre_torneo($codigo_torneo) $txttit2\n";
    }
    include ('class.ezpdf.php');

    $pdf = new Cezpdf();
    //$pdf->selectFont('Helvetica');
    $pdf->selectFont('Courier');
    
    //$pdf->selectFont('../fonts/Courier.afm');
    $size=8;
    $pdf->getFontHeight($size);
  
    $pdf->ezSetCmMargins(1,1,1,1);
    $pdf->ezText($txtsistit, 10);
    $pdf->ezText($txttit, 10);

    $pdf->ezTable($data, $titles, '', $options);
//    $pdf->ezText("\n\n\n", 10);
//    $pdf->ezText("Fecha: ".date("d/m/Y"), 10);
//    $pdf->ezText("Hora: ".date("H:i:s")."\n\n", 10);
     $pdf->ezStream();//abrir el pdf de forma automatica
    //$output = $pdf->ezOutput(1); //Salida de archivo
//    file_put_contents('pdf/mipdf.pdf', $output); //guardar en el server
    mysql_close($conexion);
    //Unimos todos estos bloques y tenemos listo nuestro script para generar reportes en PDF,
    //pueden ver el ejemplo funcionando en php-mysql.php. 
    //Para finalizar les dejo los archivos del ejemplo para que lo prueben y modifiquen a sus necesidades.
    }
else {
    $error_login=true;
    $mensaje="NO HAY DATOS PARA LA INFORMACION SOLICITADA";
    
}

?>

<html>
<head>
<title></title>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

 <link rel="StyleSheet" href="../css/inscribe.css" type="text/css">
 
 <style>
    body {
    margin: 30mm 8mm 2mm 8mm;
    }
    body { font-size: 12px; }
   .texto { font-size: 1em; }

    @media (max-width: 320px) {
      .texto { font-size: 2em; }
    }
    .table-head { font-size: 12px; }
    td{
       font-size: 10px;
    }
</style>
</head>


<body>
<h2>LISTADO DE ATLETAS</h2>

<div class="frmlogin" >
     
    <form name="frmpdf" method="GET" action="" target="_blank">
        
        <label for="usuario">Torneo Ej:(1G21216) </label> 
        <input type="text" name="torneo" required="required" /><br />
        <label for="usuario">Categoria Ej:(16)   </label> 
        <input type=’text’ name="categoria" /><br/><br/>
        <label for="usuario">Sexo Ej:(F)   </label> 
        <input type=’text’ name="sexo" /><br/><br/>
        <input type=’text’ name="estatus" hidden="hidden" /><br/>
        <input type="submit"  value="Imprimir Listado" />
       
       
        <div class="menuuser" >
        <p id="menuuop1"> <a href="../sesion_usuario_admin.php">Regresar al Menu</a> </p>
        <p id="menuuop2"> <a href="../sesion_cerrar.php">Cerrar Mi Sesion </a> </p>
        </div>
        
        <div class="msgerror" >
            <?php if(isset($error_login)): ?>
               <span><?php $mensaje?> </span>
            <?php endif; ?>
        </div>
    </form>
    
    
    
    
</div

    
    

</body>
</html>