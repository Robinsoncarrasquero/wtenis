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
                echo '<a id="navbar-brand-panel-admin" class="navbar-brand glyphicon glyphicon-home" href="'.$_SESSION['home'].'"></a>';
   
        echo '</div>';
        //Opciones en el dispositivo 
        echo '
        <div class="collapse navbar-collapse navbar-menu-collapse">';
            
                
         
                echo '
                <ul class="nav navbar-nav">
       
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliados<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../Administrado/AdministradoAFI.php" >Administrado</a></li>
                            <li><a href="../Afiliados/AfiliadosAFI.php" >Afiliados</a></li>
                            <li><a href="../Atleta/atletaRead.php" >Atleta</a></li>
                            <li><a href="../Afiliacion/bsAfiliacionesFormalizacion.php">Formalizacion</a></li>';
                            if ($_SESSION['niveluser']>9){
                              echo ' <li><a href="../Afiliacion/bsAfiliacionesFederar.php">Formalizacion Federar</a></li>';
                              echo ' <li><a href="../Exportacion/ExportacionXML.php">Exportacion a XML</a></li>';
                            }
                            echo '
                        </ul>
                    </li>
                </ul>';
            
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuracion<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                         <!-- <li><a href="../SubirFotos/index.php" >Subir Fotos al Portal</a></li> -->
                          <li><a href="../Configurar/ConfigModal.php" >Configuracion</a></li>';
                            if ($_SESSION['niveluser']>9){
                              echo ' <li><a href="../Constancias/ConfigModal.php" >Constancia</a></li>';
                            }
                    echo '   
                      </ul>
                    </li>
                </ul>';
               
                //Gerencial
                if ($_SESSION['niveluser']>9){  
                echo ' 
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../AEstadisticas/AfiliacionesFederadas.php" >Afiliaciones Federadas</a></li>
                            <li><a href="../AEstadisticas/AfiliacionesEnTransito.php">Afiliaciones Transito</a></li>
                            <li><a href="../AEstadisticas/AfiliacionesEntidad.php" >Afiliaciones Entidad</a></li>
                        </ul>
                    </ul>';


                echo'    
                <ul class="nav navbar-nav">
       
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliacion<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../Afiliacion/AbrirAfiliacion.php" >Abrir nuevo periodo</a></li>
                      </ul>
                  </li>
                </ul>';
                
                
                }


                //Gerencial
                if ($_SESSION['niveluser']==9){  
                  echo ' 
                      <ul class="nav navbar-nav">
  
                          <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gerencial<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                              <li><a href="../AEstadisticas/AfiliacionesEntidad.php" >Afiliaciones Entidad</a></li>
                              
                          </ul>
                      </ul>';
                  
                  
                  }
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Noticias<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="../Noticias/NoticiasModal.php" >Noticias</a></li>
                      </ul>
                    </li>
                </ul>';
            
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Torneos<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="../Torneo/bsTorneo_Read.php" >Torneos</a></li>
        <!--                      <li><a href="../Draw/TorneoCreaDrawMenu.php">Draw</a></li>-->
                        </ul>
                    </li>
                </ul> ';
            
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ranking<span class="caret"></span></a>
                    <ul class="dropdown-menu">';
                    if ($_SESSION['niveluser']>9){
                        echo '<li><a href="../ARankingUpload/RankingAFI.php" >Actualizar Ranking</a></li>';
                    }
                    echo '<li><a  href="../ARankingNacional/RankingByDate.php">Consulta Ranking Por Fecha</a></li>'; 
                    echo '<li><a  href="../ARankingNacional/RankingByJugador.php">Consulta Ranking Individual</a></li>  
                    </ul>
                    </li>
                </ul>';
                
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
       
        
    