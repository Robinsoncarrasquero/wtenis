<?php
include '../clases/Atleta_cls.php';
include '../clases/Torneos_Inscritos_cls.php';

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
class Torneo_Lista  {
    //put your code here
    private $categoria_id;
    private $posicion;
    private $posiciondraw;
    private $jugador;
    private $rk;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneo_lista';
    private $fields;
    private $fields_count;
    
    public function __construct() {
        $this->categoria_id=0;
        $this->posicion=0;
        $this->posiciondraw=0;
        $this->jugador=0;
        $this->rk=0;
        $this->dirty=FALSE;
        $this->SQLresultado_exitoso=FALSE;
    }
    public function get_id(){
        return $this->id;
    }
    
   
    public function getCategoria_id(){
        return $this->categoria_id;
    }
    public function setCategoria_id($value){
         $this->categoria_id=$value;
    }
    
   
    
     public function getRanking(){
        return $this->rk;
    }
    
    public function setRanking($value){
         $this->rk=$value;
    }


    public function getPosicion(){
        return $this->posicion;
    }
   
      
    public function getPosiciondraw(){
        return $this->posicion;
    }
    
    public function setPosiciondraw($value){
        $this->posiciondraw=$value;
    }
     
    public function getJugador(){
        return $this->jugador;
    }
    public function setJugador($value){
         $this->jugador=$value;
    }
   
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
    
     
    
   
    //Busca el contricante de un juego
    public function FindPosicion($categoria_id,$ronda,$posicion) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE categoria_id=:categoria_id '
               . ' && posicion=:posicion');
       $SQL->bindParam(':categoria_id', $categoria_id);
       $SQL->bindParam(':posicion', $posicion);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
      
       $conn=NULL;
       
    }
   
    

    public function Update(){
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL=' SET jugador = :jugador, posiciondraw = :posiciondraw, rk = :rk';
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':jugador', $this->jugador);
            $stmt->bindParam(':posiciondraw', $this->posiciondraw);
            $stmt->bindParam(':rk', $this->rk);
                             
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
   
    private function Record($record) {
        if($record){
            $this->categoria_id=$record['categoria_id'];
            $this->posicion=$record['posicion'];
            $this->posiciondraw=$record['posiciondraw'];
            $this->jugador=$record['jugador'];
            $this->rk=$record['rk'];
            $this->id=$record['id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
        
    }
    
     public function Find($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
    }
    
    public static function ReadAll($categoria_id) {
        try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE categoria_id=:categoria_id '
                    . 'ORDER BY posicion');
            $SQL->bindParam(':categoria_id', $categoria_id);
            $SQL->execute();
            $registros = $SQL->fetchall();
            $conn=NULL;
            return $registros;
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
       
        
    }
    
    //Cuenta los jugadores de una categoria
    public static function Count_Jugadores($categoria_id) {
         
       try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT COUNT(*) as total  FROM ' . self::TABLA . ' WHERE categoria_id = :categoria_id '
                    . ' ORDER BY posicion');
            $SQL->bindParam(':categoria_id', $categoria_id);
            
            $SQL->execute();
            $registros = $SQL->fetch();
            $conn=NULL;
            if ($registros){
                return $registros['total'];
            }else{
                return 0;
                
            }
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
        
    }
     //Cuenta los jugadores de una categoria
    public static function Count_Posiciones_Bye($categoria_id) {
         
       try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT COUNT(*) as total  FROM ' . self::TABLA . ' WHERE categoria_id=:categoria_id && jugador=0');
            $SQL->bindParam(':categoria_id', $categoria_id);
            $SQL->execute();
            $registros = $SQL->fetch();
            $conn=NULL;
            if ($registros){
                return $registros['total'];
            }else{
                return 0;
                
            }
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
        
    }
    
    
    //Crea la lista de jugadores en orden segun posicion de ranking
    //para generar el draw de juego
    public function Crear_Lista($categoria_id) {
        $objCategoria= new Torneo_Categoria();
        $objCategoria->Find($categoria_id);
        $categoria_id=$objCategoria->get_id(); 
        $rsdata=  TorneosInscritos::ListaAceptacionFinal($objCategoria->getTorneo_id(), $objCategoria->getCategoria(),$objCategoria->getSexo());
        $posicion=0;    
        
        foreach ($rsdata as $value) {
            $atleta_id=$value['atleta_id'];
            $rk=($value['rknacional']!=999) ? $value['rknacional']: 0 ;
            $posicion++;
            $this->Crear_Lista_Add($categoria_id,$posicion,$atleta_id,$rk);

        }

        $numero_jugadores=$posicion;
        if ($numero_jugadores>0){
            if ($numero_jugadores<=4){
                 $faltan=4 - $numero_jugadores;
            }elseif ($numero_jugadores<=8){
                 $faltan=8 - $numero_jugadores;
            }elseif ($numero_jugadores<=16){
                 $faltan= 16 - $numero_jugadores;
            }elseif ($numero_jugadores<=32){
                $faltan=32 - $numero_jugadores;
            }elseif ($numero_jugadores<=64){
                 $faltan=64 - $numero_jugadores;
            }elseif ($numero_jugadores<=128){
                 $faltan=128 - $numero_jugadores;
            }else{
                 $faltan=0;
            }

            for ($x=0;$x<$faltan;$x++){
                $posicion++;
                $atleta_id=0;
                $rk=0;
                $this->Crear_Lista_Add($categoria_id,$posicion,$atleta_id,$rk);
             }


        }
    }
    
    
   
    //Agrega los jugadores a la lista
    private function Crear_Lista_Add($categoria_id,$posicion,$jugador,$rk){
        try {
           $objConn = new Conexion();
           $conn = $objConn->conectar();
           // set the PDO error mode to exception
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $campos='(categoria_id,posicion,jugador,rk)';
           $valores='(:categoria_id,:posicion,:jugador,:rk)';

           $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
           $SQL->bindParam(':categoria_id', $categoria_id);
           $SQL->bindParam(':posicion', $posicion);
           $SQL->bindParam(':jugador', $jugador);
           $SQL->bindParam(':rk', $rk);
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
    
   
    
   
      
    
    
}
               