<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Encriptar_cls.php'; 
$conn =  mysqli_connect($servername, $username, $password);
$resultdb=mysqli_select_db($conn,$dbname);

$id=  Encrypter::decrypt($_GET['thatid']);
$doc=  Encrypter::decrypt($_GET['thatdoc']);
$qry = "SELECT tipo, filename,folder FROM torneo_archivos  WHERE torneo_id=$id && doc='$doc'";

$result = mysqli_query($conn,$qry);
$row = $result -> fetch_assoc();

$tipo = $row["tipo"];
$tmpName=$row["folder"].$row["filename"];
$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));

header("Content-type: $tipo");
print $content; 

 