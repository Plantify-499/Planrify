<?php
$title="Sensors Page";
require_once 'template/header.php';

if (!isset($_SESSION['logged_in'])) {
  // Redirect the user to the login page
  header("Location: login.php");
  exit();
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="script.js"></script>
</head>
<body>
	<div class="value-set">
		<p><strong>Humidity:</strong> <span id="1"></span><strong>%</strong></p>
		<p><strong>Temperature:</strong> <span id="2"></span><strong>C</strong></p>
		<p><strong>LM temp:</strong> <span id="3"></span><strong>C</strong></p>
	</div>
	<div class="value-set">
		<p><strong>Soil moisture:</strong> <span id="4"></span><strong>%</strong></p>
		<p><strong>Water Level:</strong> <span id="5"></span><strong>%</strong></p>
		<p><strong>Light intensity:</strong> <span id="6"></span><strong>%</strong></p>
	</div>
	<div class="button-container">
		<button id="waterPump-button" class="off-button">Water pump OFF</button>
		<button id="Fan-button" class="off-button">Fan OFF</button>
		<button id="Light-button" class="off-button">Light OFF</button>

	</div>
</body>
</html>
