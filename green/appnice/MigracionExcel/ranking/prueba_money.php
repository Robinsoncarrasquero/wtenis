<?php
//echo setlocale(LC_ALL, 0);


$precio = "1,025";
echo number_format("1025")."<br>";
echo number_format("1.025",2)."<br>";
echo number_format("1000000",2,",",".");

//$numero_formato_ingles = number_format($precio);
$numero_formato_ingles = number_format($precio, 0, '.', ',');

echo "<br>".$numero_formato_ingles . "\n";
echo '<table border=1><tr><td>Precio</td><td>Existencia</td><td>Tipo</td></tr>';
echo '<tr>';
		
echo '<td>'. $precio.'</td>';

echo '<td>'. $numero_formato_ingles.'</td>';
echo '<td>'. doubleval($numero_formato_ingles).' </td>';

    

echo '</tr>';
echo "</table>";