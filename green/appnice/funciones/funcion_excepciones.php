<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Funcion para validar el pago de la afiliacion del periodo
function Pago_Afiliacion_Anual($atleta_id,$fecha_fin_torneo,$torneo_empresa_id) {
       
       //En caso del superusuario devuelve el listado completo de inscritos
       //Incluyendo a otras asociaciones y no afiliados
       if ($_SESSION['niveluser']>0){
           return TRUE;
        }
        
        
        
        $sql = "SELECT empresa.empresa_id FROM atleta inner join empresa on atleta.estado=empresa.estado "
               . " WHERE  atleta.atleta_id=$atleta_id";
       
        $result = mysql_query($sql);
        $rsAtleta = mysql_fetch_array($result);
        $empresa_id=$rsAtleta['empresa_id'];
        
        
        //Controlamos la fecha de fin de torneo para filtrar solo los los afiliados
        //de la asociacion que estan afiliados al servicio
        $date_hoy = date_create(); // fecha del servidor 
        $fecha_hoy = date_timestamp_get($date_hoy);
        $date_new = date_create($fecha_fin_torneo);
        date_sub($date_new,date_interval_create_from_date_string("30  days"));
        $fechaFinTorneo=  date_timestamp_get($date_new);
        
        //Evaluamos la fecha para cuando ya haya pasado mas de 30 dias de finalizado el torneo
        //Se puede mostrar todos los inscritos exceptos otras asociaciones
        if ($fechaFinTorneo< $fecha_hoy){
            if ($torneo_empresa_id==$empresa_id){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        if ($rsAtleta){
           
            $afiliacion_id=Afiliacion_Anual($empresa_id);   
           
            $result = mysql_query($sql);
            $rsAfiliados = mysql_fetch_array($result);
            $sql = "SELECT pagado FROM afiliaciones WHERE  atleta_id=$atleta_id && afiliacion_id=$afiliacion_id";

            $result = mysql_query($sql);
            $rsAfiliados = mysql_fetch_array($result);

            if ($rsAfiliados['pagado']>0){
                $habilitado= TRUE; //Habilitado para salir en el listado
            }else{
                $habilitado= FALSE; //Habilitado para imprimir o enviar correo
            }
           
        }else{
            
            $habilitado=FALSE;
            
        }
        
        return $habilitado;
        

        

}
//Funcion nos devuelve que afiliacion esta vigente
function Afiliacion_Anual($empresa_id) {
    
     //Verificamos pago de afiliacion
    
        $sql = "SELECT * FROM afiliacion WHERE fecha_desde < Now() && fecha_hasta>Now() && empresa_id=" . $empresa_id ;
        
        

        $result = mysql_query($sql);
        $rsAfiliacion = mysql_fetch_array($result);
        
        if ($result){
            return $rsAfiliacion['afiliacion_id'];
        }else{
            return 0;
            
        }
  
}

function Afiliado($atleta_id,$afiliado) {
       
       //En caso del superusuario devuelve el listado completo de inscritos
       //Incluyendo a otras asociaciones y no afiliados
       if ($_SESSION['niveluser']>0 || $afiliado>0){
           return TRUE;
       }else{
           
           return FALSE;
           
       }
 
}


