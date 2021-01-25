
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
   
