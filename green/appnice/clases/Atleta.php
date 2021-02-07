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
class Crud {
    //put your code here
    public $cedula;
    public $apellidos;
    public $nombres;
    public $sexo;
    public $fecha_nacimiento;
    public $email;
    public $biografia;
    public $contrasena;
    public $categoria;
    public $federado;
    public $fecha_alta;
    public $fecha_modificacion;
    public $nacionalidad_id;
    public $estado_id;
    public $estado;
    public $niveluser;
    public $sesion_id;
    public $bloqueado;
    public $clave_default;
    private $dirty;
    public function __construct() {
       
       $this->dirty=false;
       $this->operacionExitosa=false;
    }

    public function Create()
    {
        $model = new Conexion();
        $conexion = $model->conectar();
        $insertInto = $this->insertInto;
        $insertColumns = $this->insertColumns;
        $insertValues = $this->insertValues;
        $sql = "INSERT INTO ".$insertInto ."(".$insertColumns.") VALUES (".$insertValues.") ";
        $consulta=$conexion->prepare($sql);
        $consulta->execute();
        $this->operacionExitosa=false;
        if ($consulta->rowCount()==0)
        {
            $this->operacionExitosa=false;
            $errorcode=$consulta->errorCode();
            $errorinfo=$consulta->errorInfo();
            switch ($errorcode)
            {
                case 23000:
                    $this->mensaje= "ERROR el registro ya existe(Duplicado) $errorcode";
                    break;
                case 42000:
                    $this->mensaje= "ERROR uso de palabra reservada en alguna propiedad $errorcode";
                    break;
                default :
                    $this->mensaje= "ERROR no fue posible registrar: $errorcode";
                    break;
            }
           
        } 
        else 
        {
            $this->mensaje="Registro Guardado Exitosamente";
            $this->operacionExitosa=true;
          
        }
    
    }
    public function Read()
    {
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $select = $this->select;
        $from = $this->from;
        $condition = $this->condition;
        if($condition!='')
        {
           $condition = "WHERE " . $condition;
        }
        $sql = "SELECT $select FROM $from $condition ";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        
        while ($record = $consulta->fetch())
        {
           $this->rows[]=$record;
           $this->rowschange[]=$record;
           
        }
        
    }
    
    public function Update()
    {
       
        $model = new Conexion();
        $conexion = $model->conectar();
        $update= $this->update;
        $set=$this->set;
        $condition = $this->condition;
        if ($condition!='')
        {
            $condition="WHERE " . $condition;
        }
        $sql = "UPDATE $update SET $set $condition";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        $this->operacionExitosa=false;      
        if ($consulta->rowCount()==0)
        {
            $this->operacionExitosa=false;
            $errorcode= $consulta->errorCode();
            $errorinfo= $consulta->errorInfo();
            switch ($errorcode) {
                case 23000:
                    $this->mensaje="ERROR,no se pudo actualizar la tabla" . $errorcode;
                    break;
                case 42000:
                  $this->mensaje="ERROR,type de un campo sin formato correcto" . $errorcode;
                  break;
                default:
                    $this->mensaje="ERROR, no se pudo actualizar los Datos" . $errorcode;
                    break;
            }
        }
        else
        {
            $this->mensaje="Registro Guardado con exito";
            $this->operacionExitosa=true;
            
        }
        
        
    }
    public function Delete()
    {
        $model = new Conexion;
        $conexion = $model->conectar();
        $deleteFrom = $this->deleteFrom;
        $condicion = $this->condition;
        if($condicion!='')
        {
            $condicion= " WHERE " . $condicion;
        }
        $sql = "DELETE FROM $deleteFrom " . $condicion;
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        $this->operacionExitosa=false;
        if ($consulta->rowCount()==0)
        {
            $this->operacionExitosa=false;
            $errorCode= $conexion->errorCode();
            $errorInfo=$conexion->errorInfo();
            
            switch ($errorCode) 
            {
                case 00000:
                    $this->mensaje="ERROR No se puede Eliminar hay datos relacionados .." .$errorCode;
                    break;
                default:
                    $this->mensaje="ERROR No se puede Eliminar el Registro.. " .$errorCode;
                    break;
            }
                  
        }
        else
        {
            $this->mensaje='Registro eliminado con exito..';
            $this->operacionExitosa=true;
        }
        
              
        
    }
    public function table_fields()
    {
        
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $sql=" SELECT TABLE_NAME,COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,ORDINAL_POSITION FROM information_schema.COLUMNS "
                . "WHERE TABLE_SCHEMA='atletasdb' && TABLE_NAME='$this->Tabla_Name' ORDER BY TABLE_NAME";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        while ($record = $consulta->fetch())
        {
           $this->fields[]=$record;
           
        }
        
        $this->fields_count=  count($this->fields); // numero de campos en el arreglo devuelto;
    }
    
