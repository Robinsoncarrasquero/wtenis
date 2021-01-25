<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Disciplina {

    private $id;
    private $disciplina;
    private $descripcion;
    
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'disciplina';
    const CAMPOS='(disciplina,descripcion)';
    const VALORES='(:disciplina,:descripcion)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->disciplina=NULL;
        $this->descripcion=NULL;
        $this->id=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
       
    public function getDisciplina(){
        return $this->disciplina;
    }
    public function setDisciplina($value){
         $this->disciplina=$value;
    }
    
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($value){
         $this->descripcion=$value;
    }
    
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
    public static function data_combo_list() {
        $rsDatos = Disciplina::ReadAll();
        $jsondata=array();
        $i=0;
        foreach ($rsDatos as $value) {
            $i++;
            $dato = array("value"=>$value['disciplina'],"texto"=>$value['descripcion']);
            array_push($jsondata,$dato);
        }
        return $jsondata;
    }  
    
    //Lee todos los registros y devuelve un recordset
    public static function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY disciplina asc');
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
        
        $conn=NULL;
        
        return $registros;
        
    }

}

