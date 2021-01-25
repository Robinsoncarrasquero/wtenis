<?php 

/*
 * Modelo de clase Abstracta para manejar Crud para cubrir los principios solid 
 * "Single Responsability".
 */
abstract class AbstractCrud{
    
    protected function Create(){}
    
    protected function Find($id) {}
     
    protected function Update(){}

    protected function Delete($id) {}

    protected function Record($record) {}
        
}