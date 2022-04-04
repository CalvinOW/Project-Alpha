<?php

  require_once ("database.php");  

  global $hostname;
  global $database;
  global $user;
  global $password;
  global $db;
  
  $query = $db->prepare("SELECT * FROM users");
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($result as $rows) {
  $status_id = $rows['user_status_id'];
    
  $stmt = $db->prepare("SELECT * FROM user_status WHERE id=$status_id");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($results as $row) {
    echo '<div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-primary shadow h-100 py-2" style="border-left: 0.25rem solid '.$row['color'].' !important"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">';
    echo "<h5>".$rows['username']."</h5></div>";
    echo '<div class="h4 mb-0 font-weight-bold text-gray-800"><span class="badge badge-'.$row['value'].'" style=" color: white; background-color: '.$row['color'].'; border-color: '.$row['color'].'">'.$row['naam'].'</span></div>';
    echo '</div><div class="col-auto"><img style="height: 100px; width: 100px; border-radius: 50%;" src="../Uploads/'.$rows['avatar'].'" no-cache></div></div></div></div></div>';
  }
  }