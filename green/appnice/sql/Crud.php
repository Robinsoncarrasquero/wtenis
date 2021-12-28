<?php
require_once 'ConexionPDO.php';

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
class Crud {
    //put your code here
    public $id;
    public $insertInto;
    public $insertColumns;
    public $insertValues;
    public $mensaje;
    public $select;
    public $from;
    public $condition;
    public $rows;
    public $rowschange;
    public $update;
    public $set;
    public $operacionExitosa;
    public $deleteFrom;
    public $table_name;
    public $fields;
    public $fields_count;
    private $dirty;
   

    public function __construct() {
       $this->dirty=false;
       $this->operacionExitosa=false;
    }

    public function Create()
    {
   
        try{
            $model = new Conexion();
            $conexion = $model->conectar();
            $insertInto = $this->insertInto;
            $insertColumns = $this->insertColumns;
            $insertValues = $this->insertValues;
            $sql = "INSERT INTO ".$insertInto ."(".$insertColumns.") VALUES (".$insertValues.") ";
            $consulta=$conexion->prepare($sql);
            $consulta->execute();
            $this->id=$conexion->lastInsertId();
            $this->operacionExitosa=TRUE;
            $this->mensaje= "Registro Creado con exito ";
        } catch (PDOException $e) {
            //echo 'Falló la conexión: ' . $e->getMessage();
            $this->mensaje= "ERROR : ". $e->getCode();
            $this->operacionExitosa=FALSE;
    
        }
    }

    public function Read()
    {
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $select = $this->select;
        $from = $this->from;
        $condition = $this->condition;
        if($condition!='')
        {
           $condition = "WHERE " . $condition;
        }
        $sql = "SELECT $select FROM $from $condition ";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        
        while ($record = $consulta->fetch())
        {
           $this->rows[]=$record;
           $this->rowschange[]=$record;
           
        }
        
    }
    
    public function Update()
    {
        try
        {
            $model = new Conexion();
            $conexion = $model->conectar();
            $update= $this->update;
            $set=$this->set;
            $condition = $this->condition;
            if ($condition!='')
            {
                $condition="WHERE " . $condition;
            }
            $sql = "UPDATE $update SET $set $condition";
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $this->operacionExitosa=TRUE;     
            $this->mensaje="Registro Update con exito";
      } catch (PDOException $e) {
            echo 'Eroor algo fallo ' .  $e->getMessage();
            $this->mensaje= "ERROR : ". $e->getCode();
            $this->operacionExitosa=FALSE;
        }
               
    }
    public function Delete()
    {
        try {
            $model = new Conexion;
            $conexion = $model->conectar();
            $deleteFrom = $this->deleteFrom;
            $condicion = $this->condition;
            if($condicion!='')
            {
                $condicion= " WHERE " . $condicion;
            }
            $sql = "DELETE FROM $deleteFrom " . $condicion;
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $this->operacionExitosa=TRUE;
            $this->mensaje='Registro eliminado con exito..';

        } catch (PDOException $e) {
            //echo 'Falló la conexión: ' . $e->getMessage();
            $this->mensaje= "ERROR : ". $e->getCode();
            $this->operacionExitosa=FALSE;
        }
        
        
              
        
    }
    public function table_fields()
    {
        
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $sql=" SELECT TABLE_NAME,COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,ORDINAL_POSITION FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA='atletasdb' && TABLE_NAME='$this->Tabla_Name' ORDER BY TABLE_NAME";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        while ($record = $consulta->fetch())
        {
           $this->fields[]=$record;
           
        }
        
        $this->fields_count=  count($this->fields); // numero de campos en el arreglo devuelto;
    }
    
    public function valida_fields($objeto)
    {
        $objeto->table_fields();
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
        
        if ($this->rowschange[0][$field]!=$value){
            $this->dirty=true;
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