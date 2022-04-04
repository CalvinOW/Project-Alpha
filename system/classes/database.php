<?php
  
    error_reporting(1); 

    $hostname = "localhost";
    $database = "";
    $user = "";
    $password = "";

try {
  $db=new PDO("mysql:host={$hostname};dbname={$database}",$user,$password);
} catch(PDOEXCEPTION $e) {
  $e->getMessage();
}