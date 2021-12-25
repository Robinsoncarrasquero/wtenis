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
class Torneo {

    //put your code here
    private $id;
    private $empresa_id;
    private $codigo;
    private $nombre;
    private $estatus;
    private $categoria;
    private $fechainicio;
    private $fechacierre;
    private $fecharetiros;
    private $fecha_inicio_torneo;
    private $fecha_fin_torneo;
    private $asociacion;
    private $tipo_torneo;
    private $anodenacimiento;
    private $fecha_ranking;
    private $tipo;
    private $monto;
    private $iva;
    private $arbitro;
    private $condicion;
    private $modalidad;
    private $entidad;
    private $ano;
    private $numero;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;

    const TABLA = 'torneo';
    const CAMPOS = '(empresa_id,codigo,nombre,estatus,categoria,fechainicio,fechacierre,fecharetiros,fecha_inicio_torneo,fecha_fin_torneo,asociacion,tipo_torneo,anodenacimiento,fecha_ranking,tipo,monto,iva,arbitro,condicion,modalidad)';
    const VALORES = '(:empresa_id,:codigo,:nombre,:estatus,:categoria,:fechainicio,:fechacierre,:fecharetiros,:fecha_inicio_torneo,:fecha_fin_torneo,:asociacion,:tipo_torneo,:anodenacimiento,:fecha_ranking,:tipo,:monto,:iva,:arbitro,:condicion,modalidad)';
    private $fields;
    private $fields_count;
    const DIAS_PARA_OPEN = '30';
    const DIAS_PARA_OPEN_G1 = '30';
    const DIAS_PARA_OPEN_G2 = '30';
    const DIAS_PARA_OPEN_G3= '30';
    const DIAS_PARA_OPEN_G4 = '30';
    const DIAS_PARA_OPEN_G5 = '30';

    public function __construct() {
        $this->codigo = NULL;
        $this->nombre = NULL;
        $this->estatus = NULL;
        $this->categoria = NULL;
        $this->fechainicio = NULL;
        $this->fechacierre = NULL;
        $this->fecharetiros = NULL;
        $this->fecha_inicio_torneo = NULL;
        $this->fecha_fin_torneo = NULL;
        $this->asociacion = NULL;
        $this->tipo_torneo = NULL;
        $this->anodenacimiento = NULL;
        $this->fecha_ranking = NULL;
        $this->tipo = NULL;
        $this->monto = 0;
        $this->iva = 0;
        $this->arbitro = NULL;
        $this->condicion=NULL;
        $this->modalidad=NULL;
        $this->empresa_id = NULL;
        $this->entidad = NULL;
        $this->ano=0;
        $this->numero=0;
        $this->dirty = FALSE;
        $this->SQLresultado_exitoso = FALSE;
    }

    public function GetTorneo_id() {
        return $this->id;
    }

    public function getEmpresa_id() {
        return $this->empresa_id;
    }

