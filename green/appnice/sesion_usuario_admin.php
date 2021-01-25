<?php
session_start();
header('Location: bsPanel.php');
exit;

if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
   $nombre = $_SESSION['nombre'];
   $cedula =$_SESSION['cedula'];
   $_SESSION['menuuser'] = $_SERVER['PHP_SELF'];
}else{
   //Si el usuario no está logueado redireccionamos al login.
   header('Location: sesion_inicio.php');
   exit;
}
$menutxt="menuuser.txt";
?>

<!DOCTYPE html>
<html>
 <head>
    <title>Administrador</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <?php include 'plantillas/head_logo.php'; ?>       
    
</head>
<body>
<?php //include 'plantillas/publinoticias.php';?>   
<div id="contenedor">
    <div class="menuuser">
        <h2> Bienvenido/a <?php echo $nombre; ?> </h2>   
        <p id="idmenu01"></p>
    </div>
    <div class="menuuser">
        
        <p id="mensaje_result"></p>
    </div>
    
    
</div>
<script>
var xmlhttp = new XMLHttpRequest();
var url ="<?php echo $menutxt; ?>";
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        myFunction(myArr);
    }
}

xmlhttp.open("POST", url, true);
xmlhttp.send();

function myFunction(arr) {
    var out = "";
    var i;
    for(i = 0; i < arr.length; i++) {
        out += '<p id="' + arr[i].id + '">' + '<a href="' + arr[i].url +   '">' + 
        arr[i].display + '</a></p>';
    }
    document.getElementById("idmenu01").innerHTML = out;
}
</script>
    

 </body>
</html>


