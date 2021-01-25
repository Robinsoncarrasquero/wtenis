<?php
$to = "robinson.carrasquero@gmail.com";
$subject = "Inscripcion a torneo 3G31418";
$txt = "Probando desde GMAIL!";
$headers = "From: info@tenismiranda.com.ve" . "\r\n" .
"CC: pagos@tenismiranda.com.ve";

mail($to,$subject,$txt,$headers);
?>