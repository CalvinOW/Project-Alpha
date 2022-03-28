<?php
  
    error_reporting(1); 

    $hostname = "localhost";
    $database = "ilpxqbjr_database";
    $user = "ilpxqbjr_database";
    $password = "Cw32145@!";

  //  $db = mysqli_connect($hostname,$user,$password,$database) or die("Verbinding mislukt!");

try {
  $db=new PDO("mysql:host={$hostname};dbname={$database}",$user,$password);
} catch(PDOEXCEPTION $e) {
  $e->getMessage();
}