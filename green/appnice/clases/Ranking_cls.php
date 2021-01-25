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
class Ranking   {
    //put your code here
    private $id;
    
    private $atleta_id;
    private $categoria;
    private $rknacional;
    private $rkregional;
    private $rkestadal;
    private $fecha_ranking;
    private $rkcosat;
    private $fecha_ranking_cosat;
    private $rkitf;
    private $fecha_ranking_itf;
    private $rkcotec;
    private $fecha_ranking_cotec;
    private $rkint;
    private $fecha_ranking_int;
    private $puntos;
    private $penalidad;
    private $disciplina;
    private $rank_id;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'ranking';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->atleta_id= 0;
        $this->categoria='';
        $this->rknacional=0;
        $this->rkregional=0;
        $this->rkestadal=0;
        $this->fecha_ranking= NULL;
        $this->rkcosat=0;
        $this->fecha_ranking_cosat=NULL;
        $this->rkitf=0;
        $this->fecha_ranking_itf=NULL;
        $this->rkcotec=0;
        $this->fecha_ranking_cotec=NULL;
        $this->rkint=0;
        $this->fecha_ranking_int=NULL;
        $this->puntos=0;
        $this->penalidad=0;
        $this->disciplina=NULL;
        $this->rank_id=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function ID(){
        return $this->id;
    }
    
    public function getAtleta_id(){
        return $this->atleta_id;
    }
    public function setAtleta_id($value){
         $this->atleta_id=$value;
    }
   
    public function getCategoria() {
       return $this->categoria;
    }
    public function setCategoria($value) {
       $this->categoria=$value;
    }
    public function getRknacional() {
       return $this->rknacional;
    }
    public function setRknacional($value) {
       $this->rknacional=$value;
    }
    public function getRkregional() {
       return $this->rkregional;
    }
    public function setRkregional($value) {
       $this->rkregional=$value;
    }
    public function getRkestadal() {
       return $this->rkestadal;
    }
    public function setRkestadal($value) {
       $this->rkestadal=$value;
    }
    public function getFechaRankingNacional() {
       return $this->fecha_ranking;
    }
    public function setFechaRankingNacional($value) {
       $this->fecha_ranking=$value;
    }  
    public function getRkCosat() {
       return $this->rkcosat;
    }
    public function setRkCosat($value) {
       $this->rkcosat=$value;
    }
     public function getFechaRankingCosat() {
       return $this->fecha_ranking_cosat;
    }
    public function setFechaRankingCosat($value) {
       $this->fecha_ranking_cosat=$value;
    }
    
    public function getRKitf() {
       return $this->rkitf;
    }
    public function setRKitf($value) {
       $this->rkitf=$value;
    }
     public function getFechaRankingITF() {
       return $this->fecha_ranking_itf;
    }
    public function setFechaRankingITF($value) {
       $this->fecha_ranking_itf=$value;
    }
    public function getRkCotec() {
       return $this->rkcotec;
    }
    public function setRkCotec($value) {
       $this->rkcotec=$value;
    }
     public function getFechaRankingCotec() {
       return $this->fecha_ranking_cotec;
    }
    public function setFechaRankingCotec($value) {
       $this->fecha_ranking_cotec=$value;
    }
    
    public function getRkInt() {
       return $this->rkint;
    }
    public function setRkInt($value) {
       $this->rkint=$value;
    }
     public function getFechaRankingInt() {
       return $this->fecha_ranking_int;
    }
    public function setFechaRankingInt($value) {
       $this->fecha_ranking_int=$value;
    }
    
    public function getPuntos() {
       return $this->puntos;
    }
    public function setPuntos($value) {
       $this->puntos=$value;
      
    }
    
    public function getPenalidad() {
       return $this->penalidad;
    }
    public function setPenalidad($value) {
       $this->penalidad=$value;
    }
    
    public function getDisciplina() {
       return $this->disciplina;
    }
    public function setDisciplina($value) {
       $this->disciplina=$value;
    }
    
