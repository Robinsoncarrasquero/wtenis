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
class Torneo_Lista_Sorteo  {
    //put your code here
   
    
    private $categoria_id;
    private $posicion;
    private $posiciondraw;
    private $jugador;
    private $rk;
    public $bye;
    public $draw;
    public $array_siembras;
    public $array_bye;
    public $array_bye_bye;  
    public $array_dif;
    public $array_jugadores;
    public $array_final;
    private $dirty;
    private $mensaje;
    private $SQLresultado_exitoso;
    const TABLA = 'torneo_lista';
    private $fields;
    private $fields_count;
    
    public function __construct($categoria_id) {
        $this->categoria_id=$categoria_id;
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
    
    
    //Metodo para iniciar el sorteo de juagadores
     public function SORTEAR_SORTEAR() {
        
        $this->bye=Torneo_Lista::Count_Posiciones_Bye($this->categoria_id);
        $this->draw=Torneo_Lista::Count_Jugadores($this->categoria_id);
       
        $this->Sorteo_Siembras();

        $this->Sorteo_Bye();

        $this->Sorteo_Bye_Bye();

        $this->Sorteo_Dif();

        $this->SortearJugadores();

        $this->SorteoSave($this->array_siembras);

        $this->SorteoSave($this->array_bye);

        $this->SorteoSave($this->array_bye_bye);

        $this->SorteoSave($this->array_dif);

        $this->SorteoSave($this->array_final);
    }
    
   
    
    //Actualiza la data del sorteo en la lista
    private function SorteoSave($array_data) {
        
        
       
        foreach ($array_data as $posicion_lista => $posicion_draw) {

            $objlista = new Torneo_Lista();

            $objlista->FindPosicion($this->categoria_id, $this->draw, $posicion_lista);
            if ($objlista->Operacion_Exitosa()) {
                $objlista->setPosiciondraw($posicion_draw);
                $objlista->Update();
            }
        }
    }
    
    
    //Sorteamos las 8 siembras de las lista de jugadores
    //segun las reglas de cabezas de serie
    public function Sorteo_Siembras() {
      
        
         if ($this->draw==64){
            $siembra = [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16];
            $posicion = [1, 64, 17,48,16,32,33,49,9,25,40,56,8,24,41,57];
            $grupo1a2 = [1, 2]; //Grupo fijo simbra 1 y 2
            $grupo3a4 = [3, 4]; //Grupo que sortea posiciones
            $grupo5a8=[5, 6, 7, 8]; //Grupo que sortea posiciones
            $grupo9a12=[9,10,11,12]; //Grupo que sortea posiciones
            $grupo13a16=[13,14,15,16]; //Grupo que sortea posiciones
            

            $array0=$grupo1a2;
            $array1=$this->sorteo($grupo3a4);
            $array2=$this->sorteo($grupo5a8);
            $array3=$this->sorteo($grupo9a12);
            $array4=$this->sorteo($grupo13a16);
            $seed= array_merge($array0,$array1,$array2,$array3,$array4);
        }
        if ($this->draw==32){
            $siembra = [1, 2, 3, 4, 5, 6, 7, 8];
            $posicion = [1, 32, 9, 24, 8, 16, 17, 25];
            $grupo0 = [1, 2]; //Grupo fijo simbra 1 y 2
            $grupo1 = [3, 4]; //Grupo que sortea posiciones
            $grupo2=[5, 6, 7, 8]; //Grupo que sortea posiciones

            $array0=$grupo0;
            $array1=$this->sorteo($grupo1);
            $array2=$this->sorteo($grupo2);
            $seed= array_merge($array0,$array1,$array2);
        }
        
        if ($this->draw==16){
            $siembra = [1, 2, 3, 4];
            $posicion = [1, 16, 5,12];
            $grupo0 = [1, 2]; //Grupo fijo simbra 1 y 2
            $grupo1 = [3, 4]; //Grupo que sortea posiciones
            $array0=$grupo0;
            $array1=$this->sorteo($grupo1);
            $seed= array_merge($array0,$array1);
            
        }
        
        if ($this->draw==8){
            $siembra = [1, 2];
            $posicion = [1, 8];
            $grupo0 = [1, 2]; //Grupo fijo simbra 1 y 2
            $array0=$grupo0;
            $seed= $array0;
            
        }
        
         if ($this->draw==4){
            $siembra = [1];
            $posicion = [1];
            $grupo0 = [1]; //Grupo fijo simbra 1 y 2
            $seed=$grupo0;
            
            
        }
       
        //Combinamos posiciones con siembras para obtener los puestos sorteados            
        $posiciones_sembradas = array_combine($seed, $posicion);
        $this->array_siembras= $posiciones_sembradas;
        
        
       
    }
    
    
    //Sorteamos los bye para las siembras
    private function Sorteo_Bye() {
        
        if ($this->bye == 0) {
            return array ();
        }
        
        //Creamos las posiciones bye que comienzan en la posicion del ultimo jugador de la lista(draw-bye+1)
        $inicio=$this->draw - $this->bye + 1  ;
        for ($i=0;$i<$inicio;$i++){
            $puesto= $i + $inicio;
            $posiciones_bye[]=$puesto;

        }
         
        //Los bye disponibles los asignamos a las posiciones sorteadas
        //Posicion de inicio de las posiciones libres en las lista de jugadores que estan al final
        //y se asignan como bye segun el sorteo de acuerdo a las orden de siembras
        if ($this->draw==64){
           
            $siembras = [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16];
            $posiciones_draw =  [2,63,18,47,15,31,34,50,10,26,39,55,7,23,42,58];
            $grupo1a2 = [1, 2]; //Grupo fijo simbra 1 y 2
            $grupo3a4 = [3, 4]; //Grupo que sortea posiciones
            $grupo5a8=[5, 6, 7, 8]; //Grupo que sortea posiciones
            $grupo9a12=[9,10,11,12]; //Grupo que sortea posiciones
            $grupo13a16=[13,14,15,16]; //Grupo que sortea posiciones

            //Sorteamos cada grupo de posiciones con las siembras
            $array0=$grupo1a2;
            $array1=$this->sorteo($grupo3a4);
            $array2=$this->sorteo($grupo5a8);
            $array3=$this->sorteo($grupo9a12);
            $array4=$this->sorteo($grupo13a16);
             
            $siembra_new= array_merge($array0,$array1,$array2,$array3,$array4);
            $bye_out = $this->bye <16 ? $this->bye : 16;
        }
        if ($this->draw==32){
            
            $siembras = [1, 2, 3, 4, 5, 6, 7, 8];
            $posiciones_draw = [2, 31, 10, 23, 7, 15, 18, 26];
            $grupo0 = [1, 2]; //Grupo 0 fijo posiciones 1 y 32
            $grupo1 = [3, 4]; //Grupo 1 fijo posiciones 3 y 4
            $grupo2 = [5, 6, 7, 8]; //Grupo 2 sortea posiciones 8 16 17 y 25

            //Sorteamos cada grupo de posiciones con las siembras
            $array0=$grupo0;
            $array1=$this->sorteo($grupo1);
            $array2=$this->sorteo($grupo2);
            $siembra_new= array_merge($array0,$array1,$array2);
            $bye_out = $this->bye <8 ? $this->bye : 8;
        }
        
          
        if ($this->draw==16){
            $siembras = [1, 2, 3, 4];
            $posiciones_draw = [2, 15, 6, 11];
            $grupo0 = [1, 2]; //Grupo 0 fijo posiciones 1 y 32
            $grupo1 = [3, 4]; //Grupo 1 fijo posiciones 3 y 4
         
            //Sorteamos cada grupo de posiciones con las siembras
            $array0=$grupo0;
            $array1=$this->sorteo($grupo1);
            
            $siembra_new= array_merge($array0,$array1);
            $bye_out = $this->bye <4 ? $this->bye : 4;
        }
        
        if ($this->draw==8){
            $siembras = [1, 2];
            $posiciones_draw = [2,7];
            $grupo0 = [1, 2]; //Grupo 0 fijo posiciones 1 y 
           
            //Sorteamos cada grupo de posiciones con las siembras
            $array0=$grupo0;
                      
            $siembra_new= array_merge($array0);
            $bye_out = $this->bye <2 ? $this->bye : 2;
        }
        
        if ($this->draw==4){
            
            $siembras = [1];
            $posiciones_draw = [2]; //Posicion del draw
            $grupo0 = [1]; //Grupo 0 fijo posiciones 1 y 
           
            //Sorteamos cada grupo de posiciones con las siembras
            $array0=$grupo0;
                      
            $siembra_new= $array0;
            $bye_out = $this->bye <1 ? $this->bye : 1;
        }
        foreach ($siembra_new as $value) {
            $posiciones_sorteadas[]=$posiciones_draw[$value-1];
        }

        //Los bye disponibles los asignamos a las siembras por prioridad y sorteo
        //Tomamos las posiciones que corresponden al numero de bye disponibles
       
        $array0 = array_splice($posiciones_sorteadas, -0, $bye_out);
        $array1 = array_splice($posiciones_bye, -0, $bye_out);

        //Combinamos las siembras con las posiciones a repartir
      
        $this->array_bye=array_combine($array1,$array0 );
        
        
       
       
    }
    
    
    //Sorteamos los bye adicionales para completar el cuadro de
    //jugadores
    private function Sorteo_Bye_Bye() {
        
        //Determinamos los bye maximos permitidos
        $bye_maximos= ($this->draw /2) - ($this->draw/4  - 1);
                 
        
        if( $this->bye<$bye_maximos){
              return array ();
        }

        //Posiciones que se pueden distribuir para los bye adicionales cuando tenemos un
        //cuadro con la mitad + 1 jugador
        
        if ($this->draw==64){
            $siembras = [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16];
            $posiciones_bye_draw= [3,62,19,14,30,35,51,11,27,38,54,6,22,43,59]; //Cabeza de posicion
          
        }
        if ($this->draw==32){
            $siembras = [1, 2, 3, 4, 5, 6, 7, 8];
            $posiciones_bye_draw= [3,30,6,27,11,22,14,19]; //Cabeza de posicion
          
        }
        
        if ($this->draw==16){
            $siembras = [1, 2, 3, 4];
            $posiciones_bye_draw= [3,14,7,10]; //Cabeza de posicion
        }
        
        if ($this->draw==8){
            $siembras = [1, 2];
            $posiciones_bye_draw= [3,6]; //Cabeza de posicion
        }
      
        //Calculamos los bye adicionales maximos del draw
        $bye_out = $this->bye - $this->draw/4;
        
        //Establemos los siguientes puesto en la lista despues de la siembras reglamentarias
        //para asignar los jugadores en esa posicion de la lista no del draw
        $inicio=$this->draw - $this->bye + ($this->draw/4) + 1  ;
        for ($i=0;$i<$inicio;$i++){
            $puesto= $i + $inicio;
            $posiciones_bye[]=$puesto;

        }
        //Sorteamos las posiciones
        $array0=$this->sorteo($siembras);
        $siembra_new= array_merge($array0);
       
        //Organizamos las posiciones segun sorteo
        foreach ($siembra_new as $value) {
            $posiciones_sorteadas[]=$posiciones_bye_draw[$value-1];

        }
   
        //Tomamos las posiciones que corresponden al numero de bye disponibles
        $array0 = array_splice($posiciones_sorteadas, -0, $bye_out);
        $array1 = array_splice($posiciones_bye, -0, $bye_out);

        //Combinamos las siembras con las posiciones a repartir
        $this->array_bye_bye = array_combine($array1,$array0);
        
       
    }
    
    
    //Determina las posiciones que se deben llenar desde la posicion 9 hasta el final de
    //jugadores del draw. Este funcion excluye la siembras desde la 1 a la 8 
    private function Sorteo_Dif() {
        
        $draw = $this->draw;
        $puesto = 0;
        //Creamos un arreglo con todas las posiciones
        for ($i = 0; $i < $draw; $i++) {
            $puesto = $i + 1;
            $array_posiciones_completas[] = $puesto;
        }
       
        $array_siembra=$this->array_siembras;
        $array_bye=$this->array_bye;
        $array_bye_adicionales=$this->array_bye_bye;
       
        //Reordenamos las posiciones de las siembras
        foreach ($array_siembra as $key => $posicion) {
            $array_siembra_orden[] = $posicion;
        }
        //Reordenamos las posiciones de los bye de las siembras
        foreach ($array_bye as $key => $posicion) {
            $array_bye_orden[] = $posicion;
        }

        //Reordenamos las posiciones de los bye de las siembras
        foreach ($array_bye_adicionales as $key => $posicion) {
            $array_bye_restan_orden[] = $posicion;
        }
       
        if (count($array_bye_orden) > 0) {

            if (count($array_bye_adicionales) > 0) {

                $array_posiciones_ocupadas = array_merge($array_bye_orden, $array_siembra_orden, $array_bye_restan_orden);
                $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
            } else {
                
                $array_posiciones_ocupadas = array_merge($array_bye_orden, $array_siembra_orden);
                $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
                
                
            }
        } else {
                
                $array_posiciones_ocupadas =$array_siembra_orden;
                $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
        }
        
        //Reordenamos las posiciones de los bye de las ultima siembra
        //la siguiente posicion
       
        $inicio=$this->draw/4;
        foreach ($array_posiciones_libres as $key => $posicion) {
           $inicio ++;
           $array_posiciones[]=$inicio;
        }
        //Combinamos arreglos de posiciones lista con posiciones libres por actualizar 
        $this->array_dif = array_combine($array_posiciones,$array_posiciones_libres );
        $this->array_jugadores=$this->array_dif;
        
        
        $this->SortearJugadores();
      
        
    }
    
    //Asigna los puestos sorteados a cada jugador en la posicion de la lista desde la ultima siembra
    private function SortearJugadores() {
        //Jugadores segun cuadro 
        $drawx = $this->draw - count($this->array_jugadores) - $this->bye;
       
        $array_jugadores=$this->array_jugadores;
        //Posiciones sorteadas
        if ($this->draw == 64) {
            $puestos_draw = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22,23,
                24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48];
        }
        //Posiciones sorteadas
        if ($this->draw == 32) {
            $puestos_draw = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24];
        }
        //Posiciones sorteadas
        if ($this->draw == 16) {
            $puestos_draw = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        }
         //Posiciones sorteadas
        if ($this->draw == 8) {
            $puestos_draw = [1, 2, 3, 4, 5, 6];
        }
         //Posiciones sorteadas
        if ($this->draw == 4) {
            $puestos_draw = [1,2];
        }
        $desdeLinea = $this->draw /4;
     
