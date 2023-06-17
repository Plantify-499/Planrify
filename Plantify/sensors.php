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
	<title>Plantify</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="script.js"></script>

</head>
<body>
	<h1>Plantify</h1>
	<div class="value-set">
		<p><strong>Humidity:</strong> <span id="1"></span><strong>%</strong></p>
		<p><strong>Temperature:</strong> <span id="2"></span><strong>C</strong></p>
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
	<div id="success-message" style="display: none;">Data sent successfully, water pump turned on </div>
	<div id="success-message2" style="display: none;">Turned off</div>
	<div id="error-message" style="display: none;">Error sending to the API</div>
	<div id="water-tank" style="display: none;">The water tank is empty, Refill it</div>




</body>
</html>
