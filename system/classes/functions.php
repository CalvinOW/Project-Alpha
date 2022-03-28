<?php

require_once ("database.php");  

function export_site_title() {
  error_reporting(E_ALL);
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  global $e;
  
  $query = $db->prepare("SELECT value FROM website_settings WHERE name='naam'");
  $query->execute();
  $result = $query->fetch();
  echo $result["value"];
  
}

function echo_page_name() {
  echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
}

function export_site_logo() {

  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $query = $db->prepare("SELECT * FROM website_settings WHERE name='logo'");
  $query->execute();
  $result = $query->fetch();
  echo $result["value"];
  
}

function export_version() {

  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
    
  $query = $db->prepare("SELECT * FROM website_settings WHERE name='version'");
  $query->execute();
  $result = $query->fetch();
  echo $result["value"];

}

function update_last_ip() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $email = $_SESSION['email'];  
  $stmt = $db->prepare("UPDATE users SET last_ip =  ? WHERE email = ?");
  $stmt->execute(array($_SERVER['REMOTE_ADDR'], $email));
  
}

function user_last_ip() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $user_id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM activity_log WHERE user_id=$user_id GROUP BY id DESC LIMIT 1,1");
  $query->execute();
  $result = $query->fetch();
  echo $result["time"];
  
}

function validate() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $time = date("Y-m-d H:i:s");
  $ip = $_SERVER['REMOTE_ADDR'];
  $query = "INSERT INTO activity_log (user_id, last_ip, time) VALUES (?,?,?)";
  $statement = $db->prepare($query);
  $statement->execute([$_SESSION['id'], $ip, $time]);
  header('location: /dash/main');
  
}

function user_avatar() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM users WHERE id=$id");
  $query->execute();
  $result = $query->fetch();
  echo $result["avatar"];
  
}

if(isset($_POST['inloggen']))
{
	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
	{
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
      session_start();      
      
      $sql = "select * from users where email = :email ";
			$handle = $db->prepare($sql);
			$params = [':email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0)
			{
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $getRow['password']))
				{
					unset($getRow['password']);
					$_SESSION = $getRow;
					header('location: /dash/validate');
					exit();
				}
				else
				{
					$errors[] = "Verkeerde email of wachtwoord...";
				}
			}
			else
			{
				$errors[] = "Verkeerde email of wachtwoord...";
			}
			
		}
		else
		{
			$errors[] = "Email is niet geldig...";	
		}
 
	}
	else
	{
		$errors[] = "Email en wachtwoord zijn vereist...";	
	}
 
}

if(isset($_POST['uitloggen'])) {
  session_destroy();
  header("location: /");
  exit();
}

