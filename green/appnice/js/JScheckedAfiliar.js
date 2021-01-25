function JSCheckedAfiliar( ) {
    
    //Obtenemos id del elemento marcado
    var Id = $(this).attr( "id" );
    var chkimprime=Id.substr(0,3);
    
    var url="afiliacionchange.php";
    
       
      
    //Obtenemos operador logico true o falso del checkbox
    var chkOperacion = $("#"+Id).is(':checked') ? 1: 0;  
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
  //$("[id=my-Address]");
   
   
   var ano_afi =$("#ano").val();
   var monto_fvt =$("#fvt").val();
   var monto_aso =$("#aso").val();
   var monto_sis =$("#sis").val();
   //alert('monto fvt : '+ monto_fvt +'  asociacion:' + monto_aso +' Sistema:' +monto_sis);  
   if (Id.substr(0,3)!='btn'){
        $.ajax({
        method: "POST",
        url: url, 
        data: { id:Id, 
            chkOperacion:chkOperacion,
            montofvt:monto_fvt, 
            montoaso:monto_aso, 
            montosis:monto_sis, 
            anoafi:ano_afi}
        })
        .done(function( msg ) {
//            if(chkOperacion){
//                $("#data"+Id).css("background", "orange");
//            }else{
//                $("#data"+Id).css("background", "#DEDEDE");
//            }
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
$( "input[type=checkbox]" ).on( "click", JSCheckedAfiliar);


