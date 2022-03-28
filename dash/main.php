<?php include_once("../system/classes/functions.php"); ?>
<?php include_once("../system/classes/loggedin.php"); ?>
<?php update_last_ip(); ?>

<head>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo date("H:i:s");?>">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="https://cloudwise.foremo.nl/assets/images/favicon.ico" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

  <title><?php export_site_title(); ?> &bull; <?php echo_page_name(); ?> v2</title>
</head>

<body>
  <div class="container">
    <p>
      Welkom terug, <?php echo $_SESSION['username']; ?>
    </p>
  </div>
</body>