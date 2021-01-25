<?php
session_start();

require_once 'conexion.php';

    
    $conn =  mysql_connect($servername, $username, $password);
    $result=mysql_select_db($dbname,$conn);
    

$id=$_GET['id'];
$doc=$_GET['doc'];
$qry = "SELECT tipo, contenido FROM torneo_archivos  WHERE torneo_id=$id && documento='$doc'";

 $result = mysql_query($qry);
 $tipo = mysql_result($result, 0, "tipo");
 $contenido = mysql_result($result, 0, "contenido");

 header("Content-type: $tipo");
 print $contenido; 
 
 