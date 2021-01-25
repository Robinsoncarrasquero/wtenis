<?php
$myObj->name = "John";
$myObj->age = 30;
$myObj->city = "New York";
$myObja->name = "Rob";
$myObja->age = 55;
$myObja->city = "Caracas";

$myJSON = json_encode($myObj);

echo $myJSON;

$amyJSON = json_decode($myJSON,true);
echo '<br>';
var_dump($amyJSON);
echo '<br>Cadena:<br>';

$i=0;
$array='[{"name":"chkretirar[]","value":"644,3810,21234,12,RET"}]';

foreach($amyJSON as $key=>$value){
    echo "$i ".$key ." : ";
    echo $value;
    echo "<br>";
    $i++;
    
}

$myJSON='[{"name":"chkretirar[]","value":"644,3810,21234,12,RET"}]';
$amyJSON = json_decode($myJSON,true);
var_dump($amyJSON);
echo 'Lista : datos ';
$i=0;
foreach($amyJSON as $key=>$value){
    echo "<br>";
    echo "$i ".$value['name'] ." : ";
    echo $value['value'];
    echo "<br>";
    $i++;
    
}

