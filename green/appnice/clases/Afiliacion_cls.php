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
class Afiliacion {
    //put your code here
    
    private $id;
    private $ano;
    private $fvt;
    private $asociacion;
   
    private $sistemaweb;
    private $modalidad;
    private $fvtCicloCobro;
    private $asociacionCicloCobro;
    private $sistemaWebCicloCobro;
    private $empresa_id;
    private $ciclo;
    private $fecha_desde;
    private $fecha_hasta;
    private $moneda;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'afiliacion';
    const CAMPOS='(ano,fvt,asociacion,sistemaweb,modalidad,fvtciclocobro,asociacionclocobro,sistemawebciclocobro)';
    const VALORES='(:ano,:fvt,:asociacion,:sistemaweb,:modalidad,:fvtciclocobro,:asociacionciclocobro,:sistemawebciclocobro)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->ano=0;
        $this->fvt=0;
        $this->asociacion=0;
        $this->sistemaweb=0;
        $this->modalidad='tdc';
        $this->fvtCicloCobro='Anual';
        $this->asociacionCicloCobro='Anual';
        $this->sistemaWebCicloCobro="Semestre";
        $this->empresa_id=0;
        $this->fecha_desde=0;
        $this->fecha_hasta=0;
        $this->ciclo="0";
        $this->moneda='';
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_ID(){
        return $this->id;
    }
   
    public function getAno(){
        return $this->ano;
    }
    public function setAno($value){
         $this->ano=$value;
    }
    
    
    public function getFVT() {
       return $this->fvt;
    }
    
    public function setFVT($value) {
       $this->fvt=$value;
    }
    
     public function getFVTCicloCobro() {
       return $this->fvtCicloCobro;
    }
    
    public function SetFVTCicloCobro($value) {
       $this->fvtCicloCobro=$value;
    }
    
    public function getAsociacion(){
        return $this->asociacion;
    }
    public function setAsociacion($value){
         $this->asociacion=$value;
    }
    
    public function getAsociacionCicloCobro() {
       return $this->asociacionCicloCobro;
    }
    
    public function SetAsociacionCicloCobro($value) {
       $this->asociacionCicloCobro=$value;
    }
    
    public function getSistemaWeb(){
        return $this->sistemaweb;
    }
    public function setSistemaWeb($value){
         $this->sistemaweb=$value;
    }
    
    public function getSistemaWebCicloCobro() {
       return $this->sistemaWebCicloCobro;
    }
    
    public function SetSistemaWebCicloCobro($value) {
       $this->sistemaWebCicloCobro=$value;
    }
    
    public function getModalidad() {
       return $this->modalidad;
    }
    
    public function setModalidad($value) {
       $this->modalidad=$value;
    }
    
    public function getEmpresa_id() {
       return $this->empresa_id;
    }
    
    public function setEmpresa_id($value) {
       $this->empresa_id=$value;
    }
    
    public function getCiclo() {
       return $this->ciclo;
    }
    
    public function setCiclo($value) {
       $this->ciclo=$value;
    }
    
    public function getFechaDesde() {
        return $this->fecha_desde; //inicio de afiliacion
    }

    public function setFechaDesde($value) {
        $this->fecha_desde = $value;
    }
    public function getFechaHasta() {
        return $this->fecha_hasta; //fecha fin de afiliacion
    }

    public function setFechaHasta($value) {
        $this->fecha_hasta = $value;
    }
    