    public function valida_fields()
    {
        $this->objeto->table_fields();
        echo '<pre>';
            var_dump($this->objeto->fields[0]);
            
            echo '</pre>';
        for ($i=0;$i<$this->objeto->fields_count;$i++){
            //$datos_bd= array($record->name=>$record[$records->name]);
            echo '<pre>';
            var_dump($this->objeto->fields[$i]);
            
            echo '</pre>';
        }  
        
        
    }
    public function fields_change($field,$value)
    {
        
        if ($this->rowschange[0][$field]!=$value){
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
    
    public function email_notification($tipo) 
    {
            
        if ( $_SESSION['niveluser']==8 || MODO_DE_PRUEBA=="1"){
         return;
        }
         
        $model = new Conexion;
        $conexion=$model->conectar();
        
        $select = $this->select;
        $from = $this->from;
        $condition = $this->condition;
        if($condition!='')
        {
           $condition = "WHERE " . $condition;
        }
        $sql = "SELECT $select FROM $from $condition ";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        
        while ($record = $consulta->fetch())
        {
           $this->roww[]=$record;
        }
                
        $nombre_atleta=trim($this->roww[0]["nombres"]);
        $apellido_atleta=trim($this->roww[0]["atleta_id"]);
        $email=$this->roww[0]["email"];
        $contrasena=$this->roww[0]["contrasena"];
        
        switch ($tipo){
            case "Rank": //Ranking Modificado
                $asunto="Actualizacion de Ranking";
                $notificacion="la actualizacion de ranking";
                break;
            case "Email": //Ingreso de Email
                $asunto="Actualizacion de correo";
                $notificacion="la actualizacion de correo";
                break;
            case "Clave": //Modificacion de clave
                $asunto="Cambio de clave";
                $notificacion="la Creacion de clave";
                break;
            case "RecuperarClave": //Recuperacion de clave
                $asunto="Recuperacion de clave";
                $notificacion="la Modificacion de clave";
                break;
            default:
                $asunto="Ingreso al sistema";
                $notificacion="Entrada al sistema";
                return;

        } 
        $notificacion2="fue realizada exitosamente";
        if ($tipo=="RecuperarClave" || $tipo=="Clave"){
            $notificacion="su nueva clave es :".$contrasena;
            $notificacion2=" ";
        }
        
        //enviamos correor de inscripcion
        if ($email !=null){ // enviamos correo
            $date=date_create();
            $to = $email; //"robinson.carrasquero@gmail.com";
            $subject = $asunto ;
            $txt = "Estimado(a) $nombre_atleta,$apellido_atleta, le notificamos que $notificacion "
                    . $notificacion2;
            $headers = "From: rcarrasquero@gmail.com" 
                    . "\r\n" ."BCC: atenismiranda@gmail.com";

            mail($to,$subject,$txt,$headers);
        }
        
        $conexion=null;
        return;
    }
        
    
    
    
}