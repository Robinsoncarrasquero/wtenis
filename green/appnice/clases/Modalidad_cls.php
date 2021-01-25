<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Modalidad {

    private $id;
    private $categoria;
    private $modalidad;
    private $descripcion;
    
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'modalidad';
    const CAMPOS='(categoria,modalidad,descripcion)';
    const VALORES='(:categoria,:modalidad,:descripcion)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->categoria=NULL;
        $this->modalidad=NULL;
        $this->descripcion=NULL;
        $this->id=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
   
    public function getCategoria(){
        return $this->categoria;
    }
    public function setCategoria($value){
         $this->categoria=$value;
    }
    
    public function getModalidad(){
        return $this->modalidad;
    }
    public function setModalidad($value){
         $this->modalidad=$value;
    }
    
   
    
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
    public static function Modalidad($param) {
        
        switch ($param) {
            case "DD":
                echo '<option value="DD">DOBLES</option>';
                break;
            case "DM":
                echo '<option value="DM">DOBLES MIXTO</option>';
                break;
            case "SS":
                echo '<option value="SS">SINGLE</option>';
            default:
                echo '<option value="SS">SINGLE</option>';
                break;
        }
           
    }
    //Obtener los record de una categoria
     public static function ReadByCategoria($categoria) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE categoria = :categoria');
       $SQL->bindParam(':categoria', $categoria);
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
    
    //Lee todos los registros y devuelve un recordset
    public static function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY categoria,modalidad asc');
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

}

