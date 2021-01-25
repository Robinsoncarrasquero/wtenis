<?php
require 'vendor/autoload.php'; //Carga las librerias que instalaste con composer
use RedBeanPHP\R as r; //Genera un alias para redbean
$faker = Faker\Factory::create(); //Crea un objeto para generar los datos aleatorios
//Conexión a la base de datos: cambia demobd al nombre de tu base de datos
//cambia root por el usuario de tu base datos
//cambia las comillas vacias, por la clave para la base de datos
r::setup('mysql:host=localhost;dbname=atletasdb', 'root', '');
// for ($i=0; $i < 5; $i++) {
//   $post = r::dispense('name'); //Nombre de la tabla (post)
//    //Ahora llenas cada campo de tu tabla, por ejemplo 'title', 'content', etc
//   $post['nombre'] = $faker->firstName($maxNbChars = 50);
//   $post['apellido'] = $faker->lastName($maxNbChars = 50);
//   //$post['status'] = $faker->randomElement($array = array ('borrador','publicado'));
//   //$post['fechaCreacion'] = $faker->dateTime($max = 'now', $timezone = null);
//   r::store($post); //Guardar registro en base de datos
//   r::exec('UPDATE atleta SET nombres ="'.strtoupper($post['nombre']).'", apellidos="'.strtoupper($post['apellido']).'" WHERE atleta_id ='.$i);
// }


$atleta = r::getAll( 'SELECT *  FROM atleta' );
 
r::exec('TRUNCATE TABLE name');
foreach($atleta as $record){
   $post = r::dispense('name'); //Nombre de la tabla (post)
    //Ahora llenas cada campo de tu tabla, por ejemplo 'title', 'content', etc
   $id=$record["atleta_id"];
   $post['nombre'] =strtoupper($faker->firstName($maxNbChars = 50));
   $post['apellido'] =strtoupper($faker->lastName($maxNbChars = 50));
   $post['atleta_id'] = $id;
   //$post['status'] = $faker->randomElement($array = array ('borrador','publicado'));
   //$post['fechaCreacion'] = $faker->dateTime($max = 'now', $timezone = null);
   r::store($post); //Guardar registro en base de datos
  // r::exec('UPDATE atleta SET nombres ="'.$nombre.'", apellidos="'.$apellido.'" WHERE atleta_id ='.$id);
   //var_dump($id);
   
}


$empresa = r::getAll( 'SELECT *  FROM empresa' );
 
r::exec('TRUNCATE TABLE name');
foreach($empresa as $record){
   $post = r::dispense('name'); //Nombre de la tabla (post)
    //Ahora llenas cada campo de tu tabla, por ejemplo 'title', 'content', etc
   $id=$record["empresa_id"];
   $post['nombre'] =strtoupper($faker->firstName($maxNbChars = 50));
   $post['apellido'] =strtoupper($faker->lastName($maxNbChars = 50));
   $post['atleta_id'] = $id;
   //$post['status'] = $faker->randomElement($array = array ('borrador','publicado'));
   //$post['fechaCreacion'] = $faker->dateTime($max = 'now', $timezone = null);
   r::store($post); //Guardar registro en base de datos
  // r::exec('UPDATE atleta SET nombres ="'.$nombre.'", apellidos="'.$apellido.'" WHERE atleta_id ='.$id);
   //var_dump($id);
   
}
?>
