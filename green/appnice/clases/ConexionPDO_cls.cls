<?php 
define("MODO_DE_PRUEBA", "1");  // Esta variable define cuando tenemos la aplicacion 
                                //en modo_de_prueba para evitar el envio de correos(1=true 0=false)
define("MODO_DE_TEST", 1); // Modo de Test para apuntar al servidor de test o produccion
 class Conexion extends PDO { 
   private $tipo_de_base = 'mysql';
   private $host = 'localhost';
   private $nombre_de_base = 'atletasdb';
   private $usuario = 'root';
   private $contrasena = ''; 
   
   
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
         parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
      }catch(PDOException $e){
        print 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage() . "<br/>";
        die();
        exit;
      }
   } 
 } 
?>
