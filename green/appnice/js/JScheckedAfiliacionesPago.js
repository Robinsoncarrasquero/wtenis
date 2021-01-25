function JSCheckedPagado( ) {
    
    //Obtenemos id del elemento marcado
    var Id = $(this).attr( "id" );
    var url="afiliacionesconciliadaschk.php";
    
    alert ('dato'+Id);
    //Obtenemos operador logico true o falso del checkbox
    var chkPago = $("#"+Id).is(':checked') ? 1: 0;  
    if($("#"+Id).is(':checked')) {  
        //alert('Esta activado : '+Id +'  ES:' +chkPago);  
        //console.log('Esta activado'+Id);
    } else {  
        //alert('Desactivado : '+Id +'  ES:' +chkPago);  
         
        // $('#btnImp').attr("disabled", false);
//        $('#btnImp').click(function(e){
//            //e.preventDefault();
//            $("a").attr('href',' '.Id);
//        });

        
        
    }  
    //Disparamos un ajax para actualizar el estatus del elemento
   
    
   
   if (Id.substr(0,3)!='btn'){
        $.ajax({
        method: "POST",
        url: url, 
        data: { id:Id, chkPago: chkPago }
        })
        .done(function( msg ) {
            
            if(chkPago){
                $("#data"+Id).css("background", "#fff000");
            }else{
                $("#data"+Id).css("background", "#DEDEDE");
            }
            alert( "Afiliacion :"+msg );
            
        })
        .fail(function( xhr, status, errorThrown ) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
        });
    }     
    
}
$( "input[type=checkbox]" ).on( "click", JSCheckedPagado);


