<?php
$title="Main Page";
require_once 'template/header.php';

// Check if the user is not logged in
if (!isset($_SESSION['logged_in'])) {
  // Redirect the user to the login page
  header("Location: login.php");
  exit();
}

if (isset($_POST['webcam_on'])) {
  // The button was pressed, write "TRUE" to webcamStatus.txt
  // IMPORTANT !!!!!!!! detect_images_from_website.py must be running on the same device of admin
  $file = fopen("webcamStatus.txt", "w") or die("Unable to open file!");
  fwrite($file, "TRUE");
  fclose($file);
  echo "<h4>Webcam turned on!</h4>";
}

 ?>
    <h1>Upload a photo</h1>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>
<?php if($_SESSION['user_role']=='admin'){ ?>
    <form method="post" action="">
      <button type="submit" name="webcam_on">Webcam detection (Live)</button>
    </form>
<?php } ?>

</body>
</html>