        $posiciones_draw = array_splice($puestos_draw, 0, count($array_jugadores));
        $array_jugadores_sorteados = $this->sorteo($posiciones_draw);
       
        //Organizamos las posiciones segun sorteo iniciando desde la posicion de 
        //la ultima siembra paa obtener el key del array de los jugadores
        foreach ($array_jugadores_sorteados as $key => $value) {
            $array_jugadores_ordenado[] = $array_jugadores[$value + $desdeLinea];
        }
        
        $inicio=$desdeLinea;
        foreach ($array_jugadores_sorteados as $key => $posicion) {
            $inicio ++;
            $array_posiciones_lista[] = $inicio;
        }
        $this->array_final = array_combine($array_posiciones_lista, $array_jugadores_ordenado);
         
          
    }
  
    //Metodo para realizar el sorteo de posiciones
    //dado un array  como parametro
    private function sorteo(array $posiciones) {

        $array_pos = $posiciones;
        $vmax = count($array_pos);
        $elementos = count($array_pos);
        for ($i = 0; $i < $elementos; $i++) {
            $vmin = 0;
            $vmax = $vmax - 1;
            $pos = mt_rand($vmin, $vmax);

            $new_array[] = $array_pos[$pos];
            array_splice($array_pos, $pos, 1);
        }

        return $new_array;
    }
    
      
    
    
}
               