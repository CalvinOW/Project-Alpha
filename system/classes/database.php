<?php
  
    error_reporting(1); 

    $hostname = "localhost";
    $database = "";
    $user = "";
    $password = "";

  //  $db = mysqli_connect($hostname,$user,$password,$database) or die("Verbinding mislukt!");

try {
  $db=new PDO("mysql:host={$hostname};dbname={$database}",$user,$password);
} catch(PDOEXCEPTION $e) {
  $e->getMessage();
}
