<div class="panel-body">
<?php
/* Conectar a una base de datos invocando al controlador */
$servername = "46.105.189.131";
$username = "gsscomve_prueba";
$password = 'jugador1234';
$dbname = "gsscomve_jugadores";

$hostname = "mysql:dbname=$dbname;host=$servername";
$usuario = 'root';
$contrasena = '';

try {
    $conn = new PDO($hostname, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Se ha conectado a la Base de Datos.<br>';

    $sql = 'SELECT nombres, apellidos FROM empleado';
    
    print "Nombre de Alumno:<br>";
    foreach ($conn->query($sql) as $row) {
		// Imprime datos de MySQL
        print "<b>".$row['nombres']."</b> <b>".$row['apellidos']."</b><br>";
    }
    $conn = null;

  }
  catch(PDOException $err) {
	  // Imprime error de conexión
    echo "ERROR: No se pudo conectar a la base de datos: " . $err->getMessage();
  }
?>
</div>
