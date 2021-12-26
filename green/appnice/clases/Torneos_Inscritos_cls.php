
<?php



class TorneosInscritos   {
    //put your code here
    
    private $id;
    private $torneo_id;
    private $atleta_id;
    private $fecha_registro;
    private $estatus;
    private $sexo;
    private $categoria;
    private $rknacional;
    private $fecha_ranking;
    private $pagado;
    private $singles;
    private $dobles;
    private $penalidad;
    private $condicion;
    private $codigo;
    private $modalidad;
    private $entidad;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneoinscritos';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->id=0;
        $this->torneo_id=0;
        $this->atleta_id=0;
        
        $this->estatus='';
        $this->categoria='';
        $this->sexo='';
        $this->rknacional=0;
        $this->fecha_ranking= 0;
        $this->rkcosat=0;
        $this->fecha_ranking_cosat=0;
        $this->pagado=0;
        $this->singles=0;
        $this->penalidad=0;
        $this->condicion=0;
        $this->codigo='';
        $this->modalidad='';
        $this->entidad ='';
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function ID(){
        return $this->id;
    }
    public function getTorneo_id(){
        return $this->torneo_id;
    }
    public function setTorneo_id($value){
         $this->torneo_id=$value;
    }
    public function getAtleta_id(){
        return $this->atleta_id;
    }
    public function setAtleta_id($value){
         $this->atleta_id=$value;
    }
    public function getFecha_Registro(){
        return $this->Fecha_Registro;
    }
    public function getEstatus(){
        return $this->estatus;
    }
    public function setEstatus($value){
        $this->estatus=$value;
    }
    public function getCategoria() {
       return $this->categoria;
    }
    public function setCategoria($value) {
       $this->categoria=$value;
    }
    public function getSexo() {
       return $this->sexo;
    }
    public function setSexo($value) {
       $this->sexo=$value;
    }
    public function getRknacional() {
       return $this->rknacional;
    }
    public function setRknacional($value) {
       $this->rknacional=$value;
    }
    
    public function getFechaRanking() {
       return $this->fecha_ranking;
    }
    public function setFechaRanking($value) {
       $this->fecha_ranking=$value;
    }
    public function getFechaRegistro() {
        return $this->fecha_registro;
    }
    
