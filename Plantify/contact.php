<?php
$title = 'Contact Page';
require_once 'template/header.php';
require_once 'config/database.php';



$errors=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $dbContacterName= mysqli_real_escape_string($mysqli,$_POST['name']);
  $dbEmail= mysqli_real_escape_string($mysqli,$_POST['email']);
  $dbMessage= mysqli_real_escape_string($mysqli,$_POST['message']);

  if(empty($dbContacterName))array_push($errors,"Name is required");
  if(empty($dbEmail))array_push($errors,"Email is required");
  if(empty($dbMessage))array_push($errors,"Message is required");

    if (!$errors) {

        $InsertQuery= $mysqli->prepare("insert into messages(name,email,message)
                                      values (?, ?, ?)");
        $InsertQuery->bind_param("sss",$dbContacterName,$dbEmail,$dbMessage);


        $InsertQuery->execute();

        $_SESSION['success_message'] = "Message has been sent.";
        header('Location: contact.php');
        die();
    }
}



?>

<h1>Contact us</h1>

<?php  include 'template/errors.php'; ?>

<form action=<?php echo $_SERVER["PHP_SELF"] ; ?> method="post" enctype="multipart/form-data">

<div class="form-group">
  <label for="name">Your name</label>
  <input type="text" value="<?php if(isset($_SESSION["contact_form"]["name"])) echo $_SESSION["contact_form"]["name"]; ?>" name="name" class="form-control" placeholder="Your name">
</div>

<div class="form-group">
  <label for="email">Your email</label>
  <input type="email" value="<?php if(isset($_SESSION["contact_form"]["email"])) echo $_SESSION["contact_form"]["email"]; ?>" name="email" class="form-control" placeholder="Your email">
</div>

<div class="form-group">
  <label for="message">Message</label>
  <textarea name="message" class="form-control" rows="8" cols="80" ><?php if(isset($_SESSION["contact_form"]["message"])) echo $_SESSION["contact_form"]["message"]; ?></textarea>
</div>

<button class="btn btn-primary">Send</button>
</form>

<?php require_once 'template/footer.php';


 ?>
