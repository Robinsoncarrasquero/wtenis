<?php
$to = "robinson.carrasquero@gmail.com";
$subject = "Inscripcion a torneo 3G31216";
$txt = "Hello world!";
$headers = "From: info@tenismiranda.com.ve" . "\r\n" .
"CC: pagos@tenismiranda.com.ve";

mail($to,$subject,$txt,$headers);
?>