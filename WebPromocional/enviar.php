<?php
    $name= $_POST['name'];
    $email= $_POST['email'];
    $message= $_POST['message'];

    //echo $name. "ha dicho:</br>".$message;

   if (mail('negocioslocales01@gmail.com','De: '.$name, $message, $email)){
       echo "Mensaje Enviado";
   }else{
       echo "ha Ocurrido un Error";
   }
?>