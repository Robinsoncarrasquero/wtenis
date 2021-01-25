<!DOCTYPE html>
<html>
<body>

<?php
date_default_timezone_set('America/Caracas');

$format ="Y-m-d 17:00:00";
$date="2017-02-03 15:00:00";
$date = date_create($date); // Fecha Actual
//$date=  date_format($date2, $format);

//$date = date_create($date); // Fecha Actual
date_add($date,date_interval_create_from_date_string("2 Hour"));
echo date_format($date,"Y-m-d H:i:s");
echo "<br>";
echo date_timestamp_get($date);
echo "<br>";
$date_hoy=date_create(); // fecha del servidor 
echo date_format($date_hoy,"Y-m-d H:i:s");
echo "<br>";
echo date_timestamp_get($date_hoy);
if (date_timestamp_get($date_hoy)> date_timestamp_get($date)){
    echo "HOY ES MAYOR";
}else{
     echo "HOY ES MENOR";
    
}
    
?>

</body>
</html>


