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
class Atleta   {
    //put your code here
    
    private $cedula;
    private $apellidos;
    private $nombres;
    private $sexo;
    private $fecha_nacimiento;
    private $email;
    private $biografia;
    private $contrasena;
    private $nacionalidad_id;
    private $estado_id;
    private $estado;
    private $niveluser;
    private $direccion;
    private $telefonos;
    
    private $cedula_representante;
    private $nombre_representante;
    private $sesion_id;
    private $bloqueado;
    private $clave_default;
    private $categoria;
    private $nacionalidad;
    private $lugarNacimiento;
    private $lugarTrabajo;
    private $celular;
    private $fecha_modificacion;
    private $fecha_alta;
    private $disciplina;
    private $talla;
    private $peso;
    private $hand;
    private $nickname;
    private $inicio;
    
    private $id;
    private $dirty;
    public $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'atleta';
    const CAMPOS='(cedula, apellidos,nombres,sexo,fecha_nacimiento,email,biografia,contrasena,nacionalidad_id,estado_id,estado,niveluser,sesion_id,bloqueado,clave_default,direccion,telefono,nacionalidad)';
    const VALORES='(:cedula, :apellidos, :nombres, :sexo, :fecha_nacimiento, :email, :biografia, :contrasena, :nacionalidad_id, :estado_id, :estado, :niveluser, :sesion_id,:bloqueado, :clave_default,: direccion,:telefono,nacionalidad)';
    private $fields;
    public function __construct() {
        $this->cedula="";
        $this->nombres= NULL;
        $this->apellidos=NULL;
        $this->sexo="";
        $this->email=NULL;
        $this->fecha_nacimiento="";
        $this->nacionalidad_id=1;
        $this->estado_id=0;
        $this->estado="";
        $this->niveluser=0;
        $this->biografia="";
        $this->direccion=NULL;
        $this->telefonos=NULL;
        $this->cedula_representante=NULL;
        $this->nombre_representante=NULL;
        $this->lugarNacimiento=NULL;
        $this->lugarTrabajo=NULL;
        $this->fecha_alta=NULL;
        $this->fecha_modificacion=NULL;
        $this->celular=NULL;
        $this->disciplina="";
        $this->id=0;
        $this->clave_default=NULL;
        $this->sesion_id=NULL;
        $this->bloqueado=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
        $this->categoria=" ";
        $this->talla="1.80";
        $this->peso="50";
        $this->hand="Derecho";
        $this->nickname=" ";
        $this->inicio=" ";
     
    }
    
    public function getID(){
        return $this->id;
    }
    
    public function getCedula(){
        return $this->cedula;
    }
    public function setCedula($value){
         $this->cedula=$value;
    }
    public function getNombres(){
        return $this->nombres;
    }
    public function setNombres($value){
         $this->nombres=strtoupper($value);
    }
    
    public function getApellidos(){
        return $this->apellidos;
    }
    
    public function setApellidos($value){
        $this->apellidos=  strtoupper($value);
    }
    
    public function getNombreCompleto(){
        return $this->apellidos.", ".$this->nombres;
    }
     public function getNombreCorto(){
        $arrayNom=explode(" ",trim($this->nombres));
        $arrayApe=explode(" ",trim($this->apellidos));
        $Nombre1=$arrayNom[0];
        $Apellido1=$arrayApe[0];
        return ( substr(ucwords($Apellido1),0,1).", ". ucwords($Nombre1));
    }
    
    
    public function getSexo(){
        return $this->sexo;
    }
    
    public function setSexo($value){
        $this->sexo=$value;
    }
    public function getFechaNacimiento() {
       return $this->fecha_nacimiento;
    }
    
    public function anoFechaNacimiento() {
    $fn=$this->fecha_nacimiento;
       $ano_nac= explode("-", $fn);
       return $ano_nac[0];
    }
    
    public function FechaNacimientoDDMMYYYY() {
       $ano_nac= explode("-",$this->fecha_nacimiento);
       return $ano_nac[2]."-".$ano_nac[1]."-".$ano_nac[0];
    }
    
