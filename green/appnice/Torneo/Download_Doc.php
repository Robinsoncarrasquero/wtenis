<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Encriptar_cls.php'; 
$conn =  mysql_connect($servername, $username, $password);
$result=mysql_select_db($dbname,$conn);

$id=  Encrypter::decrypt($_GET['thatid']);
$doc=  Encrypter::decrypt($_GET['thatdoc']);
$qry = "SELECT tipo, filename,folder FROM torneo_archivos  WHERE torneo_id=$id && doc='$doc'";

$result = mysql_query($qry);
$tipo = mysql_result($result, 0, "tipo");
$contenido = mysql_result($result, 0, "contenido");
$folder=mysql_result($result, 0, "folder");
$filename=mysql_result($result, 0, "filename");
$conn = NULL;
$tmpName=$folder.$filename;
$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));

header("Content-type: $tipo");
print $content; 

 