<?php

include 'fun.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//echo(mt_rand() . "<br>");
//echo(mt_rand() . "<br>");
//echo(mt_rand(0,1));

$array_siembra=sorteo32_siembras();


foreach ($array_siembra as $key => $value) {
    echo "<br>";
     var_dump($key." ".$value);
}
echo "<br>";
$BYE=7;
$array_bye=sorteo_bye32($BYE);
//var_dump($array_bye);
echo "<br>";
foreach ($array_bye as $key => $value) {
    echo "<br>";
    var_dump($key." ".$value);
}
echo "<br>";
$array_bye2= sorteo_bye32_adicionales($BYE);
var_dump($array_bye2);
echo "<br>";
foreach ($array_bye2 as $key => $value) {
    echo "<br>";
    var_dump($key." ".$value);
}

//Ubicar las posiciones disponibles
$array_dif= sorteo32_dif($array_siembra, $array_bye,$array_bye2);
echo "<br>";
var_dump($array_dif);
echo "<br>";


foreach ($array_dif as $key => $value) {
    echo "<br>";
    var_dump($key." ".$value);
}
echo "<br>";
echo "<br>";
$array_final= sortear_jugadores($array_dif,$BYE);

foreach ($array_final as $key => $value) {
    echo "<br>";
    var_dump($key." ".$value);
}




        
        
        
        

   
?>

