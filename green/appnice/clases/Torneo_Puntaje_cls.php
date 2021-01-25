<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 Modelo para controlar la categoria de un torneo para crear los draw y lista de jugadores
 */
class Torneo_Puntaje{
    //put your code here
   
    private $id;
    private $categoria;
    private $grado;
    private $draw;
    private $ronda;
    private $puntos;
  
       
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'puntos';
    private $fields;
    private $fields_count;
    
    public function __construct() {
        $this->grado="";
        $this->puntos=0;
        $this->ronda=0;
        $this->draw="";
        $this->categoria="";
        
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
    public function getPuntos(){
        return $this->puntos;
    }
    public function setPuntos($value){
         $this->puntos=$value;
    }
    
    public function getRonda(){
        return $this->ronda;
    }
    
    public function setRonda($value){
         $this->ronda=$value;
    }
    
     public function getDraw(){
        return $this->draw;
    }
    
    public function setDraw($value){
         $this->draw=$value;
    }


    public function getCategoria(){
        return $this->categoria;
    }
   
      
    public function setCategoria($value){
        $this->categoria=$value;
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
            
            $campos='(grado,categoria,draw,ronda,puntos)';
            $valores='(:grado,:categoria,:draw,:ronda,:puntos)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':grado', $this->grado);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':draw', $this->draw);
            $SQL->bindParam(':ronda', $this->ronda);
            $SQL->bindParam(':puntos',  $this->puntos);
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
            $SQL=' SET grado = :grado, categoria = :categoria, draw = :draw, '
                    . 'ronda = :ronda, puntos = :puntos ';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':grado', $this->grado);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':draw', $this->draw);
            $stmt->bindParam(':ronda', $this->ronda);
            $stmt->bindParam(':puntos', $this->puntos);
           
                             
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
            $this->categoria=$record['categoria'];
            $this->draw =$record['draw'];
            $this->ronda=$record['ronda'];
            $this->puntos=$record['puntos'];
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
    
    
     public function Fetch($draw,$categoria,$grado,$ronda) {
         
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE draw = :draw '
               . ' && categoria = :categoria && grado = :grado && ronda = :ronda ');
       $SQL->bindParam(':draw', $draw);
       $SQL->bindParam(':categoria', $categoria);
       $SQL->bindParam(':grado', $grado);
       $SQL->bindParam(':ronda', $ronda);
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
               