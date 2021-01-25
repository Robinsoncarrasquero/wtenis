<?php

/*
 Modelo para manejar el draw de jugadores
 */

/**
 * Description of Crud
 *
 * @author robinson
 */
class Torneo_Draw   {
    //put your code here
   
    private $id;
    private $categoria_id;
    private $ronda;
    private $posicion;
    private $antposicion;
    private $jugador;
   
    private $s1;
    private $s2;
    private $s3;
    private $t1;
    private $t2;
    private $t3;
    private $win;
    private $status;
    private $puntos;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneo_draw';
    private $fields;
    private $fields_count;
    public function __construct() {
        $this->id=0;
       
        $this->categoria_id=0;
       
        $this->ronda=0;
        $this->posicion=0;
        $this->antposicion=0;
        $this->jugador=0;
        $this->s1=0;
        $this->s2=0;
        $this->s3=0;
        $this->t1=0;
        $this->t2=0;
        $this->t3=0;
        $this->win="";
        $this->status="";
        $this->puntos=0;
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
    
    public function getPosicion(){
        return $this->posicion;
    }
    public function setPosicion($value){
         $this->posicion=$value;
    }
    
    public function getantPosicion(){
        return $this->antposicion;
    }
    public function setantPosicion($value){
         $this->antposicion=$value;
    }
    
    public function getRonda(){
        return $this->ronda;
    }
    public function setRonda($value){
         $this->ronda=$value;
    }
    public function getJugador(){
        return $this->jugador;
    }
    public function setJugador($value){
         $this->jugador=$value;
    }
    
    public function getS1(){
        return $this->s1;
    }
    public function setS1($value){
         $this->s1=$value;
    }
    public function getS2(){
        return $this->s2;
    }
    public function setS2($value){
         $this->s2=$value;
    }
    public function getS3(){
        return $this->s3;
    }
    public function setS3($value){
         $this->s3=$value;
    }
    public function getT1(){
       return $this->t1;
        
    }
    public function setT1($value){
         $this->t1=$value;
    }
    public function getT2(){
        return $this->t2;
    }
    public function setT2($value){
         $this->t2=$value;
    }
    
    public function getT3(){
        return $this->t3;
    }
    public function setT3($value){
         $this->t3=$value;
    }
    
    public function getWin(){
        return $this->win;
    }
    public function setWin($value){
         $this->win=$value;
    }
    
    public function getStatus(){
        return $this->status;
    }
    public function setSatus($value){
         $this->status=$value;
    }
    
    public function getPuntos(){
        return $this->puntos;
    }
    public function setPuntos($value){
         $this->puntos=$value;
    }
    public function Operacion_Exitosa() {
       return $this->SQLresultado_exitoso;
    }
    
    public function getMensaje() {
       return $this->mensaje;
    }
      
      
   public static function Ajustar_Draw($numero_jugadores){
        if ($numero_jugadores<=4){
             $draw=4;
        }elseif($numero_jugadores<=8){
             $draw=8;
        }elseif ($numero_jugadores<=16){
             $draw=16;
        }elseif ($numero_jugadores<=32){
             $draw=32;
        }elseif ($numero_jugadores<=64){
             $draw=64;
        }elseif ($numero_jugadores<=128){
             $draw=128;
        }else{
             $draw=0;
        }
        return $draw;
   }
   
  
    public static function Crear_Draw($categoria_id) {

        $numero_jugadores = Torneo_Lista::Count_Jugadores($categoria_id);
        //Determinamos el numero de jugadores para generar el cuadro
        //partiendo de la premisa que los registros son generados por ronda
        //y cada resgistro es un juego

        $draw = Torneo_Draw::Ajustar_Draw($numero_jugadores);
        if ($draw > 0) {
            Torneo_Draw::Generar_Draw($draw, $categoria_id);
        }
    }
    //Nos indica la ronda de un juego retornando un valor y recibimos como
    //parametro la categoria y numero de ronda 64,32,16,8,4 para
    // retornar un valor R1,R2,R3 etc.
    public static function Ronda($categoria_id,$ronda){
        $rondas=  Torneo_Draw::Rondas($categoria_id);
              
        for ($i=0;$i<$rondas;$i++){
            if ($i== 0){
                $base =  2;
            }else{
                $base *=  2;
            }
            
            $array_ronda[]=$base;
        }
        //Ordena el arreglo de forma descendente( maor a menor)
        rsort($array_ronda);
        $r=0;
        //var_dump($array_ronda);
        foreach ($array_ronda as $value) {
            $r++;
            if ($value==$ronda){
                $laronda= "R".$r;
                break;
            }
            
       
        }
       
        
        
        return $laronda;
           
    }
            

    public static function Rondas($categoria_id){
        try {
            $model = new Conexion;
            $conn = $model->conectar();
            $SQL = $conn->prepare('SELECT COUNT(DISTINCT ronda) as total              
                 FROM ' . self::TABLA . ' WHERE categoria_id = :categoria_id ');
            $SQL->bindParam(':categoria_id', $categoria_id);

            $SQL->execute();
            $registros = $SQL->fetch();
            $conn = NULL;
            if ($registros) {
                return $registros['total'];
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            echo "Error" . $ex->getMessage();
        }
    }

    private static function Generar_Draw($draw,$categoria_id) {
           $objConn = new Conexion();
           $conn = $objConn->conectar();
           // set the PDO error mode to exception
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
           $ronda=$draw;
           for ($index = 0; $index < $draw; $index++) {
                $posicion= $index + 1;
               
                $campos='(categoria_id,posicion,ronda)';
                $valores='(:categoria_id,:posicion,:ronda)';

                $SQL = $conn->prepare('INSERT INTO ' .self::TABLA. $campos. ' VALUES '. $valores);
                $SQL->bindParam(':categoria_id', $categoria_id);
                $SQL->bindParam(':posicion', $posicion);
                $SQL->bindParam(':ronda', $ronda);
                $SQL->execute();
                $id = $conn->lastInsertId();

                //echo "New records created successfully";
                $mensaje='New records created successfully';
                $SQLresultado_exitoso=TRUE;
           }
           if ($draw % 2==0 && $draw/2 >1){
                Torneo_Draw::Generar_Draw($draw/2,$categoria_id);
           }
       
       
   }
   
   //Cuenta los jugadores de una categoria
    public static function Count_Jugadores($categoria_id) {
         
       try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT COUNT(*) as total  FROM ' . self::TABLA . ' WHERE categoria_id = :categoria_id '
                    . '&& antpo=:ronda ORDER BY posicion');
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
    public function Puntos() {
         
       try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT ronda,puntos  FROM ' . self::TABLA . ' WHERE jugador = :jugador '
                    . '&& categoria_id = :categoria_id ORDER BY ronda asc LIMIT 1');
            $SQL->bindParam(':jugador', $this->jugador);
            $SQL->bindParam(':categoria_id', $this->categoria_id);
            
            $SQL->execute();
            $registros = $SQL->fetch();
            $conn=NULL;
            if ($registros){
                return $registros['puntos'];
            }else{
                return 0;
                
            }
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
        
    }
    
    
    public function Update(){
         try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL=' SET categoria_id = :categoria_id, '
                .' posicion = :posicion, antposicion = :antposicion, s1 = :s1, s2 = :s2, '
                . 's3 = :s3, t1 = :t1, t2 = :t2,t3 = :t3, win = :win, ronda = :ronda, '
                . 'jugador = :jugador, status = :status, puntos = :puntos ';
                           
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE id= :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':categoria_id', $this->categoria_id);
            $stmt->bindParam(':posicion', $this->posicion);
            $stmt->bindParam(':antposicion', $this->antposicion);
            $stmt->bindParam(':s1', $this->s1);
            $stmt->bindParam(':s2', $this->s2);
            $stmt->bindParam(':s3', $this->s3);
            $stmt->bindParam(':t1', $this->t1);
            $stmt->bindParam(':t2', $this->t2);
            $stmt->bindParam(':t3', $this->t3);
            $stmt->bindParam(':win', $this->win);
            $stmt->bindParam(':ronda',$this->ronda);
            $stmt->bindParam(':jugador',$this->jugador);
            $stmt->bindParam(':status',$this->status);
            $stmt->bindParam(':puntos',$this->puntos);
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
    
    public function Avanzar_Ronda($categoria_id,$ronda,$posicion,$jugador,$puntos) {
        
        $antposicion=$posicion;
        if ($posicion % 2==0){
            $posicion /=2;
            

        }else{
            $posicion ++;
            $posicion /=2;
        }
        
        $ronda /= 2;
        
        try {
            $objConn = new Conexion();
            $conn = $objConn->conectar();
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $SQL=' SET jugador = :jugador, antposicion = :antposicion, puntos= :puntos ';
                           
            $stmt = $conn->prepare('UPDATE ' . self::TABLA . $SQL. ' WHERE  categoria_id=:categoria_id '
                    . '&& ronda=:ronda && posicion=:posicion');
            
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':ronda', $ronda);
            $stmt->bindParam(':posicion', $posicion);
            $stmt->bindParam(':jugador',$jugador);
            $stmt->bindParam(':antposicion', $antposicion);
            $stmt->bindParam(':puntos', $puntos);
            $stmt->execute();

            //echo "Update record successfully";
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
    //Traer el registro de la ronda anterior ganada para efectos de mostrar los
    //datos del layout del draw en la caja de avance de juego
    public function FindRondaAnterior($categoria_id,$ronda,$jugador) {
       $ronda *= 2;
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE categoria_id=:categoria_id && ronda=:ronda && jugador=:jugador');
       $SQL->bindParam(':categoria_id', $categoria_id);
       $SQL->bindParam(':ronda', $ronda);
       $SQL->bindParam(':jugador', $jugador);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
      
       $conn=NULL;
       
    }
    
    public function Fetch($id) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE id = :id');
       $SQL->bindParam(':id', $id);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
       
       $conn=NULL;
       
    }
    
    private function Record($record){
        if($record){
           
            $this->categoria_id= $record['categoria_id'];
            $this->posicion=$record['posicion'];
            $this->antposicion=$record['antposicion'];
            $this->ronda=$record['ronda'];
            $this->s1= $record['s1'];
            $this->s2= $record['s2'];
            $this->s3=$record['s3'];
            $this->t1=$record['t1'];
            $this->t2=$record['t2'];
            $this->t3=$record['t3'];
            $this->win=$record['win'];
            $this->jugador=$record['jugador'];
            $this->status=$record['status'];
            $this->puntos=$record['puntos'];
            $this->id=$record['id'];
            $this->mensaje='Record Found successfully ';
            $this->SQLresultado_exitoso=TRUE;
       } else {
             $this->SQLresultado_exitoso=FALSE;
             $this->mensaje='Record Not Found..';
       }
      
        
    }


    //Busca el contricante de un juego
    public function FindPosicion($categoria_id,$ronda,$posicion) {
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare("SELECT * FROM " . self::TABLA . ' WHERE categoria_id=:categoria_id && ronda=:ronda && posicion=:posicion');
       $SQL->bindParam(':categoria_id', $categoria_id);
       $SQL->bindParam(':ronda', $ronda);
       $SQL->bindParam(':posicion', $posicion);
       $SQL->execute();
       $record = $SQL->fetch();
       $this->Record($record);
      
       $conn=NULL;
       
    }
    
    
    //Busca el contricante de un juego tomando en cuenta su posicion de juego
    public function FindContrincante($categoria_id,$ronda,$posicion) {
        if ($posicion % 2==0){
            $posicion = $posicion - 1;

        }else{
            $posicion = $posicion + 1;
        }
        $this->FindPosicion($categoria_id, $ronda, $posicion);
             
      
       
    }
    
    public static function ReadById($id) {
        try {
            $model = new Conexion;
            $conn = $model->conectar();
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE id = :id');
            $SQL->bindParam(':id', $id);
            $SQL->execute();
            $record = $SQL->fetch();
            if ($record) {
                $SQLresultado_exitoso = TRUE;
                return new self($record['categoria_id'],$record['posicion'],$record['ronda'],
                        $record['s1'], $record['s2'], $record['s3'],$record['t1'], $record['t2'], $record['t3'], 
                        $record['win'], $record['jugador'], $record['status'],$record['puntos']);
            } else {
                $SQLresultado_exitoso = FALSE;
            }
            $conn = NULL;
        } catch (Exception $ex) {
            echo "Error:" . $ex->getMessage();
             
        }
    }
    //returna el draw completo ordenado por ronda
    public static function ReadAllbyRonda($categoria_id,$ronda) {
        try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE categoria_id= :categoria_id  && ronda = :ronda ORDER BY posicion');
            $SQL->bindParam(':categoria_id', $categoria_id);
            $SQL->bindParam(':ronda', $ronda);
            $SQL->execute();
            $registros = $SQL->fetchall();
            $conn=NULL;
            return $registros;
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
       
        
    }
   
    
    //returna el draw completo ordenado por ronda descendente
    public static function Historico($atleta_id,$categoria_id) {
        try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE categoria_id= :categoria_id && jugador= :jugador   ORDER BY ronda desc');
            $SQL->bindParam(':categoria_id', $categoria_id);
            $SQL->bindParam(':jugador', $atleta_id);
           
            $SQL->execute();
            $registros = $SQL->fetchall();
            $conn=NULL;
            return $registros;
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
       
        
    }
    
    //returna el Puntaje final obtenido en un torneo
    public static function PuntosObtenidos($atleta_id,$categoria_id) {
        try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT * FROM ' . self::TABLA . ' WHERE categoria_id= :categoria_id && jugador= :jugador   ORDER BY ronda limit 1');
            $SQL->bindParam(':categoria_id', $categoria_id);
            $SQL->bindParam(':jugador', $atleta_id);
           
            $SQL->execute();
            $registros = $SQL->fetchall();
            $conn=NULL;
            return $registros;
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
       
        
    }
    
    //returna el historico de juegos por categoria un registro por categoria
    public static function AcividadDistinct($atleta_id) {
        try{
            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare('SELECT DISTINCT categoria_id FROM ' . self::TABLA . ' WHERE jugador= :jugador   ORDER BY categoria_id,ronda desc');
            $SQL->bindParam(':jugador', $atleta_id);
           
            $SQL->execute();
            $registros = $SQL->fetchall();
            $conn=NULL;
            return $registros;
            
        } catch (Exception $ex) {
            echo "Error". $ex->getMessage();

        }
       
        
    }
         
    
    
}
               