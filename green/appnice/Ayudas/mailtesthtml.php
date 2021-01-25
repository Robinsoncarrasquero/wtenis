<?php
$to = "robinson.carrasquero@gmail.com, robinson@cantv.net";
$subject = "HTML email test";

$message = "
<html>
<head>
<title>HTML email test</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@tenismiranda.com.ve>' . "\r\n";
$headers .= 'Cc: pagos@tenismiranda.com.ve' . "\r\n";

mail($to,$subject,$message,$headers);
?>