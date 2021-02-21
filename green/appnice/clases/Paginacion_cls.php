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
class Paginacion   {
    //put your code here
    public $Tabla;
    private $total_registros;
    private $registrosxpagina;
    private $pagina;
    


    public function __construct($registrosxpagina=10,$pagina) {
        $this->registrosxpagina=$registrosxpagina;
        $this->pagina=$pagina==0 ? 1 : $pagina;
       
    }
    //Obtenemos el inicio para establecer el Inicio(Limit) de los registros en ls BD
    public function getInicio(){
        return ($this->pagina-1) *  $this->registrosxpagina;
    }
    //Obtenemos el numero de la pagina
    public function getPagina(){
        return $this->pagina;
    }
    
    public function getTotalPaginas() {
        return ceil($this->total_registros/  $this->registrosxpagina);
    }
    
    public function getRegistrosPorPaginas() {
        return $this->registrosxpagina;
    }
    
    //Consulta SQL 
    public function SelectRecordsParam($Select,$Array_Param) {
        try {
            $mySelect = $Select . " LIMIT ".$this->getInicio().",". $this->registrosxpagina;

            $model = new Conexion;
            $conn=$model->conectar();
            $SQL = $conn->prepare($mySelect,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $SQL->execute($Array_Param);
            $records = $SQL->fetchAll();
            $conn=NULL;
            return $records;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
           
        }
               
    }
        
    //Consulta SQL 
    public function SelectRecords($Select) {
       $mySelect = $Select . " LIMIT ".$this->getInicio().",". $this->registrosxpagina;
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($mySelect);
       $SQL->execute();
       $records = $SQL->fetchAll();
       
       $conn=NULL;
       return $records;
    }
    //Contamos los registros de la consulta
     public function setTotal_Registros($Select) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($Select);
       $SQL->execute();
       $record = $SQL->fetch();
       if ($record){
           $this->total_registros=$record['total'];
       }else{
           $this->total_registros=0;
       }
       $conn=NULL;
       
    }
    public function getTotal_Registros(){
        return $this->total_registros;
    }
    //Creamos la paginacion
    public function Paginacion() {
        $total_pages=  $this->getTotalPaginas();
        $page=  $this->getPagina();
        $lpaginacion= '<nav>';
        $lpaginacion .= '<ul class="pagination">';
        
        //Generar la paginacion
        if ($total_pages >1) {
            //Paginacion de regreso desde la pagina activa y despues de la primera pagina
            if ($page != 1) {
                $lpaginacion .= '<li class="page-item"><a class="page-link" href="#" data-id="page'.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            //Imprimir las paginacion
            for ($i=1;$i<=$total_pages;$i++) {
                if ($page == $i) {
                    //Pagina Activa 
                    $lpaginacion .= '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
                } else {
                   //Pagina Normal href
                   $lpaginacion .= '<li class="page-item"><a  class="page-link" href="#" data-id="page'.$i.'">'.$i.'</a></li>';
                }
            }
            //Paginacion de Siguiente sin haber llegado a la ultima pagina
            if ($page != $total_pages) {
                $lpaginacion .= '<li class="page-item"><a class="page-link" href="#" data-id="page'.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
        }
        $lpaginacion .= '</ul>';
        $lpaginacion .= '</nav>'; 
        return $lpaginacion;
    }
    //Paginacion simple avanzar y regresar
    public function PaginacionSimple() {
        $total_pages=  $this->getTotalPaginas();
        $page=  $this->getPagina();
        $lpaginacion= '<nav>';
        $lpaginacion .= '<ul class="pagination">';
        //Generar la paginacion
        if ($total_pages > 1) {
            //Paginacion de regreso desde la pagina activa y despues de la primera pagina
            if ($page != 1) {
                $lpaginacion .= '<li class="page-item"><a class="page-link" href="#" data-id="page'.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
//            //Imprimir las paginacion
//            for ($i=1;$i<=$total_pages;$i++) {
//                if ($page == $i) {
//                    //Pagina Activa 
//                    $lpaginacion .= '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
//                } else {
//                   //Pagina Normal href
//                   $lpaginacion .= '<li class="page-item"><a  class="page-link" href="#" data-id="page'.$i.'">'.$i.'</a></li>';
//                }
//            }
            //Paginacion de Siguiente sin haber llegado a la ultima pagina
            if ($page != $total_pages) {
                $lpaginacion .= '<li class="page-item"><a class="page-link" href="#" data-id="page'.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
        }
        $lpaginacion .= '</ul>';
        $lpaginacion .= '</nav>'; 
        return $lpaginacion;
    }
}
               