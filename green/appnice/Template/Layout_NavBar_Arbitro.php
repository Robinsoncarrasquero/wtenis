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
                echo '<a id="navbar-brand-panel-admin" class="navbar-brand glyphicon glyphicon-home" href="../bsindex.php?s1='.$_SESSION['asociacion'].'"></a>';
   
        echo '</div>';
        //Opciones en el dispositivo 
        echo '
        <div class="collapse navbar-collapse navbar-menu-collapse">';
                echo '
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                          <li><a href="../Torneo/bsTorneo_Read.php" >Torneos</a></li>
                          <li><a href="../Logout.php" class="glyphicon glyphicon-log-out"></a></li>
                        </ul>
                    </li>
                </ul> ';
            
             
            
          
        echo '
        </div><!--/.nav-collapse -->
    
         
    </nav>
   
   
    </header>';
       
        
    