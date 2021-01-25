
$(document).ready(function(){
    var id=$("#token_id").text();
    $("#mensaje").html('');
    $('#mensaje').addClass('loader');
    $("#results").html('');
    $.ajax({
        method: "POST",
        url: "MyTournament.php", 
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
       $('#mensaje').removeClass('loader');
       $('#results').html(data.html);
       $('#paginacion').html(data.pagination);
       
    });
    //Paginando Torneos
    $(document).on('click','.page-link',function(e)  {
        var page = $(this).attr('data-id');
        
        $.ajax({
            method: "POST",
            url: "MyTournament.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
          });
                  
    });
    //Cargamos el icono de ajaxloader y la lista de personas
    //readRecords();
    
    //Link de documentos a visualizar
    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        var url = $(this).attr('href');
        var target = $(this).attr('target');
        if(url) {
            // # open in new window if "_blank" used
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }          
    });
   
    
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });

});
