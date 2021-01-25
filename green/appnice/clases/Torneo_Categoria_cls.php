<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 Modelo para controlar la categoria de un torneo para crear los draw y lista de jugadores
 */
class Torneo_Categoria {
    //put your code here
   
    private $id;
    private $torneo_id;
    private $categoria;
    private $sexo;
    private $publicar;
    private $sorteos;
   
   
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneo_categoria';
    private $fields;
    private $fields_count;
    
    public function __construct($torneo_id,$categoria,$sexo) {
        $this->torneo_id=$torneo_id;
        $this->categoria=$categoria;
        $this->sexo=$sexo;
        $this->publicar=0;
        $this->sorteos=0;
        
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_id(){
        return $this->id;
    }
    
    public function getTorneo_id(){
        return $this->torneo_id;
    }
    public function setTorneo_id($value){
         $this->torneo_id=$value;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    public function setCategoria($value){
         $this->categoria=$value;
    }
    
    public function getSexo(){
        return $this->sexo;
    }
    
    public function setSexo($value){
         $this->sexo=$value;
    }
    
     public function getPublicar(){
        return $this->publicar;
    }
    
    public function setPublicar($value){
         $this->publicar=$value;
    }


    public function getSorteos(){
        return $this->sorteos;
    }
   
      
    public function setSorteos(){
        return $this->sorteos;
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
            
            $campos='(torneo_id,categoria,sexo,publicar,sorteos)';
            $valores='(:torneo_id,:categoria,:sexo,:publicar,:sorteos)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':torneo_id', $this->torneo_id);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':sexo', $this->sexo);
            $SQL->bindParam(':publicar', $this->publicar);
            $SQL->bindParam(':sorteos',  $this->sorteos);
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
            $SQL=' SET torneo_id = :torneo_id, categoria = :categoria, sexo = :sexo, '
                    . 'publicar = :publicar, sorteos = :sorteos ';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':torneo_id', $this->torneo_id);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':sexo', $this->sexo);
            $stmt->bindParam(':publicar', $this->publicar);
            $stmt->bindParam(':sorteos', $this->sorteos);
           
                             
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
   
    private function Record($record) {
        if($record){
            $this->torneo_id=$record['torneo_id'];
            $this->categoria=$record['categoria'];
            $this->sexo =$record['sexo'];
            $this->publicar=$record['publicar'];
            $this->sorteos=$record['sorteos'];
            $this->id=$record['id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
        
    }
    
     public function Find($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
    }
    
    
     public function Fetch($torneo_id,$categoria,$sexo) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE torneo_id = :torneo_id '
               . '&& categoria=:categoria && sexo=:sexo ');
       $SQL->bindParam(':torneo_id', $torneo_id);
       $SQL->bindParam(':categoria', $categoria);
       $SQL->bindParam(':sexo', $sexo);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
    }
    
    
     public function Delete() {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("DELETE  FROM " . self::TABLA . ' WHERE id = :id');
       $SQL->bindParam(':id', $this->id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
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
               