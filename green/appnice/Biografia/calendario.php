<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/Normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<style>
   
* {box-sizing: border-box;}
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;}

.month {
    padding: 70px 25px;
    width: 100%;
    background: #1abc9c;
    text-align: center;
}

.month ul {
    margin: 0;
    padding: 0;
}

.month ul li {
    color: white;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.month .prev {
    float: left;
    padding-top: 10px;
}

.month .next {
    float: right;
    padding-top: 10px;
}

.weekdays {
    margin: 0;
    padding: 10px 0;
    background-color: #ddd;
}

.weekdays li {
    display: inline-block;
    width: 13.6%;
    color: #666;
    text-align: center;
}

.days {
    padding: 10px 0;
    background: #eee;
    margin: 0;
}

.days li {
    list-style-type: none;
    display: inline-block;
    width: 13.6%;
    text-align: center;
    margin-bottom: 5px;
    font-size:12px;
    color: #777;
}

.days li .active {
    padding: 5px;
    background: #1abc9c;
    color: white !important
}

/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
    .weekdays li, .days li {width: 13.1%;}
}

@media screen and (max-width: 420px) {
    .weekdays li, .days li {width: 12.5%;}
    .days li .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
    .weekdays li, .days li {width: 12.2%;}
}
</style>
</head>

<body>

<div class="container-fluid">
    <div class="row-fluid col-xs-4">
    <h1>CSS Calendar</h1>
    <ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>
</ul>
    <div class="month">      
      <ul>
        <li class="prev">&#10094;</li>
        <li class="next">&#10095;</li>
        <li>
          August<br>
          <span style="font-size:18px">2017</span>
        </li>
      </ul>
    </div>

    <ul class="weekdays">
      <li>Mo</li>
      <li>Tu</li>
      <li>We</li>
      <li>Th</li>
      <li>Fr</li>
      <li>Sa</li>
      <li>Su</li>
    </ul>

    <ul class="days">  
      <li>1</li>
      <li>2</li>
      <li>3</li>
      <li>4</li>
      <li>5</li>
      <li>6</li>
      <li>7</li>
      <li>8</li>
      <li>9</li>
      <li><span class="active">10</span></li>
      <li>11</li>
      <li>12</li>
      <li>13</li>
      <li>14</li>
      <li>15</li>
      <li>16</li>
      <li>17</li>
      <li>18</li>
      <li>19</li>
      <li>20</li>
      <li>21</li>
      <li>22</li>
      <li>23</li>
      <li>24</li>
      <li>25</li>
      <li>26</li>
      <li>27</li>
      <li>28</li>
      <li>29</li>
      <li>30</li>
      <li>31</li>
    </ul>
    </div>
    
    <!-- POST-FIJO 2
            <!-- Section de Calendario de Torneos -->
            <h4 >CALENDARIO</h4>
           
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="active"><a href="#"   class="edit-record" >Ene<span class="badge"></span></a></li>
                <li role="presentation" class="active"><a href="#"   class="edit-record" >Feb<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Mar<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record>">Abr<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >May<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Jun<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Jul<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Ago<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Sep<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Oct<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Nov<span class="badge"></span></a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Dic<span class="badge"></span></a></li>
            </ul>
            
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">Home</a></li>
                <li role="presentation"><a href="#"class="edit-record" >Ene<span class="badge"></span></a></li>
                 <li role="presentation"><a href="#"   class="edit-record" >Feb<span class="badge"></span></a></li>
            </ul>
           

            
            <div class="calendario">
            
            </div>
            
            <!-- FIN DE CALENDARIO-->
</div>
    
    
</body>


          
            
            
       
        
</html>