    public function getPagado() {
       return $this->pagado;
    }
    public function setPagado($value) {
       $this->pagado=$value;
    }
    public function getSingles() {
       return $this->singles;
    }
    public function setSingles($value) {
       $this->singles=$value;
    }
    public function getDobles() {
       return $this->dobles;
    }
    public function setDobles($value) {
       $this->dobles=$value;
    }
    public function getPenalidad() {
       return $this->penalidad;
    }
    public function setPenalidad($value) {
       $this->penalidad=$value;
    }
    //Para manejar la condicion en caso de la lista de aceptacion
    // 0=normal, 1=Main Draw, 2= WC Main Draw, 3= Qualy, 4=WC Qualy, 5=Alterno, 9=Retiro
    public function getCondicion() {
       return $this->condicion;
    }
    public function setCondicion($value) {
       $this->condicion=$value;
    }
    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($value) {
        $this->codigo=$value;
    }
    public function getModalidad() {
        return $this->modalidad;
    }
    public function setModalidad($value) {
        $this->modalidad=$value;
    }
    public function getEntidad() {
        return $this->entidad;
    }
    public function setEntidad($value) {
        $this->entidad=$value;
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
            
            $campos='(torneo_id, atleta_id, estatus, categoria, rknacional,fecha_ranking,pagado,
            singles,penalidad,dobles,sexo,condicion,codigo,modalidad,entidad)';
            $valores='(:torneo_id, :atleta_id, :estatus, :categoria, :rknacional, :fecha_ranking, :pagado,
            :singles, :penalidad, :dobles, :sexo, :condicion, :codigo, :modalidad, :entidad)';
            
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            $SQL->bindParam(':torneo_id', $this->torneo_id);
            $SQL->bindParam(':atleta_id', $this->atleta_id);
            $SQL->bindParam(':estatus', $this->estatus);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':rknacional',  $this->rknacional);
            $SQL->bindParam(':fecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $SQL->bindParam(':pagado', $this->pagado);
            $SQL->bindParam(':singles', $this->singles);
            $SQL->bindParam(':penalidad', $this->penalidad);
            $SQL->bindParam(':dobles', $this->dobles);
            $SQL->bindParam(':sexo', $this->sexo);
            $SQL->bindParam(':condicion', $this->condicion);
            $SQL->bindParam(':codigo', $this->codigo);
            $SQL->bindParam(':modalidad', $this->modalidad);
            $SQL->bindParam(':entidad', $this->entidad);
        
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
           $SQLstr=' SET torneo_id = :xtorneo_id,atleta_id= :xatleta_id,estatus = :xestatus, '
                    . 'categoria = :xcategoria, rknacional = :xrknacional, fecha_ranking = :xfecha_ranking,'
                    . ' pagado = :xpagado,'
                    . 'singles = :xsingles, penalidad = :xpenalidad, dobles = :xdobles,sexo = :xsexo, '
                    . 'condicion = :xcondicion,codigo = :xcodigo, modalidad=:xmodalidad, entidad=:xentidad';


            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQLstr. ' WHERE torneoinscrito_id= :id');
                    
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':xtorneo_id', $this->torneo_id);
            $stmt->bindParam(':xatleta_id', $this->atleta_id);
            $stmt->bindParam(':xestatus', $this->estatus);
            $stmt->bindParam(':xcategoria', $this->categoria);
            $stmt->bindParam(':xrknacional', $this->rknacional);
            $stmt->bindParam(':xfecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $stmt->bindParam(':xpagado', $this->pagado);
            $stmt->bindParam(':xsingles', $this->singles);
            $stmt->bindParam(':xpenalidad', $this->penalidad);
            $stmt->bindParam(':xdobles', $this->dobles);
            $stmt->bindParam(':xsexo', $this->sexo);
            $stmt->bindParam(':xcondicion', $this->condicion);
            $stmt->bindParam(':xcodigo', $this->codigo);
            $stmt->bindParam(':xmodalidad', $this->modalidad);
            $stmt->bindParam(':xentidad', $this->entidad);
            $stmt->execute();

            //echo "New records created successfully";
            $this->mensaje='Record update successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
            $this->mensaje="Error Update: " . $e->getMessage();
            $this->SQLresultado_exitoso=FALSE;
        }
        $conn = null;
        
        
    }
    
     
    
    public function Delete($id) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE torneoinscrito_id= :id');
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
       
    
     public function Fetch($torneo_inscrito_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE torneoinscrito_id = :id");
       $SQL->bindParam(':id', $torneo_inscrito_id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            $this->torneo_id=$record['torneo_id'];
            $this->atleta_id= $record['atleta_id'];
            $this->categoria= $record['categoria'];
            $this->estatus=$record['estatus'];
            $this->rknacional=$record['rknacional'];
            $this->fecha_ranking=$record['fecha_ranking'];
            $this->pagado=$record['pagado'];
            $this->singles=$record['singles'];
            $this->dobles=$record['dobles'];
            $this->penalidad=$record['penalidad'];
            $this->sexo=$record['sexo'];
            $this->condicion=$record['condicion'];
            $this->id=$record['torneoinscrito_id'];
            $this->fecha_registro=$record['fecha_registro'];
            $this->codigo=$record['codigo'];
            $this->modalidad=$record['modalidad'];
            $this->entidad=$record['entidad'];
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
       
    }
    
    public function ReadById($id) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE torneoinscrito_id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
            $this->SQLresultado_exitoso=TRUE;
            return new self($record['torneo_id'],$record['torneoinscrito_id'], 
            $record['atleta_id'], $record['categoria'],$record['estatus'],
            $record['fecha_registro'],$record['rknacional'],$record['fecha_ranking'],
            $record['pagado'],$record['singles'],$record['dobles'],$record['penalidad'],
            $record['sexo'],$record['condicion'],$record['codigo'],$record['modalidad'],$record['entidad']);
          
       } else {
             $this->SQLresultado_exitoso=FALSE;
           
       }
       $conn=NULL;
    }
    
    public function ReadByAtletaId($torneo_id,$atleta_id) {
       
       $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && atleta_id = '.$atleta_id.' ORDER BY fecha_registro desc';
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($prepare);
       $SQL->execute();
       $registros = $SQL->fetch();
       
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
            $this->mensaje='Records Found successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
 
        $conn=NULL;
        
        return $registros;
    }

    //Devuelve torneos inscritos de un atleta
    public static function TorneosByAtletaId($torneo_id,$atleta_id) {
       
        $prepare = 'SELECT * FROM ' . self::TABLA 
        . ' WHERE torneo_id = '.$torneo_id
        .' && atleta_id = '.$atleta_id
        .' ORDER BY fecha_registro desc';
        
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registro = $SQL->fetch();
        
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
                   
         }else{
             $mensaje='Records Found successfully';
             $SQLresultado_exitoso=TRUE;
         }
  
         $conn=NULL;
         
         return $registro;
     }
    
    private function record($record) {
        
        if($record){
            $this->SQLresultado_exitoso=TRUE;
            $this->torneo_id=$record['torneo_id'];
            $this->atleta_id= $record['atleta_id'];
            $this->categoria= $record['categoria'];
            $this->estatus=$record['estatus'];
            $this->rknacional=$record['rknacional'];
            $this->fecha_ranking=$record['fecha_ranking'];
            $this->pagado=$record['pagado'];
            $this->singles=$record['singles'];
            $this->dobles=$record['dobles'];
            $this->penalidad=$record['penalidad'];
            $this->sexo=$record['sexo'];
            $this->condicion=$record['condicion'];
            $this->codigo=$record['codigo'];
            $this->modalidad=$record['modalidad'];
            $this->entidad=$record['entidad'];
            $this->id=$record['torneoinscrito_id'];
            $this->fecha_registro=$record['fecha_registro'];
            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
        
    }
    
       
    public function Find_Atleta($torneo_id,$atleta_id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE torneo_id = :torneo_id && atleta_id=:atleta_id");
       $SQL->bindParam(':torneo_id', $torneo_id);
       $SQL->bindparam(':atleta_id',$atleta_id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->record($record);
       $conn=NULL;
       
    }
    
    //Actualiza todos los ranking 
    public static function UpdateRanking(){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $SQLstr='    UPDATE torneoinscritos T1,ranking T2, torneo T3
                        SET T1.rknacional = T2.rknacional, T1.fecha_ranking =T2.fecha_ranking

                        WHERE T1.atleta_id=T2.atleta_id && T1.categoria=T2.categoria 
                        && (T1.torneo_id=T3.torneo_id && T3.fecha_inicio_torneo>now())';


            $stmt = $conn->prepare($SQLstr);
            
            $stmt->execute();

            //echo "New records created successfully";
            $mensaje='Record update successfully';
            $SQLresultado_exitoso=TRUE;
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $mensaje="Error Update: " . $e->getMessage();
            $SQLresultado_exitoso=FALSE;
        }
        $conn = null;
        
        
    }
    //Actualiza todos los ranking 
    public static function UpdateRankingByDate($disciplina,$fecha_ranking,$categoria,$sexo){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $strSQL="   
                        UPDATE torneoinscritos T1,ranking T2, torneo T3, atleta T4
                        SET T1.rknacional = 999
                        WHERE 
                        T1.atleta_id=T4.atleta_id 
                        && T1.torneo_id=T3.torneo_id 
                        && T3.fecha_inicio_torneo>:fechark
                        && T1.categoria=:categoria 
                        && T4.sexo=:sexo
                        && T3.modalidad=:disciplina; ";
            
            $strSQL2="   
                        UPDATE torneoinscritos T1,ranking T2, torneo T3, atleta T4
                        SET T1.rknacional = T2.rknacional, T1.fecha_ranking =T2.fecha_ranking
                        WHERE 
                        T1.atleta_id=T2.atleta_id 
                        && T1.atleta_id=T4.atleta_id 
                        && T1.categoria=T2.categoria 
                        && T1.torneo_id=T3.torneo_id 
                        && T3.fecha_inicio_torneo>T2.fecha_ranking
                        && T2.fecha_ranking=:fechark
                        && T2.categoria=:categoria 
                        && T4.sexo=:sexo 
                        && T3.modalidad=:disciplina;";
            
            $SQL = $conn->prepare($strSQL.$strSQL2);
            $SQL->bindParam(':fechark', $fecha_ranking,  PDO::PARAM_STR);
            $SQL->bindParam(':categoria', $categoria);
            $SQL->bindParam(':disciplina', $disciplina);
            $SQL->bindParam(':sexo', $sexo);
            $SQL->execute();
            $mensaje='Record update successfully';
            $SQLresultado_exitoso=TRUE;
            $objConn = NULL;$conn=null;
            
        }
        catch(PDOException $e)
        {
            //echo "Error: " . $e->getMessage();
            $mensaje="Error Update: " . $e->getMessage();
            $SQLresultado_exitoso=FALSE;
        }
        $conn = null;
        
        return $mensaje;
    }
 
    
    public function ReadAll($torneo_id=0,$atleta_id=0,$categoria='') {
        if ($torneo_id>0 && $atleta_id>0){
           $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && atleta_id = '.$atleta_id.' ORDER BY fecha_registro desc';
        }elseif ($torneo_id>0){
            if($categoria!=''){
                $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && categoria = '.$categoria.' ORDER BY rknacional';
            }else{
                $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' ORDER BY rknacional';
            }
        }elseif ($atleta_id>0){
           $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE atleta_id = '.$atleta_id.' ORDER BY fecha_registro desc';

        }
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($prepare);
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
            $this->mensaje='Records Found successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
    
        $conn=NULL;
        
        return $registros;
        
    }
    
    public static function Inscritos($torneo_id,$categoria,$sexo) {
        if ($torneo_id>0){
           if($categoria!=''){
               $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && categoria ="'.$categoria.'" '
                       . ' && sexo ="' .$sexo.'" && pagado>0 ORDER BY rknacional';
           }else{
               $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && pagado>0 ORDER BY rknacional';
           }
        }else{
            return 0;
        }
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($prepare);
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
            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
        
        $conn=NULL;
        
        return $registros;
        
    }
    
     public static function ListaAceptacion($torneo_id,$categoria,$sexo) {
        
        $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && categoria ="'.$categoria.'" '
                       . ' && pagado>0 && sexo ="' .$sexo.'" ORDER BY condicion,rknacional';
           
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($prepare);
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
            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
        
        $conn=NULL;
        
        return $registros;
        
    }
    
    public static function ListaAceptacionFinal($torneo_id,$categoria,$sexo) {
        
        $prepare = 'SELECT * FROM ' . self::TABLA .' WHERE torneo_id = '.$torneo_id.' && categoria ="'.$categoria.'" '
                       . ' && condicion<5 and pagado>0 && sexo ="' .$sexo.'" ORDER BY condicion,rknacional';
           
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($prepare);
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
            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
       
        $conn=NULL;
        
        return $registros;
        
    }
    
    
     public static function Read_Puntos($torneo_id,$atleta_id=0,$categoria='',$sexo='') {
         
         $prepare = "SELECT atleta.atleta_id,atleta.estado,atleta.nombres, atleta.apellidos, "
                . "atleta.cedula,atleta.sexo,"
                . "DATE_FORMAT(atleta.fecha_nacimiento, '%d-%m-%y') as fecha_nacimiento,"
                . "torneoinscritos.*  ";

        if ($torneo_id > 0) {
            if ($atleta_id > 0) {
                $prepare = $prepare . ' FROM ' . self::TABLA . ' '
                        . ' INNER JOIN atleta ON torneoinscritos.atleta_id=atleta.atleta_id '
                        . ' WHERE torneoinscritos.torneo_id = ' . $torneo_id . ' '
                        . ' && atleta_id = ' . $atleta_id . ' '
                        . ' && torneoinscritos.pagado>0  '
                        . ' ORDER BY singles desc ';
            }
            if ($categoria != '') {
                if ($sexo != '') {
                    $prepare = $prepare . ' FROM ' . self::TABLA . ' '
                            . ' INNER JOIN atleta ON torneoinscritos.atleta_id=atleta.atleta_id '
                            . ' WHERE torneoinscritos.torneo_id = ' . $torneo_id . ' '
                            . ' && torneoinscritos.categoria ="' . $categoria . '"  '
                            . ' && atleta.sexo ="' . $sexo . '" '
                            . ' && torneoinscritos.pagado>0  '
                            . ' ORDER BY singles desc ';
                } else {
                    $prepare = $prepare . ' FROM ' . self::TABLA . ' '
                            . ' INNER JOIN atleta ON torneoinscritos.atleta_id=atleta.atleta_id '
                            . ' WHERE torneoinscritos.torneo_id = ' . $torneo_id . ' '
                            . '&& torneoinscritos.categoria ="' . $categoria . '"'
                            . ' && torneoinscritos.pagado>0  '
                            . ' ORDER BY singles desc ';
                }
            } else {
                $prepare = $prepare . ' FROM ' . self::TABLA . '  '
                        . ' INNER JOIN atleta ON torneoinscritos.atleta_id=atleta.atleta_id '
                        . ' WHERE torneoinscritos.torneo_id = ' . $torneo_id . ' '
                        . ' && torneoinscritos.pagado>0  '
                        . ' ORDER BY singles desc ';
            }
        } elseif ($atleta_id > 0) {
            $prepare = $prepare . ' FROM ' . self::TABLA . '  '
                    . ' INNER JOIN atleta ON torneoinscritos.atleta_id=atleta.atleta_id '
                    . ' WHERE torneoinscritos.atleta_id = ' . $atleta_id . ' '
                    . ' && torneoinscritos.pagado>0 '
                    . ' ORDER BY singles desc';
        }

        $model = new Conexion;
        $conn = $model->conectar();
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        } else {
            $mensaje = 'Records Found successfully';
            $SQLresultado_exitoso = TRUE;
        }

        $conn = NULL;

        return $registros;
    }
    
   public static function Count_Categoria($torneo_id,$categoria,$sexo) {
         
       $prepare ="SELECT COUNT(DISTINCT a.atleta_id) as jugadores"
                . " FROM atleta as a "
                . " INNER JOIN torneoinscritos as t ON a.atleta_id = t.atleta_id "
                . " WHERE a.sexo='" .$sexo ."' "
                . " && t.categoria ='".$categoria."'"
                . " && t.torneo_id=".$torneo_id." "
                . " && t.pagado>0";
       
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
       
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        } else {
            $mensaje = 'Records Found successfully';
            $SQLresultado_exitoso = TRUE;
        }

        $conn=NULL;
        foreach ($registros as $row){
            $jugadores=$row['jugadores'];
        }
        return $jugadores;
        
    }
    //Cuenta los jugadores inscritos e n un torneo sin importar su condicion
    public static function Count_Inscritos($torneo_id) {
         
       $prepare ="SELECT COUNT(*) as jugadores"
                . " FROM ".self::TABLA
                . "  "
                . " WHERE "
                . " torneo_id=".$torneo_id." ";
                
       
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
       
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        } else {
            $mensaje = 'Records Found successfully';
            $SQLresultado_exitoso = TRUE;
        }

        $conn=NULL;
        foreach ($registros as $row){
            $jugadores=$row['jugadores'];
        }
        
        return $jugadores;
        
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
               