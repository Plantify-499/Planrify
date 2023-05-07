<?php
$title="Plants Page";
require_once 'config/database.php';
require_once 'template/header.php';

// Check if the user is not logged in
if (!isset($_SESSION['logged_in'])) {
  // Redirect the user to the login page
  header("Location: login.php");
  exit();
}
   $user_id =$_SESSION['user_id'];
   $analayzed_pics = $mysqli->query("select * from proceeded_images where user_id=$user_id");?>

  <div class="row">
    <?php foreach ($analayzed_pics as $pic) {
      $pic_id = (int)$pic["id"];
    ?>
<!--          <h5><?php #echo $pic_id; ?></h5> -->
          <img src="<?php  echo $config['app_url'].$pic['image_path']; ?>" width="400" height="400">

<?php

  }
?>
