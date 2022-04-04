<?php

require_once ("database.php");  

function export_site_title() {
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
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
  $opmerking = "Login";
  $query = "INSERT INTO activity_log (user_id, last_ip, time, opmerking) VALUES (?,?,?,?)";
  $statement = $db->prepare($query);
  $statement->execute([$_SESSION['id'], $ip, $time, $opmerking]);
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

function export_activity() {
  error_reporting(1);
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM activity_log WHERE user_id=$id ORDER BY id DESC LIMIT 10");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($result as $row) {
      echo "<tr class='odd'>";
     echo '<td class="sorting_1">'.$row["id"].'</td>';
     echo "<td>".$row['last_ip']."</td>";
     echo "<td>".$row['time']."</td>";
     echo "<td>".$row['opmerking']."</td>";
      echo "</tr>";
  }
}

function export_user_status() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
   
  $query = $db->prepare("SELECT * FROM user_status");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($result as $row) {
  echo "<form class='user' action='' id=".$row['value']." method='post'>";
  echo "<style>.btn-".$row['value']." { color: white; background-color: ".$row['color']."; border-color: ".$row['color']."}</style>";
  echo "<input class='btn btn-".$row['value']."' type='submit'  id='".$row['id']."' name='".$row['value']."' value='".$row['naam']."'> &nbsp;";
    
    if(isset($_POST[$row['value']])) {
      $email = $_SESSION['email'];
      $status = $row['id'];
      
      $stmt = $db->prepare("UPDATE users SET user_status_id =  ? WHERE email = ?");
      $stmt->execute(array($status, $email));
      
      $time = date("Y-m-d H:i:s");
      $ip = $_SERVER['REMOTE_ADDR'];
      $opmerking = "Status aangepast.";
      $query = "INSERT INTO activity_log (user_id, last_ip, time, opmerking) VALUES (?,?,?,?)";
      $statement = $db->prepare($query);
      $statement->execute([$_SESSION['id'], $ip, $time, $opmerking]);
      echo '<meta http-equiv="refresh" content="0;url=/dash/profile" />';
    }
  }
  
  
}

function export_current_user_status() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM users WHERE id=$id");
  $query->execute();
  $result = $query->fetch();
  $status_id = $result['user_status_id'];
   
  $stmt = $db->prepare("SELECT * FROM user_status WHERE id=$status_id");
  $stmt->execute();
  $result = $stmt->fetch();
  echo "<style>.badge-".$result['value']." { color: white; background-color: ".$result['color']."; border-color: ".$result['color']."}</style>";
  echo "<span class='badge badge-".$result['value']."'>".$result['naam']."</span>";
  
} 

function admin_button() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM users WHERE id=$id");
  $query->execute();
  $result = $query->fetch();
  $role_id = $result['user_role_id'];
   
  $stmt = $db->prepare("SELECT * FROM user_roles WHERE id=$role_id");
  $stmt->execute();
  $result = $stmt->fetch();
  if($result['access_admin'] == 1) {
      echo '<a class="dropdown-item" href="/admin/main"><i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i> Admin</a>';
    } else {
   }
  

  
} 

function check_admin() {
  
  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM users WHERE id=$id");
  $query->execute();
  $result = $query->fetch();
  $role_id = $result['user_role_id'];
   
  $stmt = $db->prepare("SELECT * FROM user_roles WHERE id=$role_id");
  $stmt->execute();
  $result = $stmt->fetch();
  if($result['access_admin'] == 1) {
    } else {
    header("Location: /dash/main");
   }
  

  
} 

function upload_avatar() {
  error_reporting(1);

  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $id = $_SESSION['id'];  
  $query = $db->prepare("SELECT * FROM users WHERE id=$id");
  $query->execute();
  $result = $query->fetch();
  
  echo $msg;
  
  echo "<center><img for='file' class='avatar' style='height: 100px; border-radius: 50%;' src='../Uploads/".$result['avatar']."'></center>";
  echo '<br>
              <form  class="user" action="" id="Upload" method="post">
            <input id="file" type="file" 
                   name="file" 
                   value="" enctype="multipart/form-data" style="display: none;"/>
		<br></br></form>';
  
  echo '<form class="user" action="" id="Upload" method="post" enctype="multipart/form-data">
         <input type="file" id="image" name="image" style="display: none;"/>
         <center><label class="btn btn-warning" for="image">Selecteer bestand</label></center>
         <center><input class="btn btn-primary" type="submit" name="Upload" value="Upload"></center>
      </form>';
  
   if (isset($_POST['Upload'])) {
     
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors="<div class='alert alert-danger'>Selecteer een afbeelding!</div>";
      }
      
      if($file_size > 1048576){
         $errors='<div class="alert alert-danger">Afbeelding kan niet groter zijn dan 1 MB!</div>';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"../Uploads/".$file_name);
         echo "<div class='alert alert-success'>Avatar succesvol geupload!</div>";
        $email = $_SESSION['email'];
      
        $stmt = $db->prepare("UPDATE users SET avatar = ? WHERE email = ?");
        $stmt->execute(array($file_name, $email));
      
        $time = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        $opmerking = "Profiel avatar aangepast.";
        $query = "INSERT INTO activity_log (user_id, last_ip, time, opmerking) VALUES (?,?,?,?)";
        $statement = $db->prepare($query);
        $statement->execute([$_SESSION['id'], $ip, $time, $opmerking]);
        
         echo '<meta http-equiv="refresh" content="0;url=/dash/profile" />';
       
      }else{
         print_r($errors);
      }
  }
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