    public function getMoneda(){
        return $this->moneda;
    }
    public function setMoneda($value){
       
         $this->moneda=$value;
    }
    
    
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
    //Porcentaje de consumo de afiliacion a la fecha
    public function periodo_consumido() {
         //Calculo de barra de progreso de consumo de afiliacion
        $diasParaOpen ="1 days";
        $fecha_desde =date_timestamp_get(date_create($this->fecha_desde)); // fecha cierre de inscripciones 
        $fecha_hasta =date_timestamp_get(date_create($this->fecha_hasta));
        //date_sub($fecha_desde,date_interval_create_from_date_string($diasParaOpen));
        $dias_lapso=(($fecha_hasta - $fecha_desde))/86400;//Obtenemos los dias del lapso
        
        $fecha_hoy =date_timestamp_get(date_create()); // fecha cierre de inscripciones 
        //date_sub($fecha_hoy,date_interval_create_from_date_string($diasParaOpen));
        $dias_ya_consumidos=(($fecha_hoy - $fecha_desde))/86400;
              
        $consumido= $dias_ya_consumidos/$dias_lapso*100;
       
        if ($fecha_desde>$fecha_hoy){
            $consumido=0;
        }
        if ($fecha_hasta<$fecha_hoy){
            $consumido=100;
         }
        return $consumido;
        
    }
    
    //Porcentaje de afiliacion no consumida
    public function periodo_no_consumido() {
         //Calculo de barra de progreso de consumo de afiliacion
         $diasParaOpen ="1 days";
        $fecha_desde =date_timestamp_get(date_create($this->fecha_desde)); // fecha cierre de inscripciones 
        //date_sub($fecha_desde,date_interval_create_from_date_string($diasParaOpen));
        $fecha_hasta =date_timestamp_get(date_create($this->fecha_hasta));
        $dias_lapso=($fecha_hasta - $fecha_desde)/86400;//Obtenemos los dias del lapso
        
        $fecha_hoy =date_timestamp_get(date_create()); // fecha cierre de inscripciones 
        //date_sub($fecha_hoy,date_interval_create_from_date_string($diasParaOpen));
        $dias_ya_consumidos=($fecha_hoy - $fecha_desde)/86400;
        $dias_no_consumidos=($fecha_hasta-$fecha_hoy)/86400;
       
        
        $no_consumido=  ($dias_no_consumidos/$dias_lapso)*100;
        if ($fecha_desde>$fecha_hoy){
           
            $no_consumido=0;
       
        }
        return $no_consumido;
        
    }
   
