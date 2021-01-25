<?PHP
require 'conexion.php';
//require 'src/Cpdf.php';
header('Content-Type: text/html; charset=utf-8');
session_start();
 if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: sesion_inicio.php');
    exit;
 }
// Defines the default timezone used by the date functions
date_default_timezone_set('America/Caracas');
$codigo_torneo=(isset($_GET['torneo'])) ? $_GET['torneo'] : null;
$categoria=(isset($_GET['categoria'])) ? $_GET['categoria'] : null;
$sexo=(isset($_GET['sexo'])) ? $_GET['sexo'] : null;
$miurl="http://localhost:84/Inscripcion/datainscritos_torneo.php?torneo=4G41418 & sexo= & categoria=";

?>

<html>
<head>
<title>Formulario para generar listado en pdf</title>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<a href="inscripcion.php"> <img id="Logo" src="images/logo.png"  ></a>
 <link rel="StyleSheet" href="css/inscribe.css" type="text/css">
</head>
<body>
<!--<h2>GENERACION DE LISTADO DE ATLETAS PARA INSCRIPCION DE TORNEO</h2>
<div class="frmlogin" >
     
    <form name="frmpdf" method="GET" action="inscripcion_Consulta_inscritos.php">
        
        <label for="usuario">Torneo Ej:(1G21216) </label> 
        <input type="text" name="torneo" required="required" /><br />
        <label for="usuario">Categoria Ej:(16)   </label> 
        <input type=’text’ name="categoria"/><br/><br/>
        <label for="usuario">Sexo Ej:(F)   </label> 
        <input type=’text’ name="sexo" /><br/><br/>
        <input type="submit"  value="Buscar inscritos" />
       
       
        <div class="menuuser" >
        <p id="menuuop1"> <a href="sesion_usuario_admin.php">Regresar al Menu</a> </p>
        <p id="menuuop2"> <a href="sesion_cerrar.php">Cerrar Mi Sesion </a> </p>
        </div>
        
        <div class="msgerror" >
            <?php if(isset($error_login)): ?>
               <span><?php $mensaje?> </span>
            <?php endif; ?>
        </div>
    </form>
    
    
    
    
</div-->

<h1>Listado de Atletas inscritos</h1>
<div id="id02"></div>

<script type="text/javascript">
var xmlhttp = new XMLHttpRequest();
var url = "http://localhost:84/Inscripcion/datainscritos_torneo.php";
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        myFunction(xmlhttp.responseText);
    }
}
xmlhttp.open("post", url, true);
xmlhttp.send("torneo=4G41418&categoria=14");

function myFunction(response) {
    var arr = JSON.parse(response);
    var i;
    var out = "<table> ";
    for(i = 0; i < arr.length; i++) {
        out += "<tr><td>" +
        arr[i].Categoria +
        "</td><td>" +
        arr[i].Ranking  +
        "</td><td>" +
        arr[i].Estado +
        "</td><td>" +
         arr[i].FechaNacimiento +
        "</td><td>" +
        arr[i].Nombre +
        "</td><td>" +
        arr[i].Apellido +
        "</td><td>" +
        arr[i].Cedula +
        "</td><td>" +
        arr[i].Inscripcion +
        "</td></tr>";
    }
    out += "</table>";
    document.getElementById("id02").innerHTML = out;
}

</script>
    
    

</body>
</html>