<?php

/*
 * Esta clase podemos manejar el detalle de los puntos de cada ranking para identiificar
 * los puntos ganados. Nacionales, Internacionales, etc.
 */

/**
 * Description of Crud
 *
 * @author robinson
 */
class RankingDetalleCodigo{
    //put your code here
   
    private $id;
    private $codigo;
    private $descripcion;
    private $base;
    private $tipo;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'rankingdetallecodigo';
    const CAMPOS='(codigo,descripcion,base,tipo)';
    const VALORES='(:codigo,:descripcion,:base,:tipo)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->codigo=NULL;
        $this->descripcion=NULL;
        $this->base=NULL;
        $this->tipo=NULL;
        $this->id=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
    public function getCodigo(){
        return $this->codigo;
    }
    public function setCodigo($value){
         $this->codigo=$value;
    }
   
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($value){
         $this->descripcion=$value;
    }
    public function getBase(){
        return $this->base;
        
    }
    public function setBase($value){
         $this->base=$value;
    }
    
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo($value){
         $this->tipo=$value;
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
            $campos='(codigo,descripcion,base,tipo)';
            $valores='(:codigo,:descripcion,:base,:tipo)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':codigo', $this->codigo);
            $SQL->bindParam(':descripcion', $this->descripcion);
            $SQL->bindParam(':base', $this->base);
            $SQL->bindParam(':tipo', $this->tipo);
           
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
    
    
    public function Update(){
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
            $SQL=' SET codigo=:codigo, descripcion = :descripcion, base = :base, tipo = :tipo';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':codigo', $this->codigo);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':base', $this->base);
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':id', $this->id);
         
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
    public function Delete($id){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE id= :id');
            $SQL->bindParam(':id', $id);
            $SQL->execute();
   
            //echo "New records created successfully";
            $this->mensaje='Record Delete successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $this->mensaje="Error Delete: " . $e->getMessage();
            $this->SQLresultado_exitoso=FALSE;
        }
        $conn = null;
       
    }
    
    
     public function Fetch($codigo) {
       
       $model = new Conexion;
       $conexion=$model->conectar();
       $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . ' WHERE codigo = :codigo ');
       $SQL->bindParam(':codigo', $codigo);
       
       
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->codigo=$record['codigo'];
            $this->descripcion=$record['descripcion'];
            $this->base=$record['base'];
            $this->tipo=$record['tipo'];
            $this->id=$record['id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
       $model=NULL;
       
       
    }
    
   
    
    //Lee todos los registros y devuelve una coleccion
    public static function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY id asc');
       $SQL->execute();
       $registros = $SQL->fetchall();
       if ($SQL->rowCount()==0)
        {
            $SQLresultado_exitoso=FALSE;
            $errorCode= $conn->errorCode();
            $errorInfo=$conn->errorInfo();
            $mensaje="ERROR No se encontraron registros..".$errorInfo ;
            switch ($errorCode) 
            {
                case 00000:
                    $mensaje="ERROR Numero" .$errorCode;
                    break;
                default:
                    $mensaje="ERROR No se encontraron registros..".$errorInfo ;
                    break;
            }
                  
        }
        else
        {   
           
            $mensaje='Registros encontrados..';
            $SQLresultado_exitoso=TRUE;
        }
        
      
        
//        while ($record = $consulta->fetch())
//        {
//           $this->rows[]=$record;
//          
//           
//        }
        $conn=NULL;
        
        return $registros;
        
    }
    public function load_fields_table() {
        
        $model = new Conexion;
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
        
        $model=NULL;
    }
    
    
    public function isDirty()
    {
        
        return $this->dirty;
       
    }
    
       
    
    
}
               