    public function create(){
        
        
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $campos='(ano,fvt,asociacion,sistemaweb,modalidad,fvtciclocobro,asociacionciclocobro,sistemawebciclocobro'
                    . ',empresa_id,ciclo,fecha_desde,fecha_hasta,moneda)';
            $valores='(:ano,:fvt,:asociacion,:sistemaweb,:modalidad,:fvtciclocobro,:asociacionciclocobro,:sistemawebciclocobro'
                    . ',:empresa_id,:ciclo,:fecha_desde,:fecha_hasta,:moneda)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':ano', $this->ano);
            $SQL->bindParam(':fvt',  $this->fvt);
            $SQL->bindParam(':asociacion', $this->asociacion);
            $SQL->bindParam(':sistemaweb', $this->sistemaweb);
            $SQL->bindParam(':modalidad', $this->modalidad);
            $SQL->bindParam(':fvtciclocobro',  $this->fvtCicloCobro);
            $SQL->bindParam(':asociacionciclocobro', $this->asociacionCicloCobro);
            $SQL->bindParam(':sistemawebciclocobro', $this->sistemaWebCicloCobro);
            $SQL->bindParam(':empresa_id', $this->empresa_id);
            $SQL->bindParam(':ciclo', $this->ciclo);
            $SQL->bindParam(':fecha_desde', $this->fecha_desde,PDO::PARAM_STR);
            $SQL->bindParam(':fecha_hasta', $this->fecha_hasta,PDO::PARAM_STR);
            $SQL->bindParam(':moneda', $this->moneda);
            
                
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
           
            $SQL=' SET '
                . 'fvt = :xfvt, asociacion = :xasociacion, sistemaweb=:xsistemaweb, modalidad=:xmodalidad,'
                . 'fvtciclocobro = :xfvtciclocobro, asociacionciclocobro = :xasociacionciclocobro, '
                . 'sistemawebciclocobro = :xsistemawebciclocobro, ciclo=:xciclo,'
                . 'fecha_desde=:xfecha_desde,fecha_hasta=:xfecha_hasta,moneda=:xmoneda ';
               
            
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE afiliacion_id= :id');
            $stmt->bindParam(':id', $this->id);
            
            $stmt->bindParam(':xfvt',  $this->fvt);
            $stmt->bindParam(':xasociacion', $this->asociacion);
            $stmt->bindParam(':xsistemaweb', $this->sistemaweb);
            $stmt->bindParam(':xmodalidad', $this->modalidad);
            $stmt->bindParam(':xfvtciclocobro',  $this->fvtCicloCobro);
            $stmt->bindParam(':xasociacionciclocobro', $this->asociacionCicloCobro);
            $stmt->bindParam(':xsistemawebciclocobro', $this->sistemaWebCicloCobro);
            $stmt->bindParam(':xciclo', $this->ciclo);
            $stmt->bindParam(':xfecha_desde', $this->fecha_desde,PDO::PARAM_STR);
            $stmt->bindParam(':xfecha_hasta', $this->fecha_hasta,PDO::PARAM_STR);
            $stmt->bindParam(':xmoneda', $this->moneda);
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
    public function Delete($empresa_id){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE empresa_id= :emp_id');
            $SQL->bindParam(':emp_id', $empresa_id);
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
    
    private function record($record) {
        if($record){
            
            $this->ano=$record['ano'];
            $this->fvt=$record['fvt'];
            $this->sistemaweb=$record['sistemaweb'];
            $this->asociacion=$record['asociacion'];
            $this->modalidad= empty($record['modalidad']) ?  'TDC' : $record['modalidad'];
            $this->fvtCicloCobro=$record['fvtciclocobro'];
            $this->asociacionCicloCobro=$record['asociacionciclocobro'];
            $this->sistemaWebCicloCobro=$record['sistemawebciclocobro'];
            $this->empresa_id=$record['empresa_id'];
            $this->ciclo=$record['ciclo'];
            $this->empresa_id=0;
            $this->fecha_desde=$record['fecha_desde'];
            $this->fecha_hasta=$record['fecha_hasta'];
            $this->moneda=$record['moneda'];
            $this->id=$record['afiliacion_id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
       
    }
    
    
    
    //Busca la afiliacion activa o ultima afiliacion
    public function Fetch($empresa_id) {

        $model = new Conexion;
        $conexion = $model->conectar();
        $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . " WHERE empresa_id = :emp_id order by fecha_hasta desc limit 1");
        $SQL->bindParam(':emp_id', $empresa_id);
        $SQL->execute();
        $record = $SQL->fetch();
        $this->record($record);

        $model = NULL;
    }

    public function Find($id) {
       
       $model = new Conexion;
       $conexion=$model->conectar();
       $SQL = $conexion->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliacion_id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->record($record);
       
       $model=NULL;
       
    }
    
    public function ReadById($afiliacion_id) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id = :id');
       $SQL->bindParam(':id', $afiliacion_id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            return new self($record['ano'],
            $record['fvt'],$record['asociacion'],$record['sistemaweb'],$record['modalidad'],$record['afiliacion_id'],
            $record['fvtciclocobro'],$record['asociacionciclocobro'],$record['sistemawebciclocobro'],
            $record['empresa_id'],$record['ciclo'],$record['fecha_desde'],$record['fecha_hasta'],$record['moneda']);
          
       } else {
             $this->SQLresultado_exitoso=FALSE;
           
       }
       $conn=NULL;
    }
    
    //Buscar las afiliacion activa
    public static function All_Afiliaciones($empresa_id) {

        $model = new Conexion;
        $conn = $model->conectar();
        //$SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id =:empresa_id order by fecha_hasta desc ');
        $SQL->bindParam(':empresa_id', $empresa_id);
        $SQL->execute();
        $records = $SQL->fetchAll();

        $conn = NULL;
        return $records;
    }
    
    
    //Devuelva la data para un Combo List
    public static function data_combo_list($empresa_id) {
        $rsDatos = Afiliacion::All_Afiliaciones($empresa_id);
        $jsondata = array();

        $i = 0;
        foreach ($rsDatos as $value) {
            $i++;
            $dato = array("value" => $value['afiliacion_id'], "texto" => $value['ano']);
            array_push($jsondata, $dato);
        }

        return $jsondata;
        
        
        
    }
    
    

    public function ReadAllByAno($empresa_id,$ano,$estatus=0) {
       $model = new Conexion;
       $conn=$model->conectar();
       //Estatus 1=Disponible 0=todos;
       if ($estatus!=0){
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :emp_id && ano = :ano && estatus = 1 ' .' ORDER BY ano,ciclo asc');
       }else{
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :emp_id && ano = :ano ' .' ORDER BY ano,ciclo asc');
       }
       $SQL->bindParam(':emp_id', $empresa_id);
       $SQL->bindParam(':ano', $ano);
       $SQL->execute();
       $registros = $SQL->fetchall();
       if ($SQL->rowCount()==0)
        {
            $this->SQLresultado_exitoso=FALSE;
            $errorCode= $conn->errorCode();
            $errorInfo=$conn->errorInfo();
            $this->mensaje="ERROR No se encontraron registros..".$errorInfo ;
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
           
            $this->mensaje='Registros encontrados..';
            $this->SQLresultado_exitoso=TRUE;
        }
        
       $conn=NULL;
        
        return $registros;
        
    }
    
    //Busca el ciclo dado de un ano
    public static function ReadByCiclo($empresa_id,$ano,$ciclo) {
       $model = new Conexion;
       $conn=$model->conectar();
       //Cuando es filtrado por una asociacion
       if($empresa_id>0){
           if ($ciclo == 0) {
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :emp_id && ano = :ano  ' . ' ORDER BY ciclo asc');
            } else {
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :emp_id && ano = :ano && ciclo = :ciclo ' . ' ORDER BY ciclo asc');

                $SQL->bindParam(':ciclo', $ciclo);
                
            }
              
            $SQL->bindParam(':emp_id', $empresa_id);
           
       }else{
           //Cuando es filtrado por la federacion
           if ($ciclo == 0) {
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE ano = :ano  ' . ' ORDER BY ciclo asc');
            } else {
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE  ano = :ano && ciclo = :ciclo ' . ' ORDER BY ciclo asc');

                $SQL->bindParam(':ciclo', $ciclo);
            } 
           
       }
       
       $SQL->bindParam(':ano', $ano);
       
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
    
    
    
    
    public function ReadAll() {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' ORDER BY empresa_id asc');
       $SQL->execute();
       $registros = $SQL->fetchall();
       if ($SQL->rowCount()==0)
        {
            $this->SQLresultado_exitoso=FALSE;
            $errorCode= $conn->errorCode();
            $errorInfo=$conn->errorInfo();
            $this->mensaje="ERROR No se encontraron registros..".$errorInfo ;
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
           
            $this->mensaje='Registros encontrados..';
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
    
    
    public function findAfiliacion($empresa_id,$ano) {
        $model = new Conexion;
        $conn=$model->conectar();
        //Estatus 1=Disponible 0=todos;
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE empresa_id = :emp_id && ano = :ano ');
        
        $SQL->bindParam(':emp_id', $empresa_id);
        $SQL->bindParam(':ano', $ano);
        $SQL->execute();
        $record = $SQL->fetch();
        $this->record($record);
        if ($SQL->rowCount()==0)
         {
             $this->SQLresultado_exitoso=FALSE;
             $errorCode= $conn->errorCode();
             $errorInfo=$conn->errorInfo();
             $this->mensaje="ERROR No se encontraron registros..".$errorInfo ;
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
            
             $this->mensaje='Registros encontrados..';
             $this->SQLresultado_exitoso=TRUE;
         }
         
        $conn=NULL;
         
         return $record;
         
     }

    public function isDirty()
    {
        
        return $this->dirty;
       
    }
    
      
    
    
}
               