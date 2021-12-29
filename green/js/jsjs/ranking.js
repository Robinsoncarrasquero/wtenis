
$(document).ready(function(){
  $( "#SexoM" ).click();
  

})  

$("#SexoF,#SexoM").click(function(e){
    sexo = $(this).attr('id');   
    var categoria = $("#cmbcategoria").val();   
    $.ajax({
        method: "POST",
        url: "appnice/ARankingNacional/Ranking_Ultimo.php", 
        data:  {categoria:categoria,sexo:sexo,pagina:0}
        })
        .done(function( data) {
        //   $('#mensaje').removeClass('loader');
            $('#results').html(data.html);
            $('#score-view-all').html(data.pagination);
           
        });
});
$('#score-view-all').on('click','.page-link',function(e)  {
    e.preventDefault();
    var categoria = $("#cmbcategoria").val();   
    var page = $(this).attr('data-id');
    $.ajax({
        method: "POST",
        url: "appnice/ARankingNacional/Ranking_Ultimo.php", 
        data:  {categoria:categoria,sexo:sexo,pagina:page}
    })
    .done(function( data) {
        $('#results').html(data.html);
        $('#score-view-all').html(data.pagination);
        
    });
                  
});


    //Ranking detallado
    $("#myModal").on('show.bs.modal', function(e){   
           
        var button = $(e.relatedTarget); // Button that triggered the modal
        var rkid = button.data('whatever'); // Extract info from data-* attributes
        var id = button.data('id'); // Extract info from data-* attributes
        
        
        $.ajax({
        method: "POST",
        url: "RankingDetail.php", 
        data: {rkid:rkid,id:id}
        })
        .done(function( data) {
                //console.log(data.html);
            if (!data.html) return e.preventDefault(); // stops modal from being shown
            $('#header').html(data.Nombre);
            $('#puntos').html(data.Puntos);
            $('#detail').html(data.html);
        });
                    
    });               
  

   
