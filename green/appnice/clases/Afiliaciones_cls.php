<?php



/**
 * Manejo de crup de la tabla de Afiliaciones
 *
 * @author robinson
 */
class Afiliaciones   {
    //put your code here
   
    private $ano;
    private $atleta_id;
    private $categoria;
    private $sexo;
    private $fecha_registro;
    private $fecha_pago;
    private $pagado;
    private $conciliado;
    private $fvt;
    private $asociacion;
    private $id;
    private $sistemaweb;
    private $modalidad;
    private $aceptado;
    private $exonerado;
    
    private $afiliacion_id;
    private $formalizacion;
    private $fecha_formalizacion;
    private $afiliarme;
    private $fecha_conciliado;
    private $moneda;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'afiliaciones';
    const CAMPOS='(ano,atleta_id,categoria, sexo,email,fecha_registro,fecha_pago,fvt,asociacion,sistemaweb,modalidad)';
    const VALORES='(:ano,:atleta_id,:categoria,:sexo,:email,:fecha_registro,:fecha_pago,:pagado,:fvt,:asociacion,:sistemaweb,:modalidad)';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->ano=date("Y");
        $this->atleta_id=0;
        $this->categoria="";
        $this->sexo="";
        $this->fecha_registro=NULL;
        $this->fecha_pago=NULL;
        $this->pagado=0;
        $this->fvt=0;
        $this->asociacion=0;
        $this->sistemaweb=0;
        $this->modalidad='TDC';
        $this->afiliacion_id=0;
        $this->conciliado=0;
        $this->aceptado=0;
        $this->exonerado=0;
        $this->fecha_formalizacion=NULL;
        $this->formalizacion=0;
        $this->afiliarme=0;
        $this->fecha_conciliado=NULL;
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
    
    public function getAtleta_id(){
        return $this->atleta_id;
    }
    public function setAtleta_id($value){
         $this->atleta_id=$value;
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
    
    public function getFecha_Registro(){
        return $this->fecha_registro;
    }
    
    public function getFecha_Pago(){
        return $this->fecha_pago;
    }
    
    public function setFecha_Pago($value){
        $this->fecha_pago=$value;
    }
    
    
    public function getPagado() {
       return $this->pagado;
    }
    
    public function setPagado($value) {
       $this->pagado=$value;
    }
    public function getFVT() {
       return $this->fvt;
    }
    
    public function setFVT($value) {
       $this->fvt=$value;
    }
    
    public function getAsociacion(){
        return $this->asociacion;
    }
    public function setAsociacion($value){
       
         $this->asociacion=$value;
    }
    
    public function getSistemaWeb(){
        return $this->sistemaweb;
    }
    public function setSistemaWeb($value){
         
         $this->sistemaweb=$value;
    }
    
    public function getModalidad() {
       return $this->modalidad;
    }
    
    public function setModalidad($value) {
       $this->modalidad=$value;
    }
    
    
    public function getAfiliacion_id() {
       return $this->afiliacion_id;
    }
    
    public function setAfiliacion_id($value) {
       $this->afiliacion_id=$value;
    }
    
    public function getConciliado() {
       return $this->conciliado;
    }
    
    public function setConciliado($value) {
       $this->conciliado=$value;
    }
    
    public function getAceptado() {
       return $this->aceptado;
    }
    
    public function setAceptado($value) {
       $this->aceptado=$value;
    }
    
    public function getExonerado() {
       return $this->exonerado;
    }
    
    public function setExonerado($value) {
       $this->exonerado=$value;
    }
    
    public function getFecha_Formalizacion(){
        return $this->fecha_formalizacion;
    }
    
    public function setFecha_Formalizacion($value){
        $this->fecha_formalizacion=$value;
    }
    
    //Controla un boleano para indicar que confirmacion de
    public function getFormalizacion() {
       return $this->formalizacion;
    }
    
    public function setFormalizacion($value) {
       $this->formalizacion=$value;
    }
    
    //Indica un boleano para afiliarse
    public function getAfiliarme() {
       return $this->afiliarme;
    }
    
    public function setAfiliarme($value) {
       $this->afiliarme=$value;
    }
    
    public function getFecha_Conciliado(){
        return $this->fecha_conciliado;
    }
    
    public function setFecha_Conciliado($value){
        $this->fecha_conciliado=$value;
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
            
            $campos='(ano,atleta_id,categoria,sexo,pagado,fvt,asociacion,sistemaweb,modalidad,fecha_pago,afiliacion_id,'
                    . 'conciliado,aceptado,formalizacion,fecha_formalizacion,afiliarme,fecha_conciliado,exonerado)';
            
            $valores='(:ano,:atleta_id,:categoria,:sexo,:pagado,:fvt,:asociacion,:sistemaweb,:modalidad,:fecha_pago,'
                    . ':afiliacion_id,:conciliado,:aceptado,:formalizacion,:fecha_formalizacion,:afiliarme,'
                    . ':fecha_conciliado,:exonerado)';
           
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':ano', $this->ano);
            $SQL->bindParam(':atleta_id', $this->atleta_id);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':sexo', $this->sexo);
            $SQL->bindParam(':pagado', $this->pagado);
            $SQL->bindParam(':fvt',  $this->fvt);
            $SQL->bindParam(':asociacion', $this->asociacion);
            $SQL->bindParam(':sistemaweb', $this->sistemaweb);
            $SQL->bindParam(':modalidad', $this->modalidad);
            $SQL->bindParam(':fecha_pago', $this->fecha_pago,  PDO::PARAM_STR);
            $SQL->bindParam(':afiliacion_id', $this->afiliacion_id);
            $SQL->bindParam(':conciliado', $this->conciliado);
            $SQL->bindParam(':aceptado', $this->aceptado);
            $SQL->bindParam(':fecha_formalizacion', $this->fecha_formalizacion,  PDO::PARAM_STR);
            $SQL->bindParam(':formalizacion', $this->formalizacion);
            $SQL->bindParam(':afiliarme', $this->afiliarme);
            $SQL->bindParam(':fecha_conciliado', $this->fecha_conciliado,  PDO::PARAM_STR);
            $SQL->bindParam(':exonerado', $this->exonerado);    
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
           