    public function mesFechaNacimiento() {
       $ano_nac= explode("-",$this->fecha_nacimiento);
       return $ano_nac[1];
    }
    public function diaFechaNacimiento() {
       $ano_nac= explode("-",$this->fecha_nacimiento);
       return $ano_nac[2];
    }
    
    //Metodo para calcular la edad
    Public function edad() {
        $d1=new DateTime(date('Y-m-d')); 
        $d2=new DateTime($this->fecha_nacimiento); 
        $diff=$d2->diff($d1); 
        return $diff->y;
        
    }    
   

    public function setFechaNacimiento($value) {
//       $value= date_format($value, "Y-m-d");
       $this->fecha_nacimiento=$value;
    }
    public function getEmail() {
       return $this->email;
    }
    
    public function setEmail($value) {
       $this->email=  strtolower($value);
    }
    public function getBiografia() {
       return $this->biografia;
    }
    
    public function setBiografia($value) {
       $this->biografia=$value;
    }
    
    public function getContrasena() {
       return $this->contrasena;
    }
    
    public function setContrasena($value) {
       return $this->contrasena=$value;
    }
    
    public function getNacionalidadID() {
       return $this->nacionalidad_id;
    }
    
    public function setNacionalidadID($value) {
       $this->nacionalidad_id=$value;
    }
    
    public function getEstadoID() {
       return $this->estado_id;
    }
    
    public function setEstadoID($value) {
       $this->estado_id=$value;
    }
    
    public function getEstado() {
       return $this->estado;
    }
    
    public function setEstado($value) {
       $this->estado=$value;
    }
    
    public function getNiveluser() {
       return $this->niveluser;
    }
    public function setNiveluser($value) {
       $this->niveluser=$value;
    }
    
    public function getSessionID() {
       return $this->sesion_id;
    }
    public function setSessionID($value) {
       $this->sesion_id=$value;
    
    } 
    public function getClaveDefault() {
       return $this->clave_default;
    }
    public function setClaveDefault($value) {
       $this->clave_default=$value;
    }
    
    
    
    
    public function getDireccion() {
       return $this->direccion;
    }
    public function  setDireccion($value) {
       $this->direccion=$value;
    }
    
    public function getTelefonos() {
       return $this->telefonos;
    }
    public function setTelefonos($value) {
       $this->telefonos=$value;
    }
    
    public function getCedulaRepresentante() {
       return $this->cedula_representante;
    }
    public function setCedulaRepresentante($value) {
       $this->cedula_representante=$value;
    }
    
     public function getNombreRepresentante() {
       return $this->nombre_representante;
    }
    public function setNombreRepresentante($value) {
       $this->nombre_representante=strtoupper($value);
    }
    
    public function getCategoria() {
       return $this->categoria;
    }
    public function setCategoria($value) {
       $this->categoria=$value;
    }
    
    public function getLugarNacimiento() {
       return $this->lugarNacimiento;
    }
    public function  setLugarNacimiento($value) {
       $this->lugarNacimiento=$value;
    }
    public function getLugarTrabajo() {
       return $this->lugarTrabajo;
    }
    public function  setLugarTrabajo($value) {
       $this->lugarTrabajo=$value;
    }
    
    public function getCelular() {
       return $this->celular;
    }
    public function  setCelular($value) {
       $this->celular=$value;
    }
    
    public function getFechaModificacion() {
       return $this->fecha_modificacion;
    }
    public function  setFechaModificacion($value) {
       $this->fecha_modificacion=$value;
    }
    
    public function getFechaAlta() {
       return $this->fecha_alta;
    }
    public function  setFechaAlta($value) {
       $this->fecha_alta=$value;
    }
    