    public function setEmpresa_id($value) {
        $this->empresa_id = $value;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($value) {
        $this->codigo = $value;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($value) {
        $this->nombre = $value;
    }

    public function getEstatus() {
        return $this->estatuso;
    }

    public function setEstatus($value) {
        $this->estatus = $value;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($value) {
        $this->categoria = $value;
    }

    public function getFechaInicio() {
        return $this->fechainicio; //inicio de inscripciones
    }

    public function setFechaInicio($value) {
        $this->fechainicio = $value;
    }

    public function getFechaCierre() {
        return $this->fechacierre; //inicio de Cierre
    }

    public function setFechaCierre($value) {
        $this->fechacierre = $value;
    }

    public function getFechaRetiros() {
        return $this->fecharetiros; //inicio de Cierre
    }

    public function setFechaRetiros($value) {
        $this->fecharetiros = $value;
    }

    public function getFechaInicioTorneo() {
        return $this->fecha_inicio_torneo;
    }

    public function setFechaInicioTorneo($value) {
        $this->fecha_inicio_torneo = $value;
    }

    public function getFechaFinTorneo() {
        return $this->fecha_fin_torneo;
    }

    public function setFechaFinTorneo($value) {
        $this->fecha_fin_torneo = $value;
    }

    public function getAsociacion() {
        return $this->asociacion;
    }

    public function setAsociacion($value) {
        $this->asociacion = $value;
    }

    public function getTipoTorneo() {
        return $this->tipo_torneo;
    }

    public function setTipoTorneo($value) {
        $this->tipo_torneo = $value;
    }

    public function getAnoDeNacimiento() {
        return $this->anodenacimiento;
    }

    public function setAnoDeNacimiento($value) {
        $this->anodenacimiento = $value;
    }

    public function getFechaRanking() {
        return $this->fecha_ranking;
    }

    public function setFechaRanking($value) {
        $this->fecha_ranking = $value;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($value) {
        $this->tipo = $value;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setMonto($value) {
        $this->monto = $value;
    }

    public function getIva() {
        return $this->iva;
    }

    public function setIva($value) {
        $this->iva = $value;
    }
    
     public function getArbitro() {
        return $this->arbitro;
    }

    public function setArbitro($value) {
        $this->arbitro = $value;
    }
    
    public function getCondicion() {
        return $this->condicion;
    }

    public function setCondicion($value) {
        $this->condicion = $value;
    }
    
    public function getModalidad() {
        return $this->modalidad;
    }

    public function setModalidad($value) {
        $this->modalidad = $value;
    }
    
    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($value) {
        $this->entidad = $value;
    }
    
    public function getAno() {
        return $this->ano;
    }

    public function setAno($value) {
        $this->ano = $value;
    }
    
    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($value) {
        $this->numero = $value;
    }

    public function Operacion_Exitosa() {
        return $this->SQLresultado_exitoso;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function create() {
        
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $campos = '(empresa_id,codigo,nombre,estatus,categoria,fechainicio,fechacierre,fecharetiros,fecha_inicio_torneo,fecha_fin_torneo,'
                    . 'asociacion,tipo_torneo,anodenacimiento,fecha_ranking,tipo,monto,iva,arbitro,condicion,modalidad,entidad,ano,numero)';
            $valores = '(:empresa_id,:codigo,:nombre,:estatus,:categoria,:fechainicio,:fechacierre,:fecharetiros,:fecha_inicio_torneo,:fecha_fin_torneo'
                    . ',:asociacion,:tipo_torneo,:anodenacimiento,:fecha_ranking,:tipo,:monto,:iva,:arbitro,:condicion,:modalidad,:entidad'
                    . ',:ano,:numero)';

            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
       
       
            $SQL->bindParam(':empresa_id', $this->empresa_id);
            $SQL->bindParam(':codigo', $this->codigo);
            $SQL->bindParam(':nombre', $this->nombre);
            $SQL->bindParam(':estatus', $this->estatus);
            $SQL->bindParam(':categoria', $this->categoria);
            $SQL->bindParam(':fechainicio', $this->fechainicio,PDO::PARAM_STR);
            $SQL->bindParam(':fechacierre', $this->fechacierre,PDO::PARAM_STR);
            $SQL->bindParam(':fecharetiros', $this->fecharetiros,PDO::PARAM_STR);
            $SQL->bindParam(':fecha_inicio_torneo', $this->fecha_inicio_torneo,PDO::PARAM_STR);
            $SQL->bindParam(':fecha_fin_torneo', $this->fecha_fin_torneo,PDO::PARAM_STR);
            $SQL->bindParam(':asociacion', $this->asociacion);
            $SQL->bindParam(':tipo_torneo', $this->tipo_torneo);
            $SQL->bindParam(':anodenacimiento', $this->anodenacimiento);
            $SQL->bindParam(':fecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $SQL->bindParam(':tipo', $this->tipo);
            $SQL->bindParam(':monto', $this->monto);
            $SQL->bindParam(':iva', $this->iva);
            $SQL->bindParam(':arbitro', $this->arbitro);
            $SQL->bindParam(':condicion', $this->condicion);
            $SQL->bindParam(':modalidad', $this->modalidad);
            $SQL->bindParam(':entidad', $this->entidad);
            $SQL->bindParam(':ano', $this->ano);
            $SQL->bindParam(':numero', $this->numero);
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

    public function Update() {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQLstr = ' SET codigo= :xcodigo,nombre=:xnombre,estatus = :xestatus, categoria = :xcategoria, '
                . 'fechainicio = :xfechainicio,fechacierre =:xfechacierre,fecharetiros =:xfecharetiros,fecha_inicio_torneo = :xfecha_inicio_torneo,'
                . 'fecha_fin_torneo =:xfecha_fin_torneo,asociacion = :xasociacion, tipo_torneo =:xtipo_torneo,anodenacimiento = :xanodenacimiento, '
                . 'fecha_ranking = :xfecha_ranking, tipo = : xtipo, monto = :xmonto, iva = :xiva, arbitro = :xarbitro, empresa_id = :xempresa_id,'
                    . 'condicion = :xcondicion, modalidad = :xmodalidad, entidad = :xentidad,'
                    . 'ano = :xano, numero = :xnumero';
            
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQLstr . ' WHERE torneo_id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':xcodigo', $this->codigo);
            $stmt->bindParam(':xnombre', $this->nombre);
            $stmt->bindParam(':xestatus', $this->estatus);
            $stmt->bindParam(':xcategoria', $this->categoria);
            $stmt->bindParam(':xfechainicio', $this->fechainicio,PDO::PARAM_STR);
            $stmt->bindParam(':xfechacierre', $this->fechacierre,PDO::PARAM_STR);
            $stmt->bindParam(':xfecharetiros', $this->fecharetiros,PDO::PARAM_STR);
            $stmt->bindParam(':xfecha_inicio_torneo', $this->fecha_inicio_torneo,PDO::PARAM_STR);
            $stmt->bindParam(':xfecha_fin_torneo', $this->fecha_fin_torneo,PDO::PARAM_STR);
            $stmt->bindParam(':xasociacion', $this->asociacion);
            $stmt->bindParam(':xtipo_torneo', $this->tipo_torneo);
            $stmt->bindParam(':xanodenacimiento', $this->anodenacimiento);
            $stmt->bindParam(':xfecha_ranking', $this->fecha_ranking,PDO::PARAM_STR);
            $stmt->bindParam(':xtipo', $this->tipo);
            $stmt->bindParam(':xmonto', $this->monto);
            $stmt->bindParam(':xiva', $this->iva);
            $stmt->bindParam(':xarbitro', $this->arbitro);
            $stmt->bindParam(':xempresa_id', $this->empresa_id);
            $stmt->bindParam(':xcondicion', $this->condicion);
            $stmt->bindParam(':xmodalidad', $this->modalidad);
            $stmt->bindParam(':xentidad', $this->entidad);
            $stmt->bindParam(':xano', $this->ano);
            $stmt->bindParam(':xnumero', $this->numero);
            
            

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

    public function Delete($id) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE torneo_id=:id');
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
             switch ($e->getCode()) {
                case 23000:
                    $this->mensaje = "Prohibido eliminar, tiene registros relacionados";
                    break;
                default:
                    $this->mensaje = "ERROR desconocido no se puedo eliminar registros..".$e->getMessage();
                    break;
            }
        }
        $conn = null;
       
    }

    public function Fetch($id) {

        $model = new Conexion;
        $conn = $model->conectar();
        $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . " WHERE torneo_id = :id");
        $SQL->bindParam(':id', $id);
        $SQL->execute();
        $record = $SQL->fetch();
        if ($record) {
            $this->SQLresultado_exitoso = TRUE;
            $this->id = $record['torneo_id'];
            $this->nombre = $record['nombre'];
            $this->codigo = $record['codigo'];
            $this->estatus = $record['estatus'];
            $this->categoria = $record['categoria'];
            $this->fechainicio = $record['fechainicio'];
            $this->fechacierre = $record['fechacierre'];
            $this->fecharetiros = $record['fecharetiros'];
            $this->fecha_inicio_torneo = $record['fecha_inicio_torneo'];
            $this->fecha_fin_torneo = $record['fecha_fin_torneo'];
            $this->asociacion = $record['asociacion'];
            $this->tipo_torneo = $record['tipo_torneo'];
            $this->anodenacimiento = $record['anodenacimiento'];
            $this->fecha_ranking = $record['fecha_ranking'];
            $this->tipo = $record['tipo'];
            $this->monto = $record['monto'];
            $this->iva = $record['iva'];
            $this->arbitro = $record['arbitro'];
            $this->empresa_id = $record['empresa_id'];
            $this->condicion = $record['condicion'];
            $this->modalidad = $record['modalidad'];
            $this->entidad = $record['entidad'];
            $this->ano = $record['ano'];
            $this->numero = $record['numero'];

            $this->mensaje='Record found successfully';
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record not Found';
       }
       $conn=NULL;
    }

    public function ReadById($id) {
        $model = new Conexion;
        $conn = $model->conectar();
        $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE torneo_id = :id');
        $SQL->bindParam(':id', $id);
        $SQL->execute();
        $record = $SQL->fetch();
        if ($record) {
            $this->SQLresultado_exitoso = TRUE;
            return new self($record['nombre'], $record['codigo'], $record['estatus'], $record['categoria'], 
                    $record['fechainicio'], $record['fechacierre'], $record['fecharetiros'], 
                    $record['fecha_inicio_torneo'], $record['fecha_fin_torneo'],$record['asociacion'], 
                    $record['tipo_torneo'], $record['anodenacimiento'], $record['fecha_ranking'], 
                    $record['tipo'], $record['monto'], $record['iva'], $record['arbitro'], $record['empresa_id'],
                    $record['condicion'],$record['modalidad'],$record['entidad'],$record['ano'],$record['numero']);
        } else {
            $this->SQLresultado_exitoso = FALSE;
        }
        $conn = NULL;
    }
    
    
    public function RecordById($id) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE torneo_id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       
       
       if($record){
           $this->SQLresultado_exitoso=TRUE;
          
       } else {
             $this->SQLresultado_exitoso=FALSE;
      }
       $conn=NULL;
       return $record;
    }

    public function ReadAll($Empresa_id=0, $Vigentes = FALSE, $Mes = 0,$Estatus="A",$Entidad='') {
        $model = new Conexion;
        $conn = $model->conectar();
        
       
       if ($Empresa_id > 0) {
           //esta opcion esta disponible cuando la manipula una empresa directamente en torneos
            if ($Vigentes) {
                
                if ($Mes > 0) {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE empresa_id=' . $Empresa_id.' ';
                                        
                    if($Estatus=='A'){
                        $prepare .=' AND estatus="A" ';
                     }
                    $prepare .= 'AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                      . 'AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                      . 'ORDER BY fecha_inicio_torneo asc';
                } else {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE empresa_id=' . $Empresa_id . '  '
                            . 'AND estatus="A" '
                            . 'AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'ORDER BY fecha_inicio_torneo asc';
                }
                 
            } else {
                
                if ($Mes > 0) {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE entidad="'.$Entidad.'" ';
                    
                    $prepare .= 'AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                            . 'ORDER BY fecha_inicio_torneo asc';
                } else {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE empresa_id=' . $Empresa_id . ' '
                            . 'ORDER BY fecha_inicio_torneo asc';
                }
                
            }
        } else {
            //Es utilizada solo para visualizar todos los torneos sin especificar la empresa
            // y se utiliza en el calendario que presentado en pagina principal
            if ($Vigentes) {

                if ($Mes > 0) {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE estatus="A" '
                            . 'AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                            . 'ORDER BY fecha_inicio_torneo asc';
                } else {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE estatus="A" '
                            . 'AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'ORDER BY fecha_inicio_torneo asc';
                    
                }
               
            } else {
                if ($Mes > 0) {
                    $prepare = 'SELECT * FROM ' . self::TABLA . '  '
                            . 'WHERE  YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                            . 'ORDER BY fecha_inicio_torneo asc';
                     
                } else {
                    $prepare = 'SELECT * FROM ' . self::TABLA . ' '
                            . 'WHERE YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                            . 'ORDER BY fecha_inicio_torneo asc';
                }
               
            }
        }
        
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
        if ($SQL->rowCount() == 0) {
            $this->SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            $this->mensaje = "ERROR No se encontraron registros.." . $errorInfo;
            switch ($errorCode) {
                case 00000:
                    $this->mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $this->mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        }else {

            $this->mensaje='Records Found successfully';
            $this->SQLresultado_exitoso=TRUE;
        }
        $conn = NULL;

        return $registros;
    }
    
    //Funcion que determina los dias segun el grado del torneo
    private static function DiasParaOpen($grado){
        
         switch ($grado) {
            case 'G1':
                $diasParaOpen =  self::DIAS_PARA_OPEN_G1 ;
                break;
            case 'G2':
                $diasParaOpen =  self::DIAS_PARA_OPEN_G2 ;
                break;
            case 'G3':
                $diasParaOpen =  self::DIAS_PARA_OPEN_G3 ;
                break;
            case 'G4':
                $diasParaOpen =  self::DIAS_PARA_OPEN_G4 ;
                break;
            case 'G5':
                $diasParaOpen =  self::DIAS_PARA_OPEN_G5 ;
                break;
            default:
                $diasParaOpen =  self::DIAS_PARA_OPEN ;
                break;
         }
         
         return $diasParaOpen;
        
    }
    //Metodo para contar los torneos abiertos segun el grado
    public static function Count_Open_Mes($Empresa_id,$Mes,$Grado_) {
        $model = new Conexion;
        $conn = $model->conectar();
        
        $diasParaOpen = self::DiasParaOpen($Grado_);
        
        if ($Empresa_id > 0) {
            $prepare = 'SELECT count(*) as open FROM ' . self::TABLA . ' WHERE empresa_id=' . $Empresa_id . ' '
                .' AND estatus="A" '
                .' AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                .' AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                .' AND DATE_SUB(fechacierre, INTERVAL '.$diasParaOpen.' DAY)< now() AND fechacierre > now() ';
            if($Grado_!=NULL){
              $prepare .=' AND tipo="'.$Grado_ .'"';
            }
        }else{
            $prepare = 'SELECT count(*) as open FROM ' . self::TABLA . ' WHERE empresa_id>0 '
                .' AND estatus="A" '
                .' AND YEAR(fecha_inicio_torneo)>= YEAR(now()) '
                .' AND MONTH(fecha_inicio_torneo)=' . $Mes . '  '
                .' AND DATE_SUB(fechacierre, INTERVAL '.$diasParaOpen.' DAY) < now() AND fechacierre>now() ';
            if($Grado_!=NULL){
              $prepare .=' AND tipo="'.$Grado_ .'"';
            }
        }
        
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
        }else {
             
            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
        

        $conn = NULL;
        foreach ($registros as $row){
            $torneos_open=$row['open'];
        }
       
        return $torneos_open;
    }
    
    //Metodo que devurlve la fecha de inicio de un torneo 
    public static function Fecha_Apertura_Calendario($fecha_cierre,$grado) {
        $date_new = date_create($fecha_cierre); // fecha cierre de la bd
        
        //Funcion que retorna los dias segun el grado del torneo
        $diasParaOpen = self::DiasParaOpen($grado) . " days"   ; 
        
        date_sub($date_new,date_interval_create_from_date_string($diasParaOpen));

        return date_timestamp_get($date_new);
        
    }
    
    //Funcion para restar 1 dia de una fecha dada
    //Es utilizada para activar el status running de un torneo
    //los dias antes que se especifiquen
    public static function Fecha_Ini_Torneo($fecha_,$grado_){

         $date_new = date_create($fecha_); // fecha cierre de la bd
         if ($grado_=="G4"){
             date_sub($date_new,date_interval_create_from_date_string("2 days"));
         }  else {
             date_sub($date_new,date_interval_create_from_date_string("1 days"));
         }

        return date_timestamp_get($date_new);

    }
    
    
    //Funcion utilizada para activar el status running 
    //de un torneo sumando los dias que durara el mismo a partir de la fecha
    //de incio del torneo
    public static function Fecha_Fin_Torneo($fecha_inicio_torneo){

         $date_new = date_create($fecha_inicio_torneo); // fecha cierre de la bd
         date_add($date_new,date_interval_create_from_date_string("6 days"));

         //return date_timestamp_get($date_new);
         return $date_new->getTimestamp();
    }

    
    public static function Fecha_Create($fecha){
        $date_new=date_create($fecha); // fecha del servidor 
        return date_timestamp_get($date_new);
    }
    
    public static function Fecha_Hoy(){
        $date_hoy=date_create(); // fecha del servidor 
        //echo date_format($date_hoy,"Y-m-d H:i:s");
        return date_timestamp_get($date_hoy);
    }

    public static function fecha_string($fecha_unix)
    {
        $fecha=date_create();
        date_timestamp_set($fecha, $fecha_unix);
        return date_format($fecha, 'Y-m-d H:i:s');
        
    }
    
    //Esta funcion nos devuelve la fecha actual del servidor en formato
    //de numero para comparacion de fecha
    public static function Fecha_Listado_Torneo($fecha_,$grado_){
    
        $date_new = date_create($fecha_); // fecha cierre de la bd
        //$format ="Y-m-d 21:00:00";
        //$date=  date_format($date_new, $format);
        //$date_new = date_create($date); // Fecha Actual
    
        if ($grado_=="G4"){
            date_add($date_new,date_interval_create_from_date_string("2 hour"));

        }else{
           date_add($date_new,date_interval_create_from_date_string("2 hour"));
        }
        
    
    return date_timestamp_get($date_new);
    }
    
    //Funcion que devuelve el estatus de un torneo
    public static function Estatus_Torneo($fechacierre,$fechainicio,$grado,$condicion) {
        if (Torneo::Fecha_Apertura_Calendario($fechacierre, $grado) <= Torneo::Fecha_Hoy() 
            && Torneo::Fecha_Create($fechacierre) > Torneo::Fecha_Hoy()) {

            $estatus = "Abierto";
        } else {
            if (Torneo::Fecha_Apertura_Calendario($fechacierre, $grado) > Torneo::Fecha_Hoy()) {

                $estatus = "Proximo";
            } else {

                //Aqui mantenemos la fecha entre dos intervalos para el running
                //Cuando comienza y terminael torneo
                if (Torneo::Fecha_Fin_Torneo($fechainicio) >= Torneo::Fecha_Hoy()
                    && Fecha_ini_Torneo($fechainicio, $grado) < Torneo::Fecha_Hoy()) {

                    $estatus = "Accion";
                } else {
                    if (Torneo::Fecha_Fin_Torneo($fechainicio) < Torneo::Fecha_Hoy()) {

                        $estatus = "Finalizado";
                    } else {
                        $estatus = "Cerrado";
                    }
                }
            }
        }


        switch ($condicion) {
            case "X":
                $estatus = 'Cancelado';
                break;
            case "S":
                $estatus = 'Suspendido';
                break;
            case "D":
                $estatus = 'Diferido';
                break;
            default:
               
                break;
        }

        return $estatus;
    }
    
    //Determina segun el estatus el tipo de iconos y colores para armar el table row
    public static function Estatus_Torneo_Color($estatus,$href){
         switch ($estatus) {
            case 'Abierto':
                $array[]= '<tr class="success"  >  ';
                $array[]= '<td><a target="" href="'.$href.'" class="glyphicon glyphicon-hourglass"></a></td>';
                $array[]= '<td>'.$estatus.'</td>';
                 
                break;

            case 'Cerrado':
                $array[]= '<tr class=" " >';
                $array[]= '<td><p class="glyphicon glyphicon-remove-sign "></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
                break;
            case 'Proximo':
               $array[]= '<tr class=" " >';
               $array[]= '<td><p class="glyphicon glyphicon-eye-open"></p></td>';
               $array[]= '<td>'.$estatus.'</td>';
                break;
             case 'Accion':
                $array[]= '<tr class="warning " >';
                //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                $array[]= '<td><p class="glyphicon glyphicon-flag"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
             case 'Suspendido':
                $array[]= '<tr class="danger " >';
                //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                $array[]= '<td><p class="glyphicon glyphicon-flag"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
             case 'Diferido':
                $array[]= '<tr class="info " >';
                //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                $array[]= '<td><p class="glyphicon glyphicon-flag"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
             case 'Cancelado':
                $array[]= '<tr class="danger " >';
                //echo '<td ><p class="glyphicon glyphicon-cog"></p></td>';
                $array[]= '<td><p class="glyphicon glyphicon-flag"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
                break;

            default:
                $array[]= '<tr class=" " >';
                //echo '<td ><p class=" glyphicon glyphicon-remove"></p></td>';
                $array[]= '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
                break;
        }
        return $array;
    }
    //Funcion que devuelve el estatu de la inscripcion de un jugador
    public static function Estatus_Inscripcion($estatus){
         switch ($estatus) {
            case 'Ok':
                $array[]= '<tr class="success "  >  ';
                $array[]= '<td><p class="glyphicon glyphicon-thumbs-up"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
                break;
             case 'Confirmado':
                $array[]= '<tr class="danger"  >  ';
                $array[]= '<td><p class="glyphicon glyphicon-usd"></p></td>';
                $array[]= '<td>'.$estatus.'</td>';
                 
                break;
            case 'Abierto':
                $array[]= '<tr class=" "  >  ';
                $array[]= '<td><a target=""  class="glyphicon glyphicon-hourglass"></a></td>';
                $array[]= '<td>'.$estatus.'</td>';
                break;

            case 'Inactivo':
                $array[]= '<tr class=" " >';
                $array[]= '<td><p class="glyphicon glyphicon-lock glyphicon-question-sign"></p></td>';
                
                $array[]= '<td>'.$estatus.'</td>';
                break;
            default:
                $estatus="Abierto";
                $array[]= '<tr class=" "  >  ';
                $array[]= '<td><a target=""  class="glyphicon glyphicon-hourglass"></a></td>';
                $array[]= '<td>'.$estatus.'</td>';
                 
                break;
        }
        return $array;
    }

   
    public function load_fields_table() {

        $model = new Conexion;
        $conexion = $model->conectar();

        $sql = " SELECT TABLE_NAME,COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,ORDINAL_POSITION FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA='" . self::TABLA . "' && TABLE_NAME='" . self::TABLA . "' ORDER BY TABLE_NAME";
        $SQL = $conexion->prepare($sql);
        $SQL->execute();
        while ($record = $SQL->fetch()) {
            $this->fields[] = $record;
        }

        $this->fields_count = count($this->fields); // numero de campos en el arreglo devuelto;

        $model = NULL;
    }

    public function valida_fields_table() {
        $objeto = $this->fields;
        echo '<pre>';
        var_dump($objeto->fields[0]);
        echo '</pre>';
        for ($i = 0; $i < $objeto->fields_count; $i++) {
            //$datos_bd= array($record->name=>$record[$records->name]);
            echo '<pre>';
            var_dump($objeto->fields[$i]);

            echo '</pre>';
        }
    }

    public function fields_change($field, $value) {

        if ($this->rows[0][$field] != $value) {
            $this->dirty = TRUE;
//            echo '<pre>';
//            var_dump("Campor Record:".$this->rowschange[0][$field]);
//            var_dump("Campo Post:".$field ."-".$value);
//            
//            echo '</pre>';
        }
    }

    public function isDirty() {

        return $this->dirty;
    }
    
    //Devuelve los torneos activos para retiros
    public static function Torneos_Retiro() {
        $model = new Conexion;
        $conn = $model->conectar();
        $prepare = 'SELECT * FROM ' . self::TABLA . ' WHERE estatus="A" '
                . 'AND YEAR(fechacierre)= YEAR(now()) '
                . 'AND MONTH(fechacierre)=MONTH(now()) '
                . 'AND fechacierre <now() '
                . 'AND fecharetiros>now() ';
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        }else {

            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
        $conn = NULL;

        return $registros;
    }

    //Torneos que esta Open
    public static function Torneos_Open() {
        $model = new Conexion;
        $conn = $model->conectar();
        $diasParaOpen = self::DiasParaOpen("");
       
        $prepare = ' ' 
        . ' SELECT * FROM ' . self::TABLA . ' '
        . ' WHERE YEAR(fechacierre)= YEAR(now()) '
        . ' && fechacierre>=now() '
        //.'  && DATE_SUB(fechacierre, INTERVAL '.$diasParaOpen.' DAY)< now() AND fechacierre > now() '
        . ' && estatus="A" '
        . ' && condicion="C" '
        . ' ORDER BY empresa_id,fechacierre asc';
    
        
        $SQL = $conn->prepare($prepare);
        $SQL->execute();
        $registros = $SQL->fetchall();
        
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        }else {

            $mensaje='Records Found successfully';
            $SQLresultado_exitoso=TRUE;
        }
        $conn = NULL;
    

        return $registros;
    }

    //Intervalo entre una fecha dada y la actual
    public static function diff_fecha($fecha_hasta){
        $date1=date_create();
        $date2=date_create($fecha_hasta);
        $diff=date_diff($date1,$date2);
        return $diff;
    }
    //Intervalo entre dos fecha dadas en timestamp unix    
    public static function horas_entre_fechas($fecha_desde,$fecha_hasta){
        $fecha_hoy= date_timestamp_get(date_create($fecha_desde));
        $fecha_des= date_timestamp_get(date_create($fecha_hasta));
        return ($fecha_des - $fecha_hoy);
    }
    //Retorna el formato del Intervalo de una fecha resultado diff 
    public static function intervalo_fecha($interval, $type){
        switch($type){
            case 'years':
                return $interval->format('%Y');
                break;
            case 'months':
                $years = $interval->format('%Y');
                $months = 0;
                if($years){
                    $months += $years*12;
                }
                $months += $interval->format('%m');
                return $months;
                break;
            case 'days':
                return $interval->format('%a');
                break;
            case 'hours':
                $days = $interval->format('%a');
                $hours = 0;
                if($days){
                    $hours += 24 * $days;
                }
                $hours += $interval->format('%H');
                return $hours;
                break;
            case 'minutes':
                $days = $interval->format('%a');
                $minutes = 0;
                if($days){
                    $minutes += 24 * 60 * $days;
                }
                $hours = $interval->format('%H');
                if($hours){
                    $minutes += 60 * $hours;
                }
                $minutes += $interval->format('%i');
                return $minutes;
                break;
            case 'seconds':
                $days = $interval->format('%a');
                $seconds = 0;
                if($days){
                    $seconds += 24 * 60 * 60 * $days;
                }
                $hours = $interval->format('%H');
                if($hours){
                    $seconds += 60 * 60 * $hours;
                }
                $minutes = $interval->format('%i');
                if($minutes){
                    $seconds += 60 * $minutes;
                }
                $seconds += $interval->format('%s');
                return $seconds;
                break;
            case 'milliseconds':
                $days = $interval->format('%a');
                $seconds = 0;
                if($days){
                    $seconds += 24 * 60 * 60 * $days;
                }
                $hours = $interval->format('%H');
                if($hours){
                    $seconds += 60 * 60 * $hours;
                }
                $minutes = $interval->format('%i');
                if($minutes){
                    $seconds += 60 * $minutes;
                }
                $seconds += $interval->format('%s');
                $milliseconds = $seconds * 1000;
                return $milliseconds;
                break;
            default:
                return NULL;
        }
    }


    
}
