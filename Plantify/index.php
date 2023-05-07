<?php
$title="Main Page";
require_once 'template/header.php';

// Check if the user is not logged in
if (!isset($_SESSION['logged_in'])) {
  // Redirect the user to the login page
  header("Location: login.php");
  exit();
}
 ?>
<!doctype html>
<html>
<head>
    <title>Photo Upload</title>
</head>
<body>
    <h1>Upload a photo</h1>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

</body>
</html>
