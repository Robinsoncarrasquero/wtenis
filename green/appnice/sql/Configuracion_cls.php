<?php
define('WTENIS_FILE_CONFIG',dirname(__FILE__,4).'/.env');

class Configuracion
{
    public $servername;
    public $username ;
    public $password;
    public $dbname;
    public $dbms;
    public $port;
    
    public function __construct() {

        if (file_exists(WTENIS_FILE_CONFIG)) {
            $archivo = (WTENIS_FILE_CONFIG);
        }else{
            $archivo = ('');
            trigger_error("No se puede encontrar un archivo de configuracion");
            exit;
        }
        
        $contenido = parse_ini_file($archivo, false);
        $this->servername = $contenido["SERVERNAME"];
        $this->username = $contenido["USERNAME"];
        $this->password = $contenido["PASSWORD"];
        $this->dbname = $contenido["DBNAME"];
        $this->dbms = $contenido["DBMS"];
        $this->port = $contenido["PORT"];

        
    }

    //Returna un array con la configuracion de SMTP
    public function SMTP()
    {

        if (file_exists(WTENIS_FILE_CONFIG)) {
            $archivo = (WTENIS_FILE_CONFIG);
        }else{
            $archivo = ('');
            trigger_error("No se puede encontrar un archivo de configuracion");
            exit;
        }

        $contenido = parse_ini_file($archivo, false);
        
        $SMTP =
        [
        'SMTP_HOST'=>$contenido["SMTP_HOST"],
        'SMTP_SMTPAUTH'=>$contenido["SMTP_SMTPAUTH"],
        'SMTP_USERNAME'=> $contenido["SMTP_USERNAME"],
        'SMTP_PASSWORD'=> $contenido["SMTP_PASSWORD"],
        'SMTP_SECURE'=> $contenido["SMTP_SECURE"],
        'SMTP_PORT'=>$contenido["SMTP_PORT"],
        ];
        return $SMTP;
        
    
    }
        
}


?>