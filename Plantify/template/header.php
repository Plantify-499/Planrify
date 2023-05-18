<?php
session_start();
require_once 'config/app.php';
?>
<!DOCTYPE html>
<html lang=<?php echo $config['lang']; ?> dir=<?php echo $config['dir']; ?>>
  <head>
    <meta charset="utf-8">
    <title><?php echo $config['app_name'] . " | " .$title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
      .custom-card-image {

          height: 400px;
          background-size: cover;
          background-position: center;

      }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="<?php echo $config['app_url'] ?>"><?php echo $config['app_name']; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $config['app_url']."contact.php"?>">Contact Us</a>
            </li>
        <?php if(!isset($_SESSION['logged_in'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url']."login.php"?>">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url']."register.php"?>">Register</a>
          </li>
        </ul>
      <?php else: ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url']."results.php"?>">Plants Results</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url']."plant_care.php"?>">How to take Care?</a>
          </li>
          <?php if($_SESSION['user_role']=='admin'){ ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $config['app_url']."sensors.php"?>">Monitoring Results</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo $config['app_url']."admin"?>">Admin Page</a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url']."logout.php"?>">Logout</a>
          </li>
        </ul>
      <?php endif; ?>
    </div>
  </nav>

  <div class="container pt-5">
  <?php include 'messages.php'; ?>
