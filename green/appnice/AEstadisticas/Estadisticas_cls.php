<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadisticasCls
 *
 * @author robinson
 */
class EstadisticasCls {
    
    //Filtra por asociacion para obtener las formalizadas o federadas segun el parametro proceso
    public static function EmpresaAfiliadosPorEstado($disciplina,$afiliacion_id,$proceso=null) {
        
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        $strSQL = 'SELECT count(*) as total,empresa.estado as lestado from afiliacion,afiliaciones, empresa
            WHERE 
            afiliacion.afiliacion_id=:paramx and afiliacion.empresa_id=empresa.empresa_id
            and afiliacion.afiliacion_id=afiliaciones.afiliacion_id 
            and afiliaciones.modalidad=:disciplina '
            . $formalizar .' 
            
            GROUP BY lestado 
            ORDER BY lestado asc';
            
           
        return EstadisticasCls::SQL($strSQL, $disciplina, $afiliacion_id);
        
    }
    //Filtra por asociacion para obtener las formalizadas o federadas segun el parametro proceso
    public static function EmpresaAfiliadosPorCategoria($disciplina,$afiliacion_id,$proceso=null) {
        
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        $strSQL = 'SELECT count(*) as total,concat(afiliaciones.categoria,afiliaciones.sexo) as lestado 
            FROM afiliaciones,afiliacion,empresa
            WHERE 
            afiliacion.afiliacion_id=:paramx and afiliacion.empresa_id=empresa.empresa_id
            and afiliacion.afiliacion_id=afiliaciones.afiliacion_id 
            and afiliaciones.modalidad=:disciplina '
           
           . $formalizar .' 
            
            GROUP BY lestado 
            ORDER BY lestado asc';
            
                   
        return EstadisticasCls::SQL($strSQL, $disciplina, $afiliacion_id);
        
    }
    public static function GLBAfiliadosPorEstado($disciplina,$ano,$proceso=null) {
        
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        
        $strSQL = 'SELECT count(*) as total,atleta.estado as lestado from afiliacion,afiliaciones, atleta
            WHERE afiliacion.ano=:paramx
            and afiliaciones.afiliacion_id=afiliacion.afiliacion_id 
            and afiliaciones.atleta_id=atleta.atleta_id
            and afiliaciones.modalidad=:disciplina '
            . $formalizar .' 
            
            GROUP BY lestado 
            ORDER BY lestado asc';
            
        return EstadisticasCls::SQL($strSQL, $disciplina, $ano);
        
    }
    
    public static function GLBAfiliadosPorPais($disciplina,$ano,$proceso=null) {
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        
        $strSQL ='SELECT count(*) as total,nacionalidad.pais as lestado
            from afiliacion,afiliaciones, nacionalidad,atleta
            WHERE afiliacion.ano=:paramx
            and afiliacion.afiliacion_id=afiliaciones.afiliacion_id
            and afiliaciones.atleta_id=atleta.atleta_id
            and atleta.nacionalidad_id=nacionalidad.id
            and afiliaciones.modalidad=:disciplina '
            . $formalizar .' 
        
            GROUP BY lestado
            ORDER BY lestado ';
        
        return  EstadisticasCls::SQL($strSQL, $disciplina, $ano);
    
        
    }
    
    public static function GLBAfiliadosPorRegion($disciplina,$ano,$proceso=null) {
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        
        $strSQL ='SELECT count(*) as total,region.nombre as lestado
            from afiliacion,afiliaciones, empresa, region,atleta
            WHERE afiliacion.ano=:paramx
            and afiliacion.afiliacion_id=afiliaciones.afiliacion_id
            and afiliacion.empresa_id=empresa.empresa_id
            and empresa.idregion=region.id
            and afiliaciones.atleta_id=atleta.atleta_id
            and afiliaciones.modalidad=:disciplina '
            . $formalizar .' 
        
            GROUP BY lestado
            ORDER BY lestado ';
        
        return  EstadisticasCls::SQL($strSQL, $disciplina, $ano);
    
        
    }
    
    
    public static function GLBAfiliadosPorCategoria($disciplina,$ano,$proceso=null) {
        
        $formalizar= EstadisticasCls::filtroProceso($proceso);
        
        $strSQL ='SELECT count(*) as total,concat(afiliaciones.categoria,afiliaciones.sexo) as lestado
            FROM afiliacion,afiliaciones
            WHERE afiliacion.ano=:paramx
            and afiliaciones.afiliacion_id=afiliacion.afiliacion_id
            and afiliaciones.modalidad=:disciplina '
            . $formalizar .' 
        
            GROUP BY lestado
            ORDER BY lestado asc';

     return  EstadisticasCls::SQL($strSQL, $disciplina, $ano);    
    }
    
    
    //Funcion que unica que ejecuta la sentencia sql y devuelve la consulta
    private static function SQL($strSQL,$disciplina,$paramx) {
        
        $model = new Conexion;
        $conn=$model->conectar();
        $SQL = $conn->prepare($strSQL);
        $SQL->bindParam(':disciplina', $disciplina);
        $SQL->bindParam(':paramx', $paramx);
        $SQL->execute();
        $records = $SQL->fetchall();
        if ($SQL->rowCount() == 0) {
            $SQLresultado_exitoso = FALSE;
            $errorCode = $conn->errorCode();
            $errorInfo = $conn->errorInfo();
            $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
            switch ($errorCode) {
                case 00000:
                    $mensaje = "ERROR Numero" . $errorCode;
                    break;
                default:
                    $mensaje = "ERROR No se encontraron registros.." . $errorInfo;
                    break;
            }
        } else {
            $mensaje = "Registro Encontrado con exito";
        
            $SQLresultado_exitoso = TRUE;
        }

        $conn = NULL;

        return $records;
    }
    public static function filtroProceso($proceso){
        switch ($proceso) {
            //Afiliaciones Solicitadas 
            case 'sol':
                $WHERE= ' and afiliaciones.aceptar>0 '; 
                break;
            //Afiliaciones Formalizadas no federadas(transito)
            case 'tra':
                $WHERE=" and afiliaciones.formalizacion>0 and afiliaciones.pagado!=1  ";
                break;
            //Afiliaciones Federadas
            default:
                $WHERE= ' and afiliaciones.pagado>0 '; 
                break;
        }
        return $WHERE;
    }


}
