<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
$archivo = "libro1.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
for ($row = 2; $row <= $highestRow; $row++){ 
		echo $sheet->getCell("A".$row)->getValue()." - ";
		echo $sheet->getCell("B".$row)->getValue()." - ";
		echo $sheet->getCell("C".$row)->getValue();
		echo "<br>";
}
?>
</body>
</html>
