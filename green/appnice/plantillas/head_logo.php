<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_SESSION['url_logo'])){
    $imgg =$_SESSION['url_logo']."/logo.jpg";
    
}  else {
    
    $imgg ="images/".$_SESSION['asociacion']."/logo.jpg";
    
    
}

//print_r($imgg);
?>
<a href="sesion_usuario.php"> <img id="Logo" src="<?php echo $imgg?>" width="200"></a>
<link rel="StyleSheet" href="css/inscribe.css" type="text/css">