            $SQL=' SET ano = :xano, atleta_id=:xatleta_id,categoria = :xcategoria, sexo= :xsexo, pagado = :xpagado, '
                . 'fvt = :xfvt, asociacion = :xasociacion, sistemaweb = :xsistemaweb, '
                . 'modalidad = :xmodalidad, fecha_pago = :xfecha_pago,'
                . 'afiliacion_id = :xafiliacion_id,conciliado = :xconciliado,aceptado = :xaceptado,'
                . 'formalizacion = :xformalizacion,fecha_formalizacion = :xfecha_formalizacion,'
                . 'afiliarme = :xafiliarme,fecha_conciliado =:xfecha_conciliado,exonerado=:xexonerado';
                    
            
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE afiliaciones_id= :xid');
            $stmt->bindParam(':xid', $this->id);
            $stmt->bindParam(':xano', $this->ano);
            $stmt->bindParam(':xatleta_id', $this->atleta_id);
            $stmt->bindParam(':xcategoria', $this->categoria);
            $stmt->bindParam(':xsexo', $this->sexo);
            $stmt->bindParam(':xpagado', $this->pagado);
            $stmt->bindParam(':xfvt',  $this->fvt);
            $stmt->bindParam(':xasociacion', $this->asociacion);
            $stmt->bindParam(':xsistemaweb', $this->sistemaweb);
            $stmt->bindParam(':xmodalidad', $this->modalidad);
            $stmt->bindParam(':xfecha_pago', $this->fecha_pago,  PDO::PARAM_STR);
            $stmt->bindParam(':xafiliacion_id', $this->afiliacion_id);
            $stmt->bindParam(':xconciliado', $this->conciliado);
            $stmt->bindParam(':xaceptado', $this->aceptado);
            $stmt->bindParam(':xfecha_formalizacion', $this->fecha_formalizacion,  PDO::PARAM_STR);
            $stmt->bindParam(':xformalizacion', $this->formalizacion);
            $stmt->bindParam(':xafiliarme', $this->afiliarme);
            $stmt->bindParam(":xfecha_conciliado", $this->fecha_conciliado,  PDO::PARAM_STR);
            $stmt->bindParam(':xexonerado', $this->exonerado);
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
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE afiliaciones_id= :id');
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
    
