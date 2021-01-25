<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 Modelo para controlar la tabla de grados de un torneo
 */
class Grado{
    //put your code here
   
    private $id;
    private $grado;
    private $maindraw;
    private $maindrawq;
    private $maindrawwc;
    private $qualy;
    private $qualywc;
  
       
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'grados';
    private $fields;
    private $fields_count;
    
    public function __construct() {
        $this->grado="";
        $this->maindraw=0;
        $this->maindrawq=0;
        $this->maindrawwc=0;
        $this->qualy=0;
        $this->qualywc=0;
        
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_id(){
        return $this->id;
    }
    
    public function getGrado(){
        return $this->grado;
    }
    public function setGrado($value){
         $this->grado=$value;
    }
    public function getMainDraw(){
        return $this->maindraw;
    }
    public function setMainDraw($value){
         $this->maindraw=$value;
    }
    
    public function getMainDrawQualy(){
        return $this->maindrawq;
    }
    
    public function setMainDrawQualy($value){
         $this->maindrawq=$value;
    }
    
     public function getMainDrawWildCard(){
        return $this->maindrawwc;
    }
    
    public function setMainDrawWildCard($value){
         $this->maindrawwc=$value;
    }


    public function getQualy(){
        return $this->qualy;
    }
   
      
    public function setQualy($value){
        $this->qualy=$value;
    }
    
    //Draw qualyy wild card
     public function getQualyWildCard(){
        return $this->qualywc;
    }
   
    //Draw Qualy Wild card 
    public function setQualyWildCard($value){
        $this->qualywc=$value;
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
            
            $campos='(grado,maindraw,maindrawq,maindrawwc,qualy,qualywc)';
            $valores='(:grado,:maindraw,:maindrawq, :maindrawwc,:qualy,:qualywc)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':grado', $this->grado);
            $SQL->bindParam(':maindraw', $this->maindraw);
            $SQL->bindParam(':maindrawq', $this->maindrawq);
            $SQL->bindParam(':maindrawwc', $this->maindrawwc);
            $SQL->bindParam(':qualy',  $this->qualy);
            $SQL->bindParam(':qualywc',  $this->qualywc);
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
            $SQL=' SET grado = :grado, maindraw = :maindraw, maindrawq = :maindrawq, '
                    . 'maindrawwc = :maindrawwc, qualy = :qualy, qualywc = :qualywc';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':grado', $this->grado);
            $stmt->bindParam(':maindraw', $this->maindraw);
            $stmt->bindParam(':maindrawq', $this->maindrawq);
            $stmt->bindParam(':maindrawwc', $this->maindrawwc);
            $stmt->bindParam(':qualy', $this->qualy);
            $stmt->bindParam(':qualywc', $this->qualywc);
           
                             
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
            $this->grado=$record['grado'];
            $this->maindraw=$record['maindraw'];
            $this->maindrawq =$record['maindrawq'];
            $this->maindrawwc=$record['maindrawwc'];
            $this->qualy=$record['qualy'];
            $this->qualywc=$record['qualywc'];
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
    
    
     public function Fetch($grado) {
         
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE grado = :grado ');
       $SQL->bindParam(':grado', $grado);
      
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
               