    public function getDisciplina() {
       return $this->disciplina;
    }
    public function  setDisciplina($value) {
       $this->disciplina=$value;
    }
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }

    public function getTalla() {
        return $this->talla;
     }
     
     public function setTalla($value) {
        $this->talla=  $value;
     }
    
     public function getPeso() {
        return $this->peso;
     }
     
     public function setPeso($value) {
        $this->peso=  $value;
     }
     public function getHand() {
        return $this->hand;
     }
     
     public function setHand($value) {
        $this->hand=  $value;
     }

     public function getNickName() {
        return $this->nickname;
     }
     
     public function setNickName($value) {
        $this->nickname=  $value;
     }

     public function getInicio() {
        return $this->inicio;
     }
     
     public function setInicio($value) {
        $this->inicio=  $value;
     }

    public function Categoria_Natural($ano_desde) {
        $fecha_=  date_create($this->fecha_nacimiento);
        $anodeNacimiento=  date_format($fecha_,"Y");
        
       
        $edad=$ano_desde - $anodeNacimiento;
        $cat_natural="NA";
         if  ($edad >18){
             $cat_natural="AD";
         }elseif  ($edad >= 17){
             $cat_natural="18";
         }elseif ($edad >= 15 ){
             $cat_natural="16";
         }elseif ($edad >= 13){
             $cat_natural="14";
         }elseif  ($edad >=11){
             $cat_natural="12";
         }elseif ($edad >= 9){
             $cat_natural="PV";
         }else{
             $cat_natural="PN";
         }
//      
         return  $cat_natural;
        
    }
    
   public function Categoria_Torneo(){
   $ano= date ("Y");  
   $fnac=date_create($this->fecha_nacimiento);
   $anodeNacimiento=  date_format($fnac,"Y");
   $edad=$ano - $anodeNacimiento;
    if  ($edad >18){
        $cat_natural="AD,AM,IN,AV";
    }elseif  ($edad >16 && $edad <19){
        $cat_natural="18";
    }elseif ($edad > 14 && $edad <17){
        $cat_natural="16,18";
    }elseif ($edad > 12 && $edad <15){
        $cat_natural="14,16,18";
    }elseif  ($edad >10 && $edad <13){
        $cat_natural="12B,12,14,16";
    }elseif ($edad >8  && $edad <11){
        $cat_natural="PV,12B";
    }elseif  ($edad > 6 && $edad <9){
        $cat_natural="PN";
    }else{
        $cat_natural="PR";
    }

   return $cat_natural; 
}
    
  public function Categoria_Afiliacion($anoAfiliacion){
  
   $edad= $anoAfiliacion - $this->anoFechaNacimiento() ;
   $cat_natural="NA";
    if  ($edad >18){
        $cat_natural="AD";
    }elseif  ($edad >= 17){
        $cat_natural="18";
    }elseif ($edad >= 15 ){
        $cat_natural="16";
    }elseif ($edad >= 13){
        $cat_natural="14";
    }elseif  ($edad >=11){
        $cat_natural="12";
    }elseif ($edad >=9){
        $cat_natural="PV";
    }elseif ($edad >=7){
        $cat_natural="PN";
    }else{
        $cat_natural="PR";
    }
    return $cat_natural; 
}
        
             

    public function create(){
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $campos='(cedula, apellidos, nombres, sexo,email,biografia,contrasena, '
                    . 'nacionalidad_id, estado_id,estado,niveluser,sesion_id,bloqueado,clave_default,'
                    . 'direccion,telefonos,cedularep,nombrerep,fecha_nacimiento,categoria,'
                    . 'lugarnacimiento,lugartrabajo,celular,'
                    . 'fecha_alta,fecha_modificacion,disciplina)';
            
            $valores='(:xcedula,:xapellidos,:xnombres,:xsexo,:xemail,:xbiografia,:xcontrasena,'
                    . ':xnacionalidad_id,:xestado_id,:xestado,:xniveluser,:xsesion_id,:xbloqueado,:xclave_default,'
                    . ':xdireccion,:xtelefonos,:xcedularep,:xnombrerep,:xfecha_nacimiento,:xcategoria,'
                    . ':xlugarnacimiento,:xlugartrabajo,:xcelular,'
                    . ':xfecha_alta,:xfecha_modificacion,:xdisciplina)';
            $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
            
            $SQL->bindParam(':xcedula', $this->cedula);
            $SQL->bindParam(':xapellidos', $this->apellidos);
            $SQL->bindParam(':xnombres', $this->nombres);
            $SQL->bindParam(':xsexo', $this->sexo);
            $SQL->bindParam(':xemail', $this->email);
            $SQL->bindParam(':xbiografia', $this->biografia);
            $SQL->bindParam(':xcontrasena', $this->contrasena);
            $SQL->bindParam(':xnacionalidad_id', $this->nacionalidad_id);
            $SQL->bindParam(':xestado_id', $this->estado_id);
            $SQL->bindParam(':xestado', $this->estado);
            $SQL->bindParam(':xniveluser', $this->niveluser);
            $SQL->bindParam(':xsesion_id', $this->sesion_id);
            $SQL->bindParam(':xbloqueado', $this->bloqueado);
            $SQL->bindParam(':xclave_default', $this->clave_default);
            $SQL->bindParam(':xdireccion', $this->direccion);
            $SQL->bindParam(':xtelefonos', $this->telefonos);
            $SQL->bindParam(':xcedularep', $this->cedula_representante);
            $SQL->bindParam(':xnombrerep', $this->nombre_representante);
            $SQL->bindParam(':xfecha_nacimiento', $this->fecha_nacimiento,  PDO::PARAM_STR);
            $SQL->bindParam(':xcategoria', $this->categoria);
            $SQL->bindParam(':xlugarnacimiento', $this->lugarNacimiento);
            $SQL->bindParam(':xlugartrabajo', $this->lugarTrabajo);
            $SQL->bindParam(':xcelular', $this->celular);
            $SQL->bindParam(':xfecha_alta', $this->fecha_alta,  PDO::PARAM_STR);
            $SQL->bindParam(':xfecha_modificacion', $this->fecha_modificacion,  PDO::PARAM_STR);
            $SQL->bindParam(':xdisciplina', $this->disciplina);
            
            
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
        
            $SQL=' SET cedula = :cedula,apellidos = :apellidos, nombres = :nombres, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento,email = :email,'
            . 'biografia =:biografia,contrasena =:contrasena,nacionalidad_id = :nacionalidad_id,estado_id =:estado_id,estado =:estado,'
            . 'niveluser =:niveluser,sesion_id =:sesion_id,bloqueado =:bloqueado,clave_default =:clave_default,'
            . 'direccion=:direccion,telefonos=:telefonos,cedularep=:cedularep,nombrerep=:nombrerep,categoria=:categoria,'
            . 'lugarnacimiento=:lugarnacimiento,lugartrabajo=:lugartrabajo,celular=:celular,'
            . 'fecha_alta=:fecha_alta,fecha_modificacion=:fecha_modificacion,disciplina=:disciplina,'
            . 'talla=:talla,peso=:peso,hand=:hand,nickname=:nickname,inicio=:inicio';
                          
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE atleta_id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':cedula', $this->cedula);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':nombres', $this->nombres);
            $stmt->bindParam(':sexo', $this->sexo);
            $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':biografia', $this->biografia);
            $stmt->bindParam(':contrasena', $this->contrasena);
            $stmt->bindParam(':nacionalidad_id', $this->nacionalidad_id);
            $stmt->bindParam(':estado_id', $this->estado_id);
            $stmt->bindParam(':estado', $this->estado);
            $stmt->bindParam(':niveluser', $this->niveluser);
            $stmt->bindParam(':sesion_id', $this->sesion_id);
            $stmt->bindParam(':bloqueado', $this->bloqueado);
            $stmt->bindParam(':clave_default', $this->clave_default);
            $stmt->bindParam(':direccion', $this->direccion);
            $stmt->bindParam(':telefonos', $this->telefonos);
            $stmt->bindParam(':cedularep', $this->cedula_representante);
            $stmt->bindParam(':nombrerep', $this->nombre_representante);
            $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento,  PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':lugarnacimiento', $this->lugarNacimiento);
            $stmt->bindParam(':lugartrabajo', $this->lugarTrabajo);
            $stmt->bindParam(':celular', $this->celular);
            $stmt->bindParam(':fecha_alta', $this->fecha_alta,  PDO::PARAM_STR);
            $stmt->bindParam(':fecha_modificacion', $this->fecha_modificacion,  PDO::PARAM_STR);
            $stmt->bindParam(':disciplina', $this->disciplina);
            $stmt->bindParam(':talla', $this->talla,PDO::PARAM_STR);
            $stmt->bindParam(':peso', $this->peso,PDO::PARAM_STR);
            $stmt->bindParam(':hand', $this->hand,PDO::PARAM_STR);
            $stmt->bindParam(':nickname', $this->nickname,PDO::PARAM_STR);
            $stmt->bindParam(':inicio', $this->inicio,  PDO::PARAM_STR);
            
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
        
            $SQL = $conn->prepare('DELETE FROM ' . self::TABLA . ' WHERE atleta_id= :id');
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
    
    public function Fetch($atleta_id=0,$cedula=0) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($atleta_id>0){
                $SQL = $conn->prepare(" SELECT * FROM " . self::TABLA . ' WHERE atleta_id = :id');
                $SQL->bindParam(':id', $atleta_id);
            }elseif ($cedula!=""){

                $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE cedula = :cedula');
                $SQL->bindParam(':cedula', $cedula);
            }
          
          
            $SQL->execute();
            $record = $SQL->fetch();
           
            if($record){
               
                 $this->cedula=$record['cedula'];
                 $this->nombres=$record['nombres'];
                 $this->apellidos= $record['apellidos'];
                 $this->sexo= $record['sexo'];
                 $this->fecha_nacimiento=$record['fecha_nacimiento'];
                 $this->email=$record['email'];
                 $this->biografia=$record['biografia'];
                 $this->contrasena=$record['contrasena'];
                 $this->nacionalidad_id=$record['nacionalidad_id'];
                 $this->estado_id=$record['estado_id'];
                 $this->estado=$record['estado'];
                 $this->niveluser=$record['niveluser'];
                 $this->sesion_id=$record['sesion_id'];
                 $this->bloqueado=$record['bloqueado'];
                 $this->clave_default=$record['clave_default'];
                 $this->direccion=$record['direccion'];
                 $this->telefonos=$record['telefonos'];
                 $this->cedula_representante=$record['cedularep'];
                 $this->nombre_representante=$record['nombrerep'];
                 $this->categoria=$record['categoria'];
                 $this->lugarNacimiento=$record['lugarnacimiento'];
                 $this->lugarTrabajo=$record['lugartrabajo'];
                 $this->celular=$record['celular'];
                 $this->fecha_alta=$record['fecha_alta'];
                 $this->fecha_modificacion=$record['fecha_modificacion'];
                 $this->disciplina=$record['disciplina'];
                 $this->id=$record['atleta_id'];
                 $this->mensaje='Record Found successfully ';
                $this->SQLresultado_exitoso=TRUE;
                 
            
            }
        }catch(PDOException $e)
            {
                //echo "Error: " . $e->getMessage();
                $this->mensaje='Record Not Found..' . $e->getMessage();
                $this->SQLresultado_exitoso=FALSE;
            }
            
            $conn=NULL;
       
    }
    
    public function Find($atleta_id) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $SQL = $conn->prepare(" SELECT * FROM " . self::TABLA . ' WHERE atleta_id = :id');
            $SQL->bindParam(':id', $atleta_id);
            
            $SQL->execute();
            $record = $SQL->fetch();
           
            if($record){
               
                 $this->cedula=$record['cedula'];
                 $this->nombres=$record['nombres'];
                 $this->apellidos= $record['apellidos'];
                 $this->sexo= $record['sexo'];
                 $this->fecha_nacimiento=$record['fecha_nacimiento'];
                 $this->email=$record['email'];
                 $this->biografia=$record['biografia'];
                 $this->contrasena=$record['contrasena'];
                 $this->nacionalidad_id=$record['nacionalidad_id'];
                 $this->estado_id=$record['estado_id'];
                 $this->estado=$record['estado'];
                 $this->niveluser=$record['niveluser'];
                 $this->sesion_id=$record['sesion_id'];
                 $this->bloqueado=$record['bloqueado'];
                 $this->clave_default=$record['clave_default'];
                 $this->direccion=$record['direccion'];
                 $this->telefonos=$record['telefonos'];
                 $this->cedula_representante=$record['cedularep'];
                 $this->nombre_representante=$record['nombrerep'];
                 $this->categoria=$record['categoria'];
                 $this->lugarNacimiento=$record['lugarnacimiento'];
                 $this->lugarTrabajo=$record['lugartrabajo'];
                 $this->celular=$record['celular'];
                 $this->fecha_alta=$record['fecha_alta'];
                 $this->fecha_modificacion=$record['fecha_modificacion'];
                 $this->disciplina=$record['disciplina'];
                 $this->id=$record['atleta_id'];
                 $this->mensaje='Record Found successfully ';
                 $this->inicio=$record['inicio'];
                 $this->hand=$record['hand'];
                 $this->talla=$record['talla'];
                 $this->peso=$record['peso'];
                 $this->nickname=$record['nickname'];
                $this->SQLresultado_exitoso=TRUE;
                 
            
            }
        }
        catch(PDOException $e)
            {
                //echo "Error: " . $e->getMessage();
                $this->mensaje='Record Not Found..' . $e->getMessage();
                $this->SQLresultado_exitoso=FALSE;
            }
            
        $conn=NULL;
       
    }

    public function Find_Cedula($cedula) {
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $SQL = $conn->prepare(" SELECT * FROM " . self::TABLA . ' WHERE cedula = :cedula');
            $SQL->bindParam(':cedula', $cedula);
            
            $SQL->execute();
            $record = $SQL->fetch();
           
            if($record){
               
                 $this->cedula=$record['cedula'];
                 $this->nombres=$record['nombres'];
                 $this->apellidos= $record['apellidos'];
                 $this->sexo= $record['sexo'];
                 $this->fecha_nacimiento=$record['fecha_nacimiento'];
                 $this->email=$record['email'];
                 $this->biografia=$record['biografia'];
                 $this->contrasena=$record['contrasena'];
                 $this->nacionalidad_id=$record['nacionalidad_id'];
                 $this->estado_id=$record['estado_id'];
                 $this->estado=$record['estado'];
                 $this->niveluser=$record['niveluser'];
                 $this->sesion_id=$record['sesion_id'];
                 $this->bloqueado=$record['bloqueado'];
                 $this->clave_default=$record['clave_default'];
                 $this->direccion=$record['direccion'];
                 $this->telefonos=$record['telefonos'];
                 $this->cedula_representante=$record['cedularep'];
                 $this->nombre_representante=$record['nombrerep'];
                 $this->categoria=$record['categoria'];
                 $this->lugarNacimiento=$record['lugarnacimiento'];
                 $this->lugarTrabajo=$record['lugartrabajo'];
                 $this->celular=$record['celular'];
                 $this->fecha_alta=$record['fecha_alta'];
                 $this->fecha_modificacion=$record['fecha_modificacion'];
                 $this->disciplina=$record['disciplina'];
                 $this->id=$record['atleta_id'];
                 $this->mensaje='Record Found successfully ';
                $this->SQLresultado_exitoso=TRUE;
                 
            
            }
        }
        catch(PDOException $e)
            {
                //echo "Error: " . $e->getMessage();
                $this->mensaje='Record Not Found..' . $e->getMessage();
                $this->SQLresultado_exitoso=FALSE;
            }
            
        $conn=NULL;
       
    }
    
    public static function ReadById($id,$cedula){
        
       $model = new Conexion;
       $conn=$model->conectar();
       if ($id>0){
           $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE atleta_id = :id');
           $SQL->bindParam(':id', $id);
       }elseif ($cedula>0){
           $prepare = "SELECT * FROM " . self::TABLA . ' WHERE cedula = :cedula';
           $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE cedula = :cedula');
           $SQL->bindParam(':cedula', $cedula);
       }
      
       $SQL->execute();
       $record = $SQL->fetch();
       if($record){
           $SQLresultado_exitoso=TRUE;
          return new self($record['cedula'], $record['nombres'], $record['apellidos'],$record['sexo'],$record['fecha_nacimiento'],
                  $record['email'],$record['biografia'],$record['contrasena'],$record['nacionalidad_id'],$record['estado_id'],
                  $record['estado'],$record['niveluser'],$record['sesion_id'],$record['bloqueado'],$record['clave_default'],
                  $record['direccion'],$record['telefonos'],$record['cedularep'],$record['nombrerep'],$record['atleta_id'],
                  $record['categoria'],$record['lugarnacimiento'],$record['lugartrabajo'],$record['celular'],
                  $record['fecha_alta'],$record['fecha_modificacion'],$record['disciplina']);
       }else{
         $SQLresultado_exitoso=FALSE;
       }
       $conn=NULL;
       return $record;
    }
    
  
    public static function ReadAll($estado){
    try {
       $model = new Conexion;
       $conn=$model->conectar();
       
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE estado=:edo and niveluser=0 ORDER BY Apellidos');
       $SQL->bindParam(':edo', $estado);
       $SQL->execute();
       $registros = $SQL->fetchall();
       return $registros;
    }catch(PDOException $e)
        {
           echo "Error: " . $e->getMessage();
            
        }
            
        
        $conn=NULL;
        
          
    
    }
    
    public static function ReadbyNivelUser($niveluser){
    try {
       $model = new Conexion;
       $conn=$model->conectar();
       
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE niveluser=:niveluser ');
       $SQL->bindParam(':niveluser', $niveluser);
       $SQL->execute();
       $registros = $SQL->fetchall();
       return $registros;
    }catch(PDOException $e)
        {
           echo "Error: " . $e->getMessage();
            
        }
        
        
        $conn=NULL;
        
          
    }
    
    public static function LikeApellido($apellidos,$estado=' '){
        try {
        $model = new Conexion;
        $conn=$model->conectar();
        if ($estado!=' '){
                $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE apellidos like "'.$apellidos.'%"  && estado=:estado && niveluser=0 ');
                $SQL->bindParam(':estado', $estado);
        }else{
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE apellidos like "'.$apellidos.'%" && niveluser=0 ');
            }
        
        $SQL->execute();
        $registros = $SQL->fetchall();
        $conn=NULL;
        return $registros;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            
        }
        
          
    }
    
       
    public static function Disciplina($estado,$displicina="TDC"){
    try {
       $model = new Conexion;
       $conn=$model->conectar();
       
       $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA .' WHERE estado=:edo && disciplina=:disciplina && niveluser=0 ORDER BY Apellidos');
       $SQL->bindParam(':edo', $estado);
       $SQL->bindParam(':disciplina', $displicina);
       $SQL->execute();
       $registros = $SQL->fetchall();
       return $registros;
    }catch(PDOException $e)
        {
           echo "Error: " . $e->getMessage();
            
        }
        
        
        $conn=NULL;
        
          
    }
        
        
    public function load_fields_table()
    {
        
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $sql=" SELECT TABLE_NAME,COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,ORDINAL_POSITION FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA='". self::TABLA."' && TABLE_NAME='". self::TABLA. "' ORDER BY TABLE_NAME";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        while ($record = $consulta->fetch())
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
            $this->dirty=true;
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
               