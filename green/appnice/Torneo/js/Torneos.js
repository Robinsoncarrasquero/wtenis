
//Regresar 
$("#btn-back,#Logo").click(function(){
        window.history.back()();
});

function Resetear(){
  url='laurl.html';
  var target =$(this).attr('target');       
  if(target ==='_blank') { 
       window.open(url, target);
  } else {
      window.history.back();
  }
}
//Regargar
$("#recargarPage").click(function(){
  location.reload(); 
})
