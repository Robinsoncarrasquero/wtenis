<!DOCTYPE html>
<html lang="es">
    
    
    <head>
        <title>Jugando con jq</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        
        
    </head>
    <body>
        
        
    <script>
        
    $(document).ready(function(){  
     //objetos_namespace();
     //determinar_el_tipo();   
     //funcion_nombrada();   
     //crearObjeto();
     //arreglos();
     //swiches();
     //Arreglos
     
     clausuras();
     //Funciones y clausuras
     function clausuras(){
         
         /* solución: "clausurar" el valor de i dentro de createFunction */
        var createFunction = function(i) {
            return function() { alert(i); };
        };

        for (var i=0; i<5; i++) {
            $('<p>hacer click</p>').appendTo('body').click(createFunction(i));
        }

     }
     
     //Alcance en funciones con namespace
     function objetos_namespace(){
         
        var myNamespace = {
            myObject : {
                sayHello : function() {
                    alert('Hola, mi nombre es ' + this.myName);
                },
                myName : 'Rebecca'
            }
        };

        var obj = myNamespace.myObject;
        obj.sayHello();  // registra 'Hola, mi nombre es Rebecca'

     }
     function arreglos(){
        var myArray = [ 'h', 'e', 'l', 'l', 'o' ];
        var myString = myArray.join('');   // 'hello'
        var mySplit = myString.split('');  // [ 'h', 'e', 'l', 'l', 'o' ]
        var myArray = [ 'h', 'e', 'l', 'l', 'o' ];
        var myString = myArray.join('');   // 'hello'
        var mySplit = myString.split('');  // [ 'h', 'e', 'l', 'l', 'o' ]
        alert(myString);
    }
    
    function determinar_el_tipo(){
            var myFunction = function() {
                console.log('hello');
            };

            var myObject = {
                foo : 'bar'
            };

            var myArray = [ 'a', 'b', 'c' ];
            var myString = 'hello';
            var myNumber = 3;

            typeof myFunction;  // devuelve 'function'
            typeof myObject;    // devuelve 'object'
            typeof myArray;     // devuelve 'object' -- tenga cuidado
            typeof myString;    // devuelve 'string'
            typeof myNumber;    // devuelve 'number'
            typeof null;        // devuelve 'object' -- tenga cuidado
            
            if (myArray.push && myArray.slice && myArray.join) {
                // probablemente sea un array
                // (este estilo es llamado, en inglés, "duck typing")
                alert("Esto parece una array pero no estamos seguros mister duck typing");
            }

            if (Object.prototype.toString.call(myArray) === '[object Array]') {
                // definitivamente es un array;
                // esta es considerada la forma más robusta
                // de determinar si un valor es un array.
                alert("es un array realmente seguro");
            }
    }
    
    //Funcion nombrada
    function funcion_nombrada(){
        
        var myFn = function(fn){
            
            var result = fn();
            alert(result);
        };
        
        var myOtherFun = function(){
            var x= 3*6;
            return "HELLO WORD "+x;
        };
        myFn(myOtherFun);
        
        
    }
    //Crear un objeto
    function crearObjeto(){
        
    var myObject = {
        sayHello : function() {
            console.log('hello');
            return "Hello";
        },
        myName : 'Rebecca'
    };

    // se llama al método sayHello, el cual muestra en la consola 'hello'
    myObject.sayHello();

    // se llama a la propiedad myName, la cual muestra en la consola 'Rebecca'
    alert("MY NAMES IS "+myObject.myName);

    alert(myObject.sayHello());
    }
     
     //Creacion de objetos tipo swiches sin usar el switch literal
     function swiches(){
            var footodo  ={

                'good': function(){
                    alert("aqui es good");
                },

                'bad': function(){
                    alert("aqui es bad");
                },

                'default' : function(){
                    alert("default");
                }

            };
            
           footodo.bad();

//            var foo="";
//            if (footodo[foo]){
//                footodo[foo]();
//            }else{
//                footodo['default']();
//            }
            
    }
    
    
                
   

            
        var myArray = [ 1, 2, 3, 5, 4 ];
        if ($.inArray(4, myArray) !== -1) {
            console.log('valor encontrado');
        }else{
            console.log('valor no encontrado');
        }
    });
    </script>
        
    </body>
</html>

