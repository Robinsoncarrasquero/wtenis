<?php

echo "<header>";
     
/*
 <!--    <div class="alert alert-danger alert-server" role="alert">
 
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Moving Servers</strong>Update finish in the new server. This move should be finished on 12/2019.
</div>-->
 
 */
    echo 
    '<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container-fluid">';
        echo '<div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-menu-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>';
                echo '<a id="navbar-brand-panel-user" class="navbar-brand glyphicon glyphicon-home" href="../bsindex.php?s1='.$_SESSION['asociacion'].'"></a>';
            
        echo '</div>';
        //Opciones en el dispositivo 
        echo '
        <div class="collapse navbar-collapse navbar-menu-collapse">';
                            
                if ($_SESSION['niveluser']>9){  
                echo ' 
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../AEstadisticas/AfiliacionesFederadas.php" >Afiliaciones Federadas</a></li>
                            <li><a href="../AEstadisticas/AfiliacionesEnTransito.php">Afiliaciones Transito</a></li>
                                                   </ul>
                    </ul>';
                
                echo ' 
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliaciones<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../Afiliacion/ConsultaAfiliacionesFederadas.php" >Consulta Afiliaciones</a></li>
                        </ul>
                    </ul>';
                }
                echo '
                    <ul class="nav navbar-nav navbar-right">

                       <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acceso<span class="caret"></span></a>
                         <ul class="dropdown-menu">';

                           if (isset($_SESSION['logueado']) and $_SESSION['logueado']){
                                echo ' <li><a href="../sesion_cerrar.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar</a></li>';
                           }else{
                                echo '<li><a href="../Login.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>';
                           }
                       echo '   
                         </ul>
                       </li>
                   </ul>';
             
            
          
        echo '
        </div><!--/.nav-collapse -->
    
         
    </nav>
   
   
    </header>';

