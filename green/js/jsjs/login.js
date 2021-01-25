$(document).ready(function (){

    $('#login-form').on('submit',function(e){
      $("#myerrors").removeClass("alert alert-danger");
      $('#myerrors').html("");    
      var data = $("#login-form").serialize();
      $.ajax({
          url: "login_submit.php",
          type: "POST",
          data:data,
          success : function( data)
          {
            if (data.Success){
              location.href ="appnice/sesion_usuario.php";
            }else{
              $("#myerrors").addClass("alert alert-danger");
              $('#myerrors').html(data.msg);
        
            }
          }
      })
      return false;
    })
  
});
  