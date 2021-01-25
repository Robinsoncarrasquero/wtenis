<?php
require_once '../clases/Bootstrap_Class_cls.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author robinson
 */
class Bootstrap {
    //put your code here
    
    public static function breadCrum(array $arrayNiveles){
        $str=''
            
            . '<ol class="breadcrumb ">';
         
    
        foreach ($arrayNiveles as $key => $value) {
            if ($value['clase']=='active'){
                $str .='<li class="'.$value['clase'].'">'.  Bootstrap_Class::badge(($value['titulo'])).'</li>';
            }else{
                $str .='<li><a href="'.$value['url'].'">'.$value['titulo'].'</a></li>';
            }
        }
        $str .='<li><a class="glyphicon glyphicon-log-out" href="../Logout.php"></a></li>';
        $str .='</ol>';
        
        return $str;
    }
    
    
    public static function breadCrum_HomePage(array $arrayNiveles){
        $str=''
            
            . '<ol class="breadcrumb ">';
         
    
        foreach ($arrayNiveles as $key => $value) {
            if ($value['clase']=='active'){
                $str .='<li class="'.$value['clase'].'">'.  Bootstrap_Class::badge(($value['titulo'])).'</li>';
            }else{
                $str .='<li><a href="'.$value['url'].'">'.$value['titulo'].'</a></li>';
            }
        }
        
        $str .='</ol>';
        
        return $str;
    }
    public static function breadCrumTorneos(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li class="active">'.Bootstrap_Class::badge("Torneos").'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        return $strbc;
    }
    
      
    public static function breadCrumTorneosPuntuacion(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li><a href="../Torneo/bsTorneo_Read.php">Torneos</a></li>
        <li class="active">'.Bootstrap_Class::badge("Puntuacion").'</a></li>';
         $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
       
        return $strbc;
    }
    public static function breadCrumDraw(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li><a href="../Draw/TorneoCreaDrawMenu.php">Torneos</a></li>
        <li class="active">'.Bootstrap_Class::badge("Draw").'</a></li>';
         $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    public static function breadCrumNoticias(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
         <li class="active">'.Bootstrap_Class::badge("Noticias").'</a></li>';
         $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
       
        return $strbc;
    }
    
    public static function breadCrumConfiguracion(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
         <li class="active">'.Bootstrap_Class::badge("Configuracion").'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    
    public static function breadCrumConstancias(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li class="active">'.Bootstrap_Class::badge("Constancia").'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    
     public static function breadCrumFotosPortal(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li class="active">'.Bootstrap_Class::badge("Subir Fotos al Portal").'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    
    public static function breadCrumFotosGaleria(){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
        <li class="active">'.Bootstrap_Class::badge("Subir Fotos a Galeria").'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    
    public static function breadCrumInicio($titulo){
        $strbc='      
        <ol class="breadcrumb">
        <li><a href="../bsPanel.php">Inicio</a></li>
       <li class="active">'.Bootstrap_Class::badge($titulo).'</a></li>';
        $strbc .='<li><a  class="" href="../Logout.php">Cerrar</a></li>
        </ol>';
        
        return $strbc;
    }
    
        
    public static function html_email_head($title) {
        
    $head ='<!DOCTYPE html>
    <html lang="es">
    <head>
        <title>'.$title.'</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.css">

        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
                background-color: #4CAF50;
                color: white;
            }
            p{
            font-size:medium;color:blue;
            }
        </style>

    </head>';
   
    return $head;
    }
    
    //Genera un body para un correo basados en una tabla
    public static function html_email_body(array $thead) {
        
    //$thead son los encabezado de la tabla tipo th
    $strBody =
    '<body>
    <table class=3D"content" text-align cellspacing=3D"100" cellpadding=3D"0"
     border=3D"0" style=3D"padding-right:20px" tr:nth-child(even) {background-color: #f2f2f2} th {
        background-color:  #4CAF50;color: white;}>
        <thead >
            <tr>';
                
    foreach ($thead as $value){
        $strBody .='<th>'.$value.'</th>';
    }
    $strBody .=
            '</tr>
        </thead>
        <tbody>';
    
    return $strBody;
        
    }
    
    public static function Table_Head($arrayHead,$numeroregillas,$tablestriped,$tablebordered,$tablecondensed,$colorhead){
        $arrayTH=$arrayHead;
        foreach ($arrayTH as $key => $columna) {
            $thCol .='<th>'.$columna.'</th>';      
        }
        if ($numeroregillas==''){
            $nregillas=12;
        }else{
            $nregillas=$numeroregillas;
        }
        if($tablestriped){
           $tablestriped=' table-striped';
        }else{
            $tablestriped='';
        }
        if($tablebordered){
           $tablebordered=' table-bordered';
        }else{
            $tablebordered='';
        }
        if($tablecondensed){
           $tablecondensed=' table-condensed';
        }else{
            $tablecondensed='';
        }
        
        if($colorhead==''){
           $colorhead=' ';
       
        }
        
        $theadOPen='<div class="table-responsive  col-sx-'.$nregillas.'" >                    
                        <table class="table'. $tablestriped . $tablebordered . $tablecondensed.'">
                        <thead >
                        <tr class="table-head '.$colorhead.' ">';
         
        $theadClose =' </tr>
                            </thead> 
                            <tbody>';
        $TableHead= $theadOPen.$thCol.$theadClose;                 
        return $TableHead;
    }
    
    public static function Table_Detail($td,$color,$href){
        switch ($color) {
            case "active":
                $color="class='active'";

                break;
             case "success":
                $color="class='success'";

                break;
            case "warning":
                $color="class='warning'";

                break;
             case "danger":
                $color="class='danger'";
                
                break;
            
            default:
                 $color="";
                break;
        }
        if ($href!=''){
             $td="<td ".$color.'><a href="'.$href.'">'.$td."</a></td>";
        }else{
            $td="<td ".$color.'>'.$td."</td>";
        }
                
        return $td; 
    }
    
    public static function Table_Detail_tr_open($color){
       
        switch ($color) {
         case "active":
             $color="class='active'";

             break;
          case "success":
             $color="class='success'";

             break;
         case "warning":
             $color="class='warning'";

             break;
          case "danger":
             $color="class='danger'";

             break;

         default:
              $color="";
             break;
        } 
        
        $tr="<tr ".$color.'>';
        return $tr; 
    }
    
     
    public static function Table_Detail_tr_close(){
         $tr="</tr>";
                
        return $tr; 
    }
    
    public static function Table_Footer(){
                
       $footer ='</tbody>    
                        </table>
              </div>';
        return $footer;
    }
    

    public static function master_page() {
        
        if (file_exists("../".$_SESSION['url_logo'].'/logo.png')){
            $html_str ='
            <div class="col-xs-6">
               <img  src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img>
            </div>'
            
            .'<div class="col-xs-6">
               <h6 class="titulo-empresa">'.$_SESSION['empresa_nombre'].'</h6>'
            .'</div>'
            ;
            
        }else{
            $html_str ='
                 '
            .'<div class=" col-xs-6 ">'
            .'    <img  src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img>'
            . '</div>';
        }
        echo $html_str;
    
        
    }
    public static function encabezado_logo() {
        
        if (file_exists("../".$_SESSION['url_logo'].'/logo.png')){
            $html_str ='
            
            
            <!--<div class="col-xs-6 ">
               <a > <img  src="../'.$_SESSION['url_logo'].'/logo.png" class="img-responsive puss-left "></img></a>
            </div>-->'
            
            .'<div class="col-xs-6 ">
               <a > <img  src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>
            </div>
            ';
           
                    
                    
            
           
           
        }else{
            $html_str =' '
                
            .'<div class="col-xs-12">'
            .'   <a > <img  src="../images/logo/fvtlogo.png" class="img-responsive pull-left"></img></a>'
            . '</div>';
        }
        echo $html_str;
    
        
    }
    
     
}