    static public function CuantasAfiliacionesTieneUnAtleta($atleta_id) {

        $model = new Conexion;
        $conn = $model->conectar();
        $SQL = $conn->prepare('SELECT count(*) as total FROM ' . self::TABLA . ' WHERE atleta_id =:atleta_id && formalizacion>0');

        $SQL->bindParam(':atleta_id', $atleta_id);
        $SQL->execute();
        $record = $SQL->fetch();
        return $record['total']; 
            
        

        $conn = NULL;
    }

    public function Fetch($afiliacion_id,$atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       //$SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id = :id && atleta_id =:atleta_id');
       
       $SQL->bindParam(':id', $afiliacion_id);
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);

       $conn=NULL;
       
    }
    //Buscar ultima afiliacion de atleta
     public function Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       //$SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE atleta_id =:atleta_id && ano=:ano');
       $SQL->bindParam(':ano', $ano_afiliacion);
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);

       $conn=NULL;
       
    }
    
    
    //Buscar todas las afiliacion de una asociacion
    public static function All_Afiliaciones($ano_afiliacion,$afiliacion_id) {
      
       $model = new Conexion;
       $conn=$model->conectar();
       if ($ano_afiliacion>0){
           $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE ano=:ano && pagado>0 ORDER BY categoria ');
           $SQL->bindParam(':ano', $ano_afiliacion);
       }else{
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id =:afiliacion_id && pagado>0 ORDER BY categoria ');
            $SQL->bindParam(':afiliacion_id', $afiliacion_id);
       }
       $SQL->execute();
       $records = $SQL->fetchall();
       
       $conn=NULL;
       return $records;
       
    }
    
    
    //Buscar todas las afiliacion de una asociacion
    public static function All_Afiliaciones_Ano($ano_afiliacion) {
      
        $model = new Conexion;
        $conn=$model->conectar();
       
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE ano=:ano && pagado>0 ORDER BY categoria ');
        $SQL->bindParam(':ano', $ano_afiliacion);
       
       $SQL->execute();
       $records = $SQL->fetchall();
       
       $conn=NULL;
       return $records;
       
    }
    
    //Buscar todas las afiliacion de una asociacion
    public static function All_Afiliaciones_ID($afiliacion_id) {
      
        $model = new Conexion;
        $conn=$model->conectar();
       
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id=:id && pagado>0 ORDER BY categoria ');
        $SQL->bindParam(':id', $afiliacion_id);
       
       $SQL->execute();
       $records = $SQL->fetchall();
       
       $conn=NULL;
       return $records;
       
    }
    
   
    
    //Buscar ultima afiliacion de atleta
     public function Atleta($atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       //$SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE atleta_id =:atleta_id order by ano desc limit 1');
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);

       $conn=NULL;
       
    }
    
    //Buscar todas las afiliacion del atleta
    public static function All_Afiliaciones_Atleta($atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       //$SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE atleta_id =:atleta_id order by ano desc');
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetchall();
       return $record;

       $conn=NULL;
       
    }
    
    
    
    
    
     
    
    
    
    public function Find($afiliaciones_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE afiliaciones_id = :id');
       $SQL->bindParam(':id', $afiliaciones_id);
      
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
    }
    
    private function Record($record) {
       if($record){
            
            $this->ano=$record['ano'];
            $this->atleta_id=$record['atleta_id'];
            $this->categoria= $record['categoria'];
            $this->sexo= $record['sexo'];
            $this->pagado=$record['pagado'];
            $this->fvt=$record['fvt'];
            $this->sistemaweb=$record['sistemaweb'];
            $this->modalidad=$record['modalidad'];
            $this->asociacion=$record['asociacion'];
            $this->fecha_registro=$record['fecha_registro'];
            $this->fecha_pago=$record['fecha_pago'];
            $this->afiliacion_id=$record['afiliacion_id'];
            $this->conciliado=$record['conciliado'];
            $this->aceptado=$record['aceptado'];
            $this->fecha_formalizacion=$record['fecha_formalizacion'];
            $this->formalizacion=$record['formalizacion'];
            $this->afiliarme=$record['afiliarme'];
            $this->fecha_conciliado=$record['fecha_conciliado'];
            $this->exonerado=$record['exonerado'];
            $this->id=$record['afiliaciones_id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
//            echo "New records created successfully";
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
      
        
    }
     
       
    public function rsAfiliacionesConciliadas($afiliacion_id) {
       $SQL ='SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id && pagado>0 && conciliado>0 ORDER BY fecha_pago desc';
       $registros =$this->rsAfiliacionesFiltro($afiliacion_id,$SQL);
       return $registros;
        
    }
    
    public function rsAfiliacionesNoConciliadas($afiliacion_id) {
        
        $SQL ='SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id=:id && pagado>0 && conciliado=0 ORDER BY fecha_pago desc';
        $registros = $this->rsAfiliacionesFiltro($afiliacion_id, $SQL);
        return $registros;
    }
    
    public function rsAfiliacionesTodas($afiliacion_id) {
       
       $SQL ='SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id  ORDER BY pagado desc';
       $registros =$this->rsAfiliacionesFiltro($afiliacion_id,$SQL);
       return $registros;
        
    }
    
    public function rsAfiliacionesPorPagar($afiliacion_id) {
       
        $SQL ='SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id && pagado>0 && conciliado=0 ORDER BY fecha_pago desc';
      
        $registros =$this->rsAfiliacionesFiltro($afiliacion_id,$SQL);
        return $registros;
        
    }
    
    public function rsAfiliacionesFormalizadas($afiliacion_id) {
        
        $SQL ='SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id &&  formalizacion>0  ORDER BY fecha_formalizacion desc';
        $registros =$this->rsAfiliacionesFiltro($afiliacion_id,$SQL);
        return $registros;
        
    }
    
    public function rsAfiliacionesNoFormalizadas($afiliacion_id) {
        
        $SQL = 'SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id=:id && afiliarme>0 && formalizacion!=1  ORDER BY fecha_formalizacion desc';
        $registros = $this->rsAfiliacionesFiltro($afiliacion_id, $SQL);
        return $registros;
    }
    
    public function GetRangoPorFecha($fechaDesde,$fechaHasta) {
        $model = new Conexion;
        $conn=$model->conectar();  
        $SQL ='SELECT * FROM ' . self::TABLA .' WHERE fecha_pago>:fdesde && fecha_pago<:fhasta && pagado>0 ORDER BY fecha_pago desc';
        
        $SQL = $conn->prepare($SQL);
        $SQL->bindParam(':fdesde', $fechaDesde);
        $SQL->bindParam(':fhasta', $fechaHasta);
        $SQL->execute();
       
        $registros = $SQL->fetchall();
        return $registros;
        
    }
    public function rsAfiliacionesWebFormalizadas($afiliacion_id) {
          
        $SQL ='SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id && formalizacion>0 && pagado>0 ORDER BY fecha_pago desc';
        $registros =$this->rsAfiliacionesFiltro($afiliacion_id,$SQL);
        return $registros;
        
    }
    
    public function rsAfiliacionesWebNoFormalizadas($afiliacion_id) {

        $SQL = 'SELECT * FROM ' . self::TABLA . ' WHERE afiliacion_id=:id && formalizacion>0 && pagado!=1  ORDER BY fecha_pago desc';
        $registros = $this->rsAfiliacionesFiltro($afiliacion_id, $SQL);
        return $registros;
    }

    private function rsAfiliacionesFiltro($afiliacion_id,$SQL) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($SQL);
       $SQL->bindParam(':id', $afiliacion_id);
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
    
    //Devuelve una collecion de afiliados de una afiliacion anual
    public function ReadAll($afiliacion_id) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE afiliacion_id=:id ORDER BY pagado desc');
       $SQL->bindParam(':id', $afiliacion_id);
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
               