<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Programa para generar consultar SQL manualmente
 *
 * @author robinson
 */
class SQL_PDO   {
    //Consulta SQL 

    //Nos realiza el select de una consulta creada
    public static function SelectRecords($Select) {
       $mySelect = $Select ;
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($mySelect);
       $SQL->execute();
       $records = $SQL->fetchAll();
       
       $conn=NULL;
       return $records;
    }
    //Contamos los registros de la consulta
     public static function Count_Records($Select) {
       
       $model = new Conexion;
       $conn=$model->conectar();
       $SQL = $conn->prepare($Select);
       $SQL->execute();
       $record = $SQL->fetch();
       if ($record){
         return $record->total;
       }else{
         return 0;
       }
       $conn=NULL;
       
    }
    
}

?>