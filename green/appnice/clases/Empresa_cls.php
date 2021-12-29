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
class Empresa   {
    //put your code here
    
    private $estado;
    private $asociacion;
    private $nombre;
    private $descripcion;
    private $email;
    private $direccion;
    private $telefonos;
    private $deshabilitado;
    private $id;
    private $twitter;
    private $colorJumbotron;
    private $bgcolorJumbotron;
    private $colorNavbar;
    private $fotos;
    private $constancia;
    private $banco;
    private $cuenta;
    private $url;
    private $rif;
    private $entidad;
    private $dominio;
    private $email_envio;
    private $cartaFederativa;
    private $id_asociacion;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'empresa';
    const CAMPOS='(estado,asociacion,nombre, descripcion,email,direccion,telefonos,twitter,colorjumbotron,bgcolorjumbotron,colorNavbar,fotos,constancia,banco,cuenta)';
    const VALORES='(:estado,:asociacion,:nombre,:descripcion,:email,:direccion,:telefonos,:twitter,:colorjumbotron,:bgcolorjumbotron,:colorNavbar,:fotos,:constancia,:banco,:cuenta)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->estado="";
        $this->asociacion="";
        $this->nombre=  " ";
        $this->descripcion=" ";
        $this->email=" ";
        $this->direccion=" ";
        $this->telefonos=" ";
        $this->twitter=" ";
        $this->colorJumbotron='';
        $this->bgcolorJumbotron='';
        $this->colorNavbar='';
        $this->fotos='';
        $this->constancia='';
        $this->banco='';
        $this->cuenta='';
        $this->url='';
        $this->rif="";
        $this->dominio="";
        $this->entidad="";
        $this->cartaFederativa='';
        $this->id_asociacion=0;
        $this->email_envio=" ";
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_Empresa_id(){
        return $this->id;
    }
   
    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($value){
         $this->estado=$value;
    }
    
    public function getAsociacion(){
        return $this->asociacion;
    }
    public function setAsociacion($value){
         $this->asociacion=$value;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($value){
         $this->nombre=$value;
    }
    
    public function getDescripcion(){
        return $this->descripcion;
    }
    
    public function setDescripcion($value){
        $this->descripcion=$value;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($value){
        $this->email=$value;
    }
    public function getDireccion() {
       return $this->direccion;
    }
    
    public function setDireccion($value) {
       $this->direccion=$value;
    }
    public function getTelefonos() {
       return $this->telefonos;
    }
    
    public function setTelefonos($value) {
       $this->telefonos=$value;
    }
    
    public function getTwitter(){
        return $this->twitter;
    }
    public function setTwitter($value){
         $this->twitter=$value;
    }
    
    public function getColorJumbotron(){
        return $this->colorJumbotron;
    }
    public function setColorJumbotron($value){
         $this->colorJumbotron=$value;
    }
    public function getbgColorJumbotron(){
        return $this->bgcolorJumbotron;
    }
    public function setbgColorJumbotron($value){
         $this->bgcolorJumbotron=$value;
    }
    public function getColorNavbar(){
        return $this->colorNavbar;
    }
    public function setColorNavbar($value){
         $this->colorNavbar=$value;
    }
    
   
    public function getFotos(){
        return $this->fotos;
    }
    public function setFotos($value){
         $this->fotos=$value;
    }
    public function getConstancia() {
        return $this->constancia;
        
    }
    
    public function setConstancia($value) {
        $this->constancia=$value;
        
    }
    
   
    public function getBanco(){
        return $this->banco;
    }
    public function setBanco($value){
         $this->banco=$value;
    }
    
     public function getCuenta(){
        return $this->cuenta;
    }
    public function setCuenta($value){
         $this->cuenta=$value;
    }
    
    public function getURL(){
        return $this->url;
    }
    public function setURL($value){
         $this->url=$value;
    }
    
    public function getRif(){
        return $this->rif;
    }
    public function setRif($value){
         $this->rif=$value;
    }
    
     public function getDominio(){
        return $this->dominio;
    }
    public function setDominio($value){
         $this->dominio=$value;
    }
    
    public function getEntidad(){
        return $this->entidad;
    }
    public function setEntidad($value){
         $this->entidad=$value;
    }
    
    
    
    public function setCartaFederativa($value) {
        $this->cartaFederativa=$value;
        
    }
    public function getCartaFederativa() {
        return $this->cartaFederativa;
        
    }
    //Campo utilizado en la exportacion xml para unir la tabla del sistema cpn el sistema interno de afiliaciones
     public function getid_asociacion(){
        return $this->id_asociacion;
    }
    
    public function getEmail_Envio(){
        return $this->email_envio;
    }
    public function setEmail_Envio($value){
        $this->email_envio=$value;
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
            
            $campos='(estado,asociacion,nombre,descripcion,email,direccion,telefonos,twitter,colorjumbotron,bgcolorjumbotron,colorNavbar,'
                    . 'fotos,constancia,banco,cuenta,url,rif,dominio,entidad,cartafederativa)';
            $valores='(:estado,:asociacion,:nombre,:descripcion,:email,:direccion,:telefonos,:twitter,:colorjumbotron,:bgcolorjumbotron,:colorNavbar,'
                    . ':fotos,:constancia,:banco,:cuenta,:url,:rif,:dominio,:entidad,:cartafederativa)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':estado', $this->estado);
            $SQL->bindParam(':asociacion', $this->asociacion);
            $SQL->bindParam(':nombre', $this->nombre);
            $SQL->bindParam(':descripcion', $this->descripcion);
            $SQL->bindParam(':email', $this->email);
            $SQL->bindParam(':direccion',  $this->direccion);
            $SQL->bindParam(':telefonos', $this->telefonos);
            $SQL->bindParam(':twitter', $this->twitter);
            $SQL->bindParam(':colorjumbotron', $this->colorJumbotron);
            $SQL->bindParam(':bgcolorjumbotron', $this->bgcolorJumbotron);
            
            $SQL->bindParam(':colorNavbar', $this->colorNavbar);
            $SQL->bindParam(':fotos', $this->fotos);
            $SQL->bindParam(':constancia', $this->constancia);
            $SQL->bindParam(':banco', $this->banco);
            $SQL->bindParam(':cuenta', $this->cuenta);
            $SQL->bindParam(':url', $this->url);
            $SQL->bindParam(':rif', $this->rif);
            $SQL->bindParam(':dominio', $this->dominio);
            $SQL->bindParam(':entidad', $this->entidad);
            $SQL->bindParam(':cartafederativa', $this->cartaFederativa);
            $SQL->bindParam(':email_envio', $this->email_envio);
     
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
           
            $SQL=' SET nombre = :xnombre, descripcion = :xdescripcion, email = :xemail, direccion = :xdireccion, '
                . 'telefonos = :xtelefonos, twitter = :xtwitter, colorjumbotron=:xcolorjumbotron, '
                . 'bgcolorjumbotron=:xbgcolorjumbotron,colorNavbar=:xcolorNavbar, fotos=:xfotos, '
                    . 'constancia=:xconstancia,banco=:xbanco,cuenta=:xcuenta,url=:xurl,rif=:xrif,'
                    . 'dominio=:xdominio,entidad=:xentidad,cartafederativa=:xcartafederativa,'
                    .'email_envio=:email_envio';
            
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE empresa_id= :xid');
            $stmt->bindParam(':xid', $this->id);
            $stmt->bindParam(':xnombre', $this->nombre);
            $stmt->bindParam(':xdescripcion', $this->descripcion);
            $stmt->bindParam(':xemail', $this->email);
            $stmt->bindParam(':xdireccion', $this->direccion);
            $stmt->bindParam(':xtelefonos', $this->telefonos);
            $stmt->bindParam(':xtwitter', $this->twitter);
            $stmt->bindParam(':xcolorjumbotron', $this->colorJumbotron);
            $stmt->bindParam(':xbgcolorjumbotron', $this->bgcolorJumbotron);
            $stmt->bindParam(':xcolorNavbar', $this->colorNavbar);
            $stmt->bindParam(':xfotos', $this->fotos);
            $stmt->bindParam(':xconstancia', $this->constancia);
            $stmt->bindParam(':xbanco', $this->banco);
            $stmt->bindParam(':xcuenta', $this->cuenta);
            $stmt->bindParam(':xurl', $this->url);
            $stmt->bindParam(':xrif', $this->rif);
            $stmt->bindParam(':xdominio', $this->dominio);
            $stmt->bindParam(':xentidad', $this->entidad);
            $stmt->bindParam(':xcartafederativa', $this->cartaFederativa);
            $stmt->bindParam(':email_envio', $this->email_envio);
            
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
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE empresa_id= :id');
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
    
    
     public function Fetch($estado) {
       
       $model = new Conexion;
       $conexion=$model->conectar();
       $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . ' WHERE estado = :edo');
       $SQL->bindParam(':edo', $estado);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->record($record);
       
       $model=NULL;
       
    }
    
     public function Find_entidad($entidad) {
       
       $model = new Conexion;
       $conexion=$model->conectar();
       $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . ' WHERE entidad = :entidad');
       $SQL->bindParam(':entidad', $entidad);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       $model=null;
    }

    function record($record){
        if($record){
            $this->estado=$record['estado'];
            $this->asociacion=$record['asociacion'];
            $this->nombre= $record['nombre'];
            $this->descripcion= $record['descripcion'];
            $this->email=$record['email'];
            $this->direccion=$record['direccion'];
            $this->telefonos=$record['telefonos'];
            $this->twitter=$record['twitter'];
            $this->colorJumbotron=$record['colorjumbotron'];
            $this->bgcolorJumbotron=$record['bgcolorjumbotron'];
            $this->colorNavbar=$record['colorNavbar'];
            $this->fotos=$record['fotos'];
            $this->constancia=$record['constancia'];
            $this->banco=$record['banco'];
            $this->cuenta=$record['cuenta'];
            $this->url=$record['url'];
            $this->rif=$record['rif'];
            $this->dominio=$record['dominio'];
            $this->entidad=$record['entidad'];
            $this->id_asociacion=$record['idasociacion'];
            $this->email_envio=$record['email_envio'];
            $this->id=$record['empresa_id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
            $this->cartaFederativa =$record['cartafederativa'];
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
    }
    
    public function Find($empresa_id) {
       
       $model = new Conexion;
       $conexion=$model->conectar();
       $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . ' WHERE empresa_id = :empresa_id');
       $SQL->bindParam(':empresa_id', $empresa_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->record($record);
       $model=NULL;
       
    }
    
    public function ReadById($empresa_id) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :id');
       $SQL->bindParam(':id', $empresa_id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            return new self($record['estado'],$record['asociacion'], $record['nombre'], $record['descripcion'],$record['email'],
            $record['direccion'],$record['telefonos'],$record['twitter'],$record['colorjumbotron'],
                    $record['bgcolorjumbotron'],$record['colorNavbar'],$record['fotos'],$record['constancia'],
                    $record['banco'],$record['cuenta'],$record['url'], $record['rif'],$record['empresa_id'],
                    $record['dominio'],$record['entidad'],$record['cartafederativa'],$record['idasociacion']);
            
       } else {
             $this->SQLresultado_exitoso=FALSE;
            
           
       }
       
       $conn=NULL;
       
       
    }
    
    //Devuelve data para un comobo list
    public static function data_combo_list() {
        $rsDatos = Empresa::ReadAll();
        $jsondata=array();

        $i=0;
        foreach ($rsDatos as $value) {
            $i++;
            $dato = array("value"=>$value['empresa_id'],"texto"=>$value['estado']);
            array_push($jsondata,$dato);
        }
        
        return $jsondata;
        

    } 
    
    
    public static function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY asociacion');
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
    
    public static function Entidades() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT estado,entidad FROM ' . self::TABLA .' ORDER BY estado');
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
        
        $conn = NULL;
//        foreach ($registros as $row){
//            $rows[]=$row;
//        }
       
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
               