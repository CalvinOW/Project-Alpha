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
					header('location: /dash/main');
					exit();
				}
				else
				{
					$errors[] = "Wrong Email or Password";
				}
			}
			else
			{
				$errors[] = "Wrong Email or Password";
			}
			
		}
		else
		{
			$errors[] = "Email address is not valid";	
		}
 
	}
	else
	{
		$errors[] = "Email and Password are required";	
	}
 
}

