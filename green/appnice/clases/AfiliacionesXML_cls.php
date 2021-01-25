<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Esta tabla para manipular el archivo hustorico de exportacion xml al sistema interno de afiliaciones
 *
 * @author robinson
 */
class AfiliacionesXML   {
    //put your code here
   
    private $atleta_id;
    private $fecha;
    private $exportado;
    private $verificado;
    private $fileXML;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'afiliacionesxml';
    const CAMPOS='(atleta_id,fecha)';
    const VALORES='(:atleta_id,:fecha)';
    private $fields;
    private $fields_count;
    public function __construct() {
        
        $this->atleta_id=0;
        $this->exportado=0;
        $this->verificado=0;
        $this->fileXML=null;
        $this->fecha=null;
        
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
   
        
    public function getAtleta_id(){
        return $this->atleta_id;
    }
    public function setAtleta_id($value){
         $this->atleta_id=$value;
    }
    
         
    public function getExportado(){
        return $this->exportado;
    }
    public function setExportado($value){
         $this->exportado=$value;
    }
    
    public function getVerificado(){
        return $this->verificado;
    }
    public function setVerificado($value){
         $this->verificado=$value;
    }
       
    public function getFecha_Registro(){
        return $this->fecha;
    }
    
    public function getFileXML(){
        return $this->fileXML;
    }
    public function setFileXML($value){
         $this->fileXML=$value;
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
            $campos='(atleta_id,exportado,verificado,filexml)';
            $valores='(:atleta_id,:exportado,:verificado,:fileXML)';
           
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':atleta_id', $this->atleta_id);
            $SQL->bindParam(':exportado', $this->exportado);
            $SQL->bindParam(':verificado', $this->verificado);
            $SQL->bindParam(':fileXML', $this->fileXML);
                        
            $SQL->execute();
            $this->id = $conn->lastInsertId();

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
           
            $SQL=' SET verificado = :verificado, exportado = :exportado, filexml = :fileXML ';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE atleta_id= :atleta_id');
            $stmt->bindParam(':atleta_id', $this->atleta_id);
            $stmt->bindParam(':verificado', $this->verificado);
            $stmt->bindParam(':exportado', $this->exportado);
            $stmt->bindParam(':fileXML', $this->fileXML);
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
    
    public function Fetch($atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  atleta_id =:atleta_id');
       
      
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);

       $conn=NULL;
       
    }
    
       
    private function Record($record) {
        if ($record) {
            $this->atleta_id = $record['atleta_id'];
            $this->fecha = $record['fecha'];
            $this->exportado = $record['exportado'];
            $this->verificado = $record['verificado'];
            $this->fileXML = $record['filexml'];
            $this->id = $record['id'];
            $this->mensaje = 'Record Found successfully ';
            $this->SQLresultado_exitoso = TRUE;
//            echo "New records created successfully";
        } else {
            $this->SQLresultado_exitoso = FALSE;
            $this->mensaje = 'Record Not Found..';
        }
    }
    
    //Registros verificados y no exportados
    static public function RegistrosVerificados() {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  verificado =1 && exportado=0');
       $SQL->execute();
       $records = $SQL->fetchAll();
       $conn=NULL;
       return $records;
       
    }
    
    //Coleccion de Registros exportados
    static public function RegistrosExportados() {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  exportado =1');
       $SQL->execute();
       $records = $SQL->fetchAll();
       $conn=NULL;
       return $records;
       
    }
    
    //Coleccion de Registros exportados ccon lote
    static public function LoteRegistrosExportados($lote) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  filexml =:lote && exportado=1');
       $SQL->bindParam(':lote', $lote);
       $SQL->execute();
       $records = $SQL->fetchAll();
       $conn=NULL;
       return $records;
       
    }
    
    //Registro de filexml Generados
    static public function FileXML() {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT DISTINCT(filexml) FROM ' . self::TABLA . ' WHERE  exportado =1 ORDER BY filexml DESC');
       $SQL->execute();
       $records = $SQL->fetchAll();
       $conn=NULL;
       return $records;
       
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
               