<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Rank {

    private $id;
    private $fecha;
    private $categoria;
    private $sexo;
    private $filename;
    private $carpeta;
    private $filetype;
    private $fecha_modificacion;
    private $disciplina;
    private $procesado;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = '`rank`';
    const CAMPOS='(fecha,sexo,categoria,carpeta,filename,filetype,disciplina,procesado)';
    const VALORES='(:fecha,:sexo,:categoria,:carpeta,:filetype,:filename,:disciplina,:procesado)';
    private $fields;
    private $fields_count;
    
    public function __construct() {
        $this->fecha=NULL;
        $this->categoria=NULL;
        $this->sexo=NULL;
        $this->filename=NULL;
        $this->filetype=NULL;
        $this->carpeta=NULL;
        $this->fecha_modificacion=NULL;
        $this->disciplina=NULL;
        $this->procesado=NULL;
        $this->id=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
      
    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($value){
         $this->fecha=$value;
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
    public function getFileName(){
        return $this->filename;
    }
    public function setFileName($value){
         $this->filename=$value;
    }
    
    public function getFileType(){
        return $this->filetype;
    }
    public function setFileType($value){
         $this->filetype=$value;
    }
   
    public function getCarpeta(){
        return $this->carpeta;
    }
    public function setCarpeta($value){
         $this->carpeta=$value;
    }
    
    public function getFecha_Modificacion(){
        return $this->fecha_modificacion;
    }
    
    public function getDisciplina(){
        return $this->disciplina;
    }
    public function setDisciplina($value){
         $this->disciplina=$value;
    }
    
    public function getProcesado(){
        return $this->procesado;
    }
    public function setProcesado($value){
         $this->procesado=$value;
    }
   
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
    
    //Busca el registro por id
    public function Find($id) {
       
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare(" SELECT * FROM " . self::TABLA . ' WHERE id = :id');
            $SQL->bindParam(':id', $id);
            $SQL->execute();
            $record = $SQL->fetch();
            
            if($record){
                $this->sexo= $record['sexo'];
                $this->categoria=$record['categoria'];
                $this->filetype=$record['filetype'];
                $this->filename=$record['filename'];
                $this->carpeta= $record['carpeta'];
                $this->fecha=$record['fecha'];
                $this->fecha_modificacion=$record['fecha_modificacion'];
                $this->procesado=$record['procesado'];
                $this->disciplina=$record['disciplina'];
                $this->id=$record['id'];
                $this->mensaje='Record Found successfully ';
                $this->SQLresultado_exitoso=TRUE;
            }
        }
        catch(PDOException $e)
            {
                echo "Error: " . $e->getMessage();
                $this->mensaje='Record Not Found..' . $e->getMessage();
                $this->SQLresultado_exitoso=FALSE;
            }
            
        $conn=NULL;
    }
     
    public function create(){
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $campos='(fecha,categoria,sexo,carpeta,filename,filetype,disciplina)';
            $valores='(:fecha,:categoria,:sexo,:carpeta,:filename,:filetype,:disciplina)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
            $SQL->bindParam(':categoria', $this->categoria,PDO::PARAM_STR);
            $SQL->bindParam(':sexo', $this->sexo,PDO::PARAM_STR);
            $SQL->bindParam(':carpeta', $this->carpeta,PDO::PARAM_STR);
            $SQL->bindParam(':filename', $this->filename,PDO::PARAM_STR);
            $SQL->bindParam(':filetype', $this->filetype,PDO::PARAM_STR);
            $SQL->bindParam(':disciplina', $this->disciplina,PDO::PARAM_STR);
           
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
            $SQL=' SET carpeta=:carpeta,'
                    . 'filename=:filename,filetype=:filetype,disciplina=:disciplina,'
                    . 'procesado=:procesado';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':carpeta', $this->carpeta,PDO::PARAM_STR);
            $stmt->bindParam(':filename', $this->filename,PDO::PARAM_STR);
            $stmt->bindParam(':filetype', $this->filetype,PDO::PARAM_STR);
            $stmt->bindParam(':disciplina', $this->disciplina,PDO::PARAM_STR);
            $stmt->bindParam(':procesado', $this->procesado,PDO::PARAM_STR);
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
        
    public static function data_combo_list($disciplina,$categoria,$sexo) {
        $rsDatos = Rank::FileRanking($disciplina,$categoria,NULL,$sexo);
        
        $jsondata=array();
        $i=0;
        foreach ($rsDatos as $value) {
            $i++;
            $dato = array("value"=>$value['id'],"texto"=>$value['fecha']);
            array_push($jsondata,$dato);
        }
        return $jsondata;
    } 
    public static function Find_Last_Ranking($disciplina,$categoria,$sexo){
   
        try{
            $model = new Conexion();
            $conn=$model->conectar();
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare(" SELECT id FROM " . self::TABLA ." "
            . " WHERE categoria = :categoria and sexo = :sexo and disciplina = :disciplina "
            //. " LIMIT 1 ",array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::ATTR_EMULATE_PREPARES, false ));
            . " ORDER BY fecha Desc LIMIT 1 ");
            $SQL->setFetchMode(PDO::FETCH_ASSOC);
            // set the PDO error mode to exception
            // $SQL->bindParam(':categoria', $categoria,PDO::PARAM_STR);
            // $SQL->bindParam(':sexo', $sexo,PDO::PARAM_STR);
            // $SQL->bindParam(':disciplina', $disciplina,PDO::PARAM_STR);
            $SQL->execute(array(':categoria'=>$categoria,':sexo'=>$sexo,':disciplina'=>$disciplina));
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
            
            $mensaje="Error Update: " . $e->getMessage();
        }
      
        $registro = $SQL->fetch();
        $conn=NULL;
        return $registro;
          
    }
    
    //Lee todos los registros y devuelve un recordset
    public static function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY fecha desc ');
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
    
    //Devuelve una coleccion de Registros de Ranking por categoria y disciplina
    public static function FileRanking($disciplina,$categoria,$fecha=NULL,$sexo=NULL) {
       
        $model = new Conexion;
        $conn=$model->conectar();
        if ($fecha==NULL){
            if ($sexo!=NULL){
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  disciplina=:disciplina && categoria=:categoria && sexo=:sexo ORDER BY fecha DESC');
            } else {
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  disciplina=:disciplina && categoria=:categoria ORDER BY fecha DESC');
            }
            $bindparam_array=array(':sexo'=>$sexo,':categoria'=>$categoria,':disciplina'=>$disciplina);
        
        }  else {
           $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  disciplina=:disciplina && categoria=:categoria && sexo=:sexo && fecha=:fecha ORDER BY fecha DESC');
        //   $SQL->bindParam(":fecha",$fecha, PDO::PARAM_STR);
           $bindparam_array=array(':sexo'=>$sexo,':categoria'=>$categoria,':disciplina'=>$disciplina,':fecha'=>$fecha);
           
        }
        // $SQL->bindParam(":sexo",$sexo,PDO::PARAM_STR);
        // $SQL->bindParam(":categoria",$categoria,PDO::PARAM_STR);
        // $SQL->bindParam(":disciplina",$disciplina,PDO::PARAM_STR);
        $SQL->execute($bindparam_array);
        $records = $SQL->fetchAll();
        unset($model);
        unset($conn);
        return $records;
       
    }
    
}