    public function getRank_id() {
       return $this->rank_id;
    }
    public function setRank_id($value) {
       $this->rank_id=$value;
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
            
            $campos='(atleta_id, categoria,rknacional,rkregional,rkestadal,fecha_ranking,rkcosat,fecha_ranking_cosat,'
                    . 'rkitf,fecha_ranking_itf,rkcotec,fecha_ranking_cotec,rkint,fecha_ranking_int,'
                    . 'puntos,penalidad,disciplina,rank_id)';
            $valores='(:atleta_id,:categoria,:rknacional,:rkregional,:rkestadal,:fecha_ranking,:rkcosat,:fecha_ranking_cosat,'
                    . ':rkitf,:fecha_ranking_itf,:rkcotec,:fecha_ranking_cotec,:rkint,:fecha_ranking_int,'
                    . ':puntos,:penalidad,:disciplina,:rank_id)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':atleta_id', $this->atleta_id);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':rknacional',  $this->rknacional);
            $SQL->bindParam(':rkregional',  $this->rkregional);
            $SQL->bindParam(':rkestadal',  $this->rkestadal);
            $SQL->bindParam(':fecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $SQL->bindParam(':rkcosat', $this->rkcosat);
            $SQL->bindParam(':fecha_ranking_cosat', $this->fecha_ranking_cosat,PDO::PARAM_STR);
            $SQL->bindParam(':rkitf', $this->rkitf);
            $SQL->bindParam(':fecha_ranking_itf', $this->fecha_ranking_itf,PDO::PARAM_STR);
            $SQL->bindParam(':rkcotec', $this->rkcotec);
            $SQL->bindParam(':fecha_ranking_cotec', $this->fecha_ranking_cotec,PDO::PARAM_STR);
            $SQL->bindParam(':rkint', $this->rkint);
            $SQL->bindParam(':fecha_ranking_int', $this->fecha_ranking_int,PDO::PARAM_STR);
            $SQL->bindParam(':puntos', $this->puntos);
            $SQL->bindParam(':penalidad', $this->penalidad);
            $SQL->bindParam(':disciplina', $this->disciplina);
            $SQL->bindParam(':rank_id', $this->rank_id);
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
            $SQLstr=' SET atleta_id= :atleta_id,'
                    . 'categoria = :categoria, rknacional = :rknacional, rkregional = :rkregional, '
                    . 'rkestadal = :rkestadal,fecha_ranking = :fecha_ranking,'
                    . 'rkcosat = :rkcosat, fecha_ranking_cosat = :fecha_ranking_cosat,'
                    . 'rkitf = :rkitf, fecha_ranking_itf = :fecha_ranking_itf,'
                    . 'rkcotec = :rkcotec, fecha_ranking_cotec = :fecha_ranking_cotec,'
                    . 'rkint = :rkint, fecha_ranking_int = :fecha_ranking_int,'
                    . 'puntos = :puntos, penalidad = :penalidad, disciplina=:disciplina, rank_id=:rank_id';
                   


            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQLstr. ' WHERE torneoinscrito_id= :id');
                    
            $stmt->bindParam(':id', $this->id);
            
            $stmt->bindParam(':atleta_id', $this->atleta_id);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':rknacional', $this->rknacional);
            $stmt->bindParam(':rkregional', $this->rkregional);
            $stmt->bindParam(':rkestadal', $this->rkestadal);
            $stmt->bindParam(':fecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $stmt->bindParam(':rkcosat', $this->rkcosat);
            $stmt->bindParam(':fecha_ranking_cosat', $this->fecha_ranking_cosat,PDO::PARAM_STR);
            $stmt->bindParam(':rkitf', $this->rkitf);
            $stmt->bindParam(':fecha_ranking_itf', $this->fecha_ranking_itf,PDO::PARAM_STR);
            $stmt->bindParam(':rkcotec', $this->rkcotec);
            $stmt->bindParam(':fecha_ranking_cotec', $this->fecha_ranking_cotec,PDO::PARAM_STR);
            $stmt->bindParam(':rkint', $this->rkint);
            $stmt->bindParam(':fecha_ranking_int', $this->fecha_ranking_int,PDO::PARAM_STR);
            $stmt->bindParam(':puntos', $this->puntos);
            $stmt->bindParam(':penalidad', $this->penalidad);
            $stmt->bindParam(':disciplina', $this->disciplina);
            $stmt->bindParam(':rank_id', $this->rank_id);
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
  
    public static function DeleteCategoria($disciplina,$categoria,$fechark,$sexo) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE disciplina=:disciplina && categoria=:categoria && sexo=:sexo && fecha_ranking=:fechark');
            $SQL->bindParam(':categoria', $categoria);
            $SQL->bindParam(':disciplina',$disciplina);
            $SQL->bindParam(":fechark",$fechark, PDO::PARAM_STR);
            $SQL->bindParam(":sexo",$sexo);
            $SQL->execute();
        
            //echo "New records created successfully";
            $mensaje='Record Delete successfully';
            $SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $mensaje="Error Delete: " . $e->getMessage();
            $SQLresultado_exitoso=FALSE;
        }
        $conn = null;
       
    }
    
    
    public static function DeleteCategoriaByRank_id($rank_id) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE rank_id=:rank_id');
            $SQL->bindParam(':rank_id', $rank_id);
            $SQL->execute();
        
            //echo "New records created successfully";
            $mensaje='Record Delete successfully';
            $SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
           // var_dump("Error: " . $e->getMessage());
            $mensaje="Error Delete: " . $e->getMessage();
            $SQLresultado_exitoso=FALSE;
        }
        $conn = null;
       
    }
   
    
     public function Delete($id) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE ranking= :id');
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
   
     //Devuelve el ultimo ranking de un jugador 
     public function Find($atleta_id,$categoria) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE atleta_id = :atleta_id && categoria = :categoria ORDER BY fecha_ranking desc limit 1");
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->bindParam(':categoria', $categoria);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->record($record);
            $this->SQLresultado_exitoso=TRUE;
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
    //Busca una ranking segun la tabla de Fechas de Ranking
    public function Find_Ranking_By_Fecha($atleta_id,$rank_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . 
               " WHERE atleta_id = :atleta_id && rank_id=:rank_id ");
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->bindParam(':rank_id', $rank_id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->record($record);
            $this->SQLresultado_exitoso=TRUE;
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
            
    //Cargar Propiedades
   private function record($record){
            $this->atleta_id= $record['atleta_id'];
            $this->categoria= $record['categoria'];
            $this->rknacional=$record['rknacional'];
            $this->rkregional=$record['rkregional'];
            $this->rkestadal=$record['rkestadal'];
            $this->fecha_ranking=$record['fecha_ranking'];
            $this->rkcosat=$record['rkcosat'];
            $this->fecha_ranking_cosat=$record['fecha_ranking_cosat'];
            $this->rkitf=$record['rkitf'];
            $this->fecha_ranking_itf=$record['fecha_ranking_itf'];
            $this->rkcotec=$record['rkcotec'];
            $this->fecha_ranking_cotec=$record['fecha_ranking_cotec'];
            $this->rkint=$record['rkint'];
            $this->fecha_ranking_int=$record['fecha_ranking_int'];
            $this->puntos=$record['puntos'];
            $this->penalidad=$record['penalidad'];
            $this->disciplina=$record['disciplina'];
            $this->rank_id=$record['rank_id'];
            $this->id=$record['ranking_id'];
   }
    
    public function Fetch($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE ranking_id = :id");
       $SQL->bindParam(':id', $id);
       
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->record($record);
            
            $this->SQLresultado_exitoso=TRUE;
            
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
    
    //Devuelve los registros deL ranking de un atleta
    public static function CountRankingByAtleta($atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT COUNT(*) as TOTAL_RECORDS FROM " . self::TABLA . " "
               . " WHERE atleta_id =:atleta_id "
               . " ");
       $SQL->bindParam(':atleta_id', $atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $conn=NULL;
       if ($record){
           return $record['TOTAL_RECORDS'];
       }else{
           return 0;
       }
    }
    
    //Devuelve los registros deL ranking de un atleta
    public static function ReadRankingByAtleta($atleta_id,$inicio=0,$recordxpagina=0) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " "
               . " WHERE atleta_id =:atleta_id "
               . " ORDER BY categoria,fecha_ranking desc "
               . " LIMIT $inicio,$recordxpagina ");
       $SQL->bindParam(':atleta_id', $atleta_id);
       //$SQL->bindParam(':inicio', $inicio);
       //$SQL->bindParam(':recordxpagina', $recordxpagina);
       $SQL->execute();
       $records = $SQL->fetchAll();
       
       $conn=NULL;
       return $records;
    }
    
    //Cuenta los registros deL ranking por fecha para paginacion
    public static function CountRankingByDate($rank_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT COUNT(*) as TOTAL_RECORDS FROM " . self::TABLA . " "
               . " WHERE rank_id =:rank_id "
               . " ");
       $SQL->bindParam(':rank_id', $rank_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $conn=NULL;
       if ($record){
           return $record['TOTAL_RECORDS'];
       }else{
           return 0;
       }
    }
   //Consulta Ranking por Fecha 
    public static function ReadRankingByDate($rank_id,$inicio=0,$recordxpagina=0) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " "
               . " WHERE rank_id =:rank_id "
               . " ORDER BY rknacional,rkregional,rkestadal "
               . " LIMIT $inicio,$recordxpagina ");
       $SQL->bindParam(':rank_id', $rank_id);
       //$SQL->bindParam(':inicio', $inicio);
       //$SQL->bindParam(':recordxpagina', $recordxpagina);
       $SQL->execute();
       $records = $SQL->fetchAll();
       
       $conn=NULL;
       return $records;
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
        
        $conexion=NULL;
    }
    
   
    public function isDirty()
    {
        
        return $this->dirty;
       
    }
    
      
    
    
}
               