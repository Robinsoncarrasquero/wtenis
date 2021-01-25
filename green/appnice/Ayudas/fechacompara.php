<?php

date_default_timezone_set('America/Caracas');
//$val1 = '2015-07-17 06:59:01.000';
//$val2 = '2015-07-17 06:59:00.000';
//
//$datetime1 = new DateTime($val1);
//$datetime2 = new DateTime($val2);
//echo "<pre>";
//var_dump($datetime1->diff($datetime2));
//
//if($datetime1 > $datetime2)
//  echo "1 is bigger";
//else
//  echo "2 is bigger";



$date_hoy=date_create();
$fecha_hoy= date_timestamp_get($date_hoy);
$date_bd = date_create('2015-07-17 08:59:00');
$fecha_bd =date_timestamp_get($date_bd);
echo "<pre>";
var_dump($fecha_hoy);
var_dump($fecha_bd);

if($fecha_hoy > $fecha_bd)
  echo "la fecha 1 is mayor";
else
  echo "la fecha 2 is mayor";
//$date=date_create();
//echo date_timestamp_get($date);
?>
