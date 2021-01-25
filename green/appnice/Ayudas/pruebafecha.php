<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'conexion.php';
// Create connection
require_once 'funcion_fecha.php';
$conn = new mysqli($servername, $username, $password, $dbname);

 $cedulaid="28472989";
 $consulta_mysql = "SELECT * FROM atleta WHERE cedula='".$cedulaid."'";
 
  $result_atleta = mysql_query($consulta_mysql);
  while ($fila = mysql_fetch_assoc($result_atleta )) 
                
    {
      $atleta_id=$fila["atleta_id"];
      $cedula=$fila["cedula"];
      $nombre= $fila["nombres"];
      $apellido= $fila["apellidos"];
      $fechan= $fila["fecha_nacimiento"];
      $fechanac =  anodeFecha($fechan);
      $ano=date ("Y");  
      echo '<pre>';
        var_dump($fechanac).'</br>';
        var_dump($ano).'</br>';
      echo '</pre>';
    }
    




