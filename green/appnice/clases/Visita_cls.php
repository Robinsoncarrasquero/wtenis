<?php

/*
 * Clase derivada de la Superclase Crud Modelo de clase Abstracta para manejar el principio de Single Responsability
 */

class Visita{
    private $id;
    private $usuario;
    private $ip;
    private $atleta_id;
    private $nombre;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'visitas';
    
    public function __construct($ip,$usuario,$atleta_id,$nombre) {
        $this->id=0;
        $this->ip=$ip;
        $this->atleta_id=$atleta_id;
        $this->usuario=$usuario;
        $this->nombre=$nombre;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_id(){
        return $this->id;
    }
    
    public function get_ip(){
        return $this->ip;
    }
    public function get_usuario(){
        return $this->usuario;
    }
    public function get_atleta_id(){
        return $this->atleta_id;
    }
    public function get_nombre(){
        return $this->nombre;
    }
    
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
    public function Create(){
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $campos='(usuario,atleta_id,ip,nombre)';
            $valores='(:usuario,:atleta_id,:ip,:nombre)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':usuario', $this->usuario);
            $SQL->bindParam(':atleta_id', $this->atleta_id);
            $SQL->bindParam(':ip', $this->ip);
            $SQL->bindParam(':nombre', $this->nombre);
            $SQL->execute();
            $this->id = $conn->lastInsertId();
        
            //echo "New records created successfully";
            $this->mensaje='New records created successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $this->mensaje="Error Create: " . $e->getMessage();
            $this->SQLresultado_exitoso=FALSE;
        }
        $conn = NULL;
    
    }
    
    public function Find($id) {
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE visita_id = :id');
        $SQL->bindParam(':id', $id);
        $SQL->execute();
        $record = $SQL->fetch();
        $this->Record($record);
        $conn=NULL;
    }
     
    
    public function Update(){
        try {
           $objConn = new Conexion();
           $conn = $objConn->conectar();
           // set the PDO error mode to exception
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $SQL=' SET usuario = :usuario, ip = :ip, atleta_id = :atleta_id, nombre = :nombre';
           $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE visita_id= :id');
           $stmt->bindParam(':atleta_id', $this->atleta_id);
           $stmt->bindParam(':usuario', $this->usuario);
           $stmt->bindParam(':ip', $this->ip);
           $SQL->bindParam(':nombre', $this->nombre);
           $stmt->execute();

           //echo "New records created successfully";
           $this->mensaje='Record update..';
           $this->SQLresultado_exitoso=TRUE;
       }
       catch(PDOException $e)
       {
           //echo "Error: " . $e->getMessage();
           $this->mensaje="Error Update: " . $e->getMessage();
           $this->SQLresultado_exitoso=FALSE;
       }
       $conn = NULL;
   }

    public function Delete() {
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare("DELETE  FROM " . self::TABLA . ' WHERE visita_id = :id');
        $SQL->bindParam(':id', $this->id);
        $SQL->execute();
        $record = $SQL->fetch();
        $this->Record($record);
        $conn=NULL;
    }

   protected function Record($record) {
        if($record){
            $this->id=$record['visita_id'];
            $this->usuario=$record['usuario'];
            $this->atleta_id=$record['atleta_id'];
            $this->ip=$record['ip'];
            $this->nombre=$record['nombre'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
        
    }
    
}