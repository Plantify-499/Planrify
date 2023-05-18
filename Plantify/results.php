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

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['delete_pic'])) {
  $pic_id= $_POST['delete_pic'];
  $pic_path = $_POST['pic_path'];
  //Delete pic from DB
  $mysqli->query("delete from proceeded_images where id=".$pic_id);
  // Delete it from the folder (SERVER)
  unlink($pic_path);
}

 $user_id =$_SESSION['user_id'];
 $analayzed_pics = $mysqli->query("select * from proceeded_images where user_id=$user_id");

 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta http-equiv="refresh" content="5">
 </head>
 <body>
   <?php if($analayzed_pics->num_rows == 0){
     echo "<h4>No pictures yet.</h4>";
          }
   ?>
  <div class="row">
  <?php foreach ($analayzed_pics as $pic) { ?>
  <div class="col-md4">
    <div class="card mb-3">
      <div class="card-body">
      <img src="<?php  echo $config['app_url'].$pic['image_path']; ?>" width="400" height="400">
        <div class="">ID: <?php echo $pic['id']; ?></div>
        <div class="">Date of analysis: <?php echo $pic['analysis_date']; ?></div>

        <a href="<?php echo $pic['image_path']; ?>" download>
        <button class="btn btn-success">Download Picture</button>
        <a>

        <form action="" method="post" style="display: inline" >
          <input type="hidden" name="delete_pic" value="<?php echo $pic["id"]; ?>">
          <input type="hidden" name="pic_path" value="<?php echo $pic["image_path"]; ?>">
          <button onclick='return confirm("Are you sure?")' class="btn btn-danger" type="submit">Delete this picture</button>
        </form>
      </div>
    </div>
  </div>

<?php

  }
?>

</body>
</html>
