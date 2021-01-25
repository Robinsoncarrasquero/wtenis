$(document).ready(function(){
    $( "#SexoM" ).click();
  })  
  
  //$(document).on('click','.tab-links',function(e)  {
  $(".accordion").click(function(e){
      e.preventDefault();
      mes = $(this).attr('id');   
      $.ajax({
          method: "POST",
          url: "tournamentLoad.php", 
          data:  {mes:mes}

          })
          .done(function( data) {
          //   $('#mensaje').removeClass('loader');
              $('.results').html(data.html);
              
          });
  });
  