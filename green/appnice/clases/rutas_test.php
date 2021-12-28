<?php
exit;
echo getcwd().PHP_EOL.'</BR>';
echo __DIR__.PHP_EOL.'</BR>';
echo __FILE__.PHP_EOL.'</BR>';
echo dirname(__FILE__)."</br>";
echo dirname(dirname(__FILE__));

echo $_SERVER['HTTP_HOST'].'</br>'.PHP_EOL;
//echo ($_SERVER['PHP_SELF']).PHP_EOL;


define('FILE_CONFIG',$_SERVER['DOCUMENT_ROOT'].'/wtenis/.env');
$partes_ruta = FILE_CONFIG;
echo var_dump($partes_ruta);


?>