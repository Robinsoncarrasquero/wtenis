<?php
//Declarar la interfaz 'iTemplate'
interface iPersistencia{

    public function save($data);
    
}

interface iConexion{
    public function conexion($cnn);
}

?>
