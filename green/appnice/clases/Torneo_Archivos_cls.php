<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud
 *
 * @author robinson
 */
class Torneo_Archivos   {
    //put your code here
    private $id;
    private $tipo;
    private $doc;
    private $torneo_id;
    private $fecha_registro;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneo_archivos';
    const CAMPOS='(torneo_id,tipo)';
    const VALORES='(:torneo_id,:tipo)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->id=0;
        $this->tipo=  NULL;
        $this->fecha_registro=  NULL;
        $this->doc=  NULL;
        $this->torneo_id=NULL;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    
    public function ID() {
        return $this->id;
    }

    public function getTorneo_id() {
        return $this->torneo_id;
    }

    public function setTorneo_id($value) {
        $this->torneo_id = $value;
    }

    
    
    public function getDoc() {
        return $this->doc;
    }

    public function setDoc($value) {
        $this->doc = $value;
    }

    public function getTipo() {
        return $this->tipo;
    }
    
    public function getFecha_Registro() {
        return $this->fecha_registro;
    }

    public function setTipo($value) {
        $this->tipo = $value;
    }

    public function getContenido() {
        $mifile = explode("/", $this->tipo);
        $files = explode(",", "pdf,xls,xlxs,png,jpg,bmp");
        $imagen = explode(",", "png,jpg,bmp");
        if (in_array($mifile[0], $files)) {
            header('Content-type:$this->tipo');
            $file = $this->contenido;
        }
        if (in_array($mifile[0], $imagen)) {
            $file = base64_encode($this->contenido);
        }
        return $file;
    }

    public function setContenido($value) {
        $newvalue = file_get_contents($value);
        $this->contenido = $newvalue;
    }

    public function Operacion_Exitosa() {
        return $this->SQLresultado_exitoso;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function create(){
       try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $campos = '(torneo_id,tipo,doc)';
            $valores = '(:torneo_id,:tipo,:doc)';
            $SQL = $conn->prepare('INSERT INTO ' . self::TABLA . $campos . ' VALUES ' . $valores);
            $SQL->bindParam(':torneo_id', $this->torneo_id);
            $SQL->bindParam(':tipo', $this->tipo);
            $SQL->bindParam(':doc', $this->doc);
            $SQL->execute();
            $this->id = $conn->lastInsertId();

            //echo "New records created successfully";
            $this->mensaje = 'New records created successfully';
            $this->SQLresultado_exitoso = TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $this->mensaje="Error Create: " . $e->getMessage();
            $this->SQLresultado_exitoso=FALSE;
        }
        $conn = NULL;
        
    
    }
    
    public function Update(){
        
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQLstr = ' SET torneo_id = :xtorneo_id,'
                    . ' tipo = :xtipo, doc=:xdoc ';

            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQLstr . ' WHERE id = :xid');
            $stmt->bindParam(':xid', $this->id);
            $stmt->bindParam(':xtorneo_id', $this->torneo_id);
            $stmt->bindParam(':xtipo', $this->tipo);
            $stmt->bindParam(':xdoc', $this->doc);
            $stmt->execute();

            //echo "New records created successfully";
            $this->mensaje = 'Record update successfully';
            $this->SQLresultado_exitoso = TRUE;
        } catch (PDOException $e) {
            //echo "Error: " . $e->getMessage();
            $this->mensaje = "Error Update: " . $e->getMessage();
            $this->SQLresultado_exitoso = FALSE;
        }
        $conn = null;
    
    }
    public function Delete($id){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE id= :id');
            $SQL->bindParam(':id', $id);
            $SQL->execute();

            $SQL->execute();

            //echo "New records created successfully";
            $this->mensaje = 'Record Delete successfully';
            $this->SQLresultado_exitoso = TRUE;
        } catch (PDOException $e) {
            //echo "Error: " . $e->getMessage();
            $this->mensaje = "Error Delete: " . $e->getMessage();
            $this->SQLresultado_exitoso = FALSE;
        }
        $conn = NULL;
       
    }
    
    
     public function Fetch($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE id = :id");
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            $this->torneo_id=$record['torneo_id'];
            $this->tipo= $record['tipo'];
            $this->fecha_registro=$record['fecha_registro'];
            $this->doc= $record['doc'];
            $this->id=$record['id'];
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
    
    public static function FindDocument($torneo_id,$documento) {
        $model = new Conexion();
        $conn = $model->conectar();
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE torneo_id = :id && doc= :doc');
        $SQL->bindParam(':id', $torneo_id);
        $SQL->bindParam(':doc', $documento);
        
        $SQL->execute();
        $record = $SQL->fetch();
        if ($record) {
            $SQLresultado_exitoso = TRUE;
            $mensaje = "Record Found : " ;
           
        } else {
            $SQLresultado_exitoso = FALSE;
            $mensaje = "Record Not Found : " ;
            
        }
        
        $conn = NULL;
        return $record;
    }
    
    public function ReadAll($torneo_id) {
        $model = new Conexion();
        $conexion = $model->conectar();
        $SQL = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE torneo_id=' . $torneo_id . ' ORDER BY documento');
        $SQL->execute();

        $registros = $SQL->fetchall();

        if ($SQL->rowCount() == 0) {

            $this->SQLresultado_exitoso = FALSE;
            $errorCode = $conexion->errorCode();
            $errorInfo = $conexion->errorInfo();
            $this->mensaje = "Record Not Found : " . $errorInfo;

            switch ($errorCode) {
                case 00000:
                    $this->mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $this->mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        } else {

            $this->mensaje = 'Records Found successfully';
            $this->SQLresultado_exitoso = TRUE;
        }



//        while ($record = $consulta->fetch())
//        {
//           $this->rows[]=$record;
//          
//           
//        }
        $conexion = NULL;

        return $registros;
    }
    public function load_fields_table() {
        
        $model = new Conexion();
        $conexion=$model->conectar();
        
        $sql=" SELECT TABLE_NAME,COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,ORDINAL_POSITION FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA='". self::TABLA."' && TABLE_NAME='". self::TABLA. "' ORDER BY TABLE_NAME";
        $SQL = $conexion->prepare($sql);
        $SQL->execute();
        while ($record = $SQL->fetch())
        {
           $this->fields[]=$record;
           
        }
        
        $this->fields_count=  count($this->fields); // numero de campos en el arreglo devuelto;
        
        $conexion=NULL;
    }
    
    public function valida_fields_table()
    {
        $objeto=$this->fields;
        echo '<pre>';
        var_dump($objeto->fields[0]);
        echo '</pre>';
        for ($i=0;$i<$objeto->fields_count;$i++){
            //$datos_bd= array($record->name=>$record[$records->name]);
            echo '<pre>';
            var_dump($objeto->fields[$i]);
            
            echo '</pre>';
        }  
        
        
    }
    public function fields_change($field,$value)
    {
        
        if ($this->rows[0][$field]!=$value){
            $this->dirty=TRUE;
//            echo '<pre>';
//            var_dump("Campor Record:".$this->rowschange[0][$field]);
//            var_dump("Campo Post:".$field ."-".$value);
//            
//            echo '</pre>';
            
        }
        
        
    }
    public function isDirty()
    {
        
        return $this->dirty;
       
    }
    
      
    
    
}
               