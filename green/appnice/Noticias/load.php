<?php


    echo "llego";
    die();
    
    if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                
                $filename = $name . '.' . $ext[1];
                echo 'file name :' . $filename;//change this URL
                $destination = '../Archivos/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo 'http://localhost:84/tenis/app/Arhivos/' . $filename;//change this URL
            }
            else
            {
              echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }

?>