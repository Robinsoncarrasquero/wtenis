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
class Noticias   {
    //put your code here
    private $empresa_id;
    private $titulo;
    private $noticia;
    private $mininoticia;
    private $autor;
    private $fecha;
    private $url_imagen;
    private $src_imagen;
    private $imagen;
    private $estatus;
    private $id;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'noticias';
    const CAMPOS=' empresa_id,titulo,noticia,mininoticia,autor,url_imagen,src_imagen,imagen,estatus)';
    const VALORES='(:empresa_id,:titulo,:noticia,:mininoticia,:autor,:url_imagen,:src_imagen,:imagen,:estatus)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->empresa_id=0;
        $this->titulo=NULL;
        $this->noticia=  NULL;
        $this->mininoticia=  NULL;
        $this->autor=NULL;
        $this->url_imagen=NULL;
        $this->src_imagen=NULL;
        $this->imagen=NULL;
        $this->estatus=NULL;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    
    public function ID(){
        return $this->id;
    }
    public function getEmpresa_id(){
        return $this->empresa_id;
    }
    public function setEmpresa_id($value){
         $this->empresa_id=$value;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }
    public function setTitulo($value){
         $this->titulo=$value;
    }
    public function getNoticia(){
        return $this->noticia;
    }
    public function setNoticia($value){
         $this->noticia=$value;
    }
    
    public function getMiniNoticia(){
        return $this->mininoticia;
    }
    public function setMiniNoticia($value){
         $this->mininoticia=$value;
    }
    
    public function getAutor(){
        return $this->autor;
    }
    
    public function setAutor($value){
        $this->autor=$value;
    }
    
    public function getFecha(){
        return $this->fecha;
    }
    
    public function getURL_imagen(){
        return $this->url_imagen;
    }
    
    public function setURL_imagen($value){
        $this->url_imagen=$value;
    }
    
    public function getSRC_imagen(){
        return $this->src_imagen;
    }
    
    public function setSRC_imagen($value){
        $this->src_imagen=$value;
    }
    
    public function getImagen(){
        $img= base64_encode($this->imagen);
        return $img;
    }
    
    public function setImagen($value){
        $newvalue=file_get_contents($value);
        $this->imagen=$newvalue;
    }
    
    
    public function getEstatus(){
        return $this->estatus;
    }
    
    public function setEstatus($value){
        $this->estatus=$value;
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
        
            $campos='(empresa_id,titulo,noticia,mininoticia,autor,url_imagen,src_imagen,imagen,estatus)';
            $valores='(:empresa_id,:titulo,:noticia,:mininoticia,:autor,:url_imagen,:src_imagen,:imagen,:estatus)';
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':empresa_id', $this->empresa_id);
            $SQL->bindParam(':titulo', $this->titulo);
            $SQL->bindParam(':noticia', $this->noticia);
            $SQL->bindParam(':mininoticia', $this->mininoticia);
            $SQL->bindParam(':autor', $this->autor);
            $SQL->bindParam(':url_imagen', $this->url_imagen);
            $SQL->bindParam(':src_imagen', $this->src_imagen);
            $SQL->bindParam(':imagen', $this->imagen);
            $SQL->bindParam(':estatus', $this->estatus);

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
            $SQLstr=' SET titulo = :xtitulo, noticia = :xnoticia, mininoticia = :xmininoticia, autor = :xautor, '
                    . 'url_imagen = :xurl_imagen, src_imagen = :xsrc_imagen,imagen = :ximagen,estatus = :xestatus';
       
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQLstr. ' WHERE noticia_id = :xid');
            $stmt->bindParam(':xid', $this->id);
            $stmt->bindParam(':xtitulo', $this->titulo);
            $stmt->bindParam(':xnoticia', $this->noticia);
            $stmt->bindParam(':xmininoticia', $this->mininoticia);
            $stmt->bindParam(':xautor', $this->autor);
            $stmt->bindParam(':xurl_imagen', $this->url_imagen);
            $stmt->bindParam(':xsrc_imagen', $this->src_imagen);
            $stmt->bindParam(':ximagen', $this->imagen);
            $stmt->bindParam(':xestatus', $this->estatus);
         
            $stmt->execute();

            //echo "New records created successfully";
            $this->mensaje='Record update successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $this->mensaje="Error Update: " . $e->getMessage();
            $this->SQLresultado_exitoso=FALSE;
        }
        $conn = null;
    
    }
    public function Delete($id){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE noticia_id= :id');
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
    
    
     public function Fetch($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE noticia_id = :id");
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            $this->titulo=$record['titulo'];
            $this->noticia= $record['noticia'];
            $this->mininoticia= $record['mininoticia'];
            $this->autor= $record['autor'];
            $this->fecha=$record['fecha'];
          
            $this->url_imagen=$record['url_imagen'];
            $this->src_imagen=$record['src_imagen'];
            $this->imagen=$record['imagen'];
            $this->estatus=$record['estatus'];
            $this->empresa_id=$record['empresa_id'];
            $this->id=$record['noticia_id'];
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
    
    public function ReadById($id) {
       $model = new Conexion();
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE noticia_id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            return new self($record['titulo'], $record['mininoticia'],$record['noticia'], 
                    $record['autor'],$record['fecha'],$record['url_imagen'],$record['src_imagen'],
                    $record['imagen'],$record['estatus'],$record['empresa_id'],$record['noticia_id']);
          
       } else {
             $this->SQLresultado_exitoso=FALSE;
           
       }
       $conn=NULL;
    }
    
    public function ReadAll($id,$inicio=0,$registros=0) {
       if ($registros>0){
           $limit=" LIMIT $inicio,$registros";
       }else{
           $limit='';
       }
       $model = new Conexion();
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id='.$id."  ORDER BY fecha desc $limit");
       $SQL->execute();
       
       $registros = $SQL->fetchall();
       
       if ($SQL->rowCount()==0)
        {
            
            $this->SQLresultado_exitoso=FALSE;
            $errorCode= $conn->errorCode();
            $errorInfo=$conn->errorInfo();
            $this->mensaje="Record Not Found : ".$errorInfo ;
            
            switch ($errorCode) 
            {
                case 00000:
                    $this->mensaje="ERROR Numero" .$errorCode;
                    break;
                default:
                    $this->mensaje="ERROR No se encontraron registros..".$errorInfo ;
                    break;
            }
                  
        }
        else
        {  
            
            $this->mensaje='Records Found successfully';
            $this->SQLresultado_exitoso=TRUE;
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
               