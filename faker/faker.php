<?php
require '../vendor/autoload.php';


// require 'rb.php';
//require 'vendor/autoload.php'; //Carga las librerias que instalaste con composer
use RedBeanPHP\R as r; //Genera un alias para redbean

error_reporting(1);

$faker = Faker\Factory::create(); //Crea un objeto para generar los datos aleatorios
//Conexión a la base de datos: cambia demobd al nombre de tu base de datos
//cambia root por el usuario de tu base datos
//cambia las comillas vacias, por la clave para la base de datos
$r=r::setup('mysql:host=localhost;dbname=atletasdb', 'root', '');
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


$atletas = r::getAll( 'SELECT *  FROM atleta' );
 
//r::exec('TRUNCATE TABLE name');
foreach($atletas as $record){
   
   $post = r::dispense('name'); //Nombre de la tabla (post)
   //echo $post['nombre'];

    //Ahora llenas cada campo de tu tabla, por ejemplo 'title', 'content', etc
   $id=$record["atleta_id"];
   // $post['nombre'] =$faker->firstName($maxNbChars = 50);
   // $post['apellido'] =$faker->lastName($maxNbChars = 50);
   // $post['email'] ='atenismiranda@gmail.com';
   // $post['contrasena'] ='secret1234';
   // $post['telefonos'] ='584122606283';
   // $post['cedula'] = $id;
   // r::store($post); //Guardar registro en base de datos
   // r::exec('UPDATE atleta SET cedula ="'.$id.'",telefonos ="'.$post['telefonos'].'",contrasena ="'.$post['contrasena'].'",email ="'.$post['email'].'",nombres ="'.$post['nombre'].'", apellidos="'.$post['apellido'].'" WHERE atleta_id ='.$id);
  
   $nombre =$faker->firstName($maxNbChars = 50);
   $apellido =$faker->lastName($maxNbChars = 50);
   $nombrerep =$faker->name($maxNbChars = 50);
   $cedularep =$faker->ssn();
   $direccion =$faker->address();
   $lugartrabajo=$faker->address();
   $lugarnac=$faker->address();
   $email ='atenismiranda@gmail.com';
   $contrasena ='secret1234';
   $telefonos ='584122606283';
   $celular=$faker->e164PhoneNumber();
   $cedula = $id;
   
   if ($record["niveluser"]<1){
      echo $direccion." ".$cedularep. " ".$celular."--->".$record['niveluser'];
      echo '<br>';
      r::exec('UPDATE atleta SET lugartrabajo="'.$lugartrabajo.'",nombrerep="'.$nombrerep.'",celular="'.$celular.'",cedularep="'.$cedularep.'",direccion="'.$direccion.'",cedula ="'.$id.'",telefonos ="'.$telefonos.'",contrasena ="'.$contrasena.'",email ="'.$email.'",nombres ="'.$nombre.'", apellidos="'.$apellido.'" WHERE atleta_id ='.$id);
   }
  
}
die('listo');
exit;
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
