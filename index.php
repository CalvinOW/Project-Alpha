<?php include ("./system/classes/functions.php"); ?>
<?php include_once("./system/classes/loggedin.php"); ?>
<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<head>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo date("H:i:s");?>">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="https://cloudwise.foremo.nl/assets/images/favicon.ico" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

  <title><?php export_site_title(); ?> &bull; <?php echo_page_name(); ?> v2</title>
</head>

<body>
      <div class="login">
			<?php 
				if(isset($errors) && count($errors) > 0)
				{
					foreach($errors as $error_msg)
					{
						echo '<div class="alert alert-danger">'.$error_msg.'</div>';
					}
				}
			?>
        <center><img src="./assets/img/<?php export_site_logo(); ?>" style="height: 20%;"></center>
			<h1>Inloggen op <?php export_site_title(); ?></h1>
			<form action="" method="post">
				<label for="username">
					<i class="fas fa-at"></i>
				</label>
				<input type="text" name="email" placeholder="E-mailadres" id="email">
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Wachtwoord" id="password">
				<input type="submit" name="inloggen" value="Inloggen">
			</form>
        <br><br>
        <center>v<?php export_version(); ?></center>
		</div>
</body>