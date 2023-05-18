<?php
$title = "Edit Plant";
$icon = "nc-leaf";
include __DIR__.'/../template/header.php';

if (!isset($_GET["id"]) || !$_GET["id"]) {
  die("Missing parameter");
}

$errors = [];

$plant_id = $_GET["id"];
$st = $mysqli->prepare("SELECT * FROM plant_care WHERE id = ?");
$st->bind_param("i", $plant_id);
$st->execute();

$plant = $st->get_result()->fetch_assoc();

$plant_name = $plant['plant_name'];
$climate = $plant['climate'];
$soil = $plant['soil'];
$sunlight = $plant['sunlight'];
$watering = $plant['watering'];
$pruning = $plant['pruning'];
$fertilizer = $plant['fertilizer'];
$protection = $plant['protection'];
$resource = $plant['resource'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['plant_name'])) array_push($errors, "Plant name is required");
  if (empty($_POST['climate'])) array_push($errors, "Climate is required");
  if (empty($_POST['soil'])) array_push($errors, "Soil is required");
  if (empty($_POST['sunlight'])) array_push($errors, "Sunlight is required");
  if (empty($_POST['watering'])) array_push($errors, "Watering is required");
  if (empty($_POST['pruning'])) array_push($errors, "Pruning is required");
  if (empty($_POST['fertilizer'])) array_push($errors, "Fertilizer is required");
  if (empty($_POST['protection'])) array_push($errors, "Protection is required");
  if (empty($_POST['resource'])) array_push($errors, "Resource is required");

  if (!count($errors)) {
    $st = $mysqli->prepare("UPDATE plant_care SET plant_name = ?, climate = ?, soil = ?, sunlight = ?, watering = ?, pruning = ?, fertilizer = ?, protection = ?, resource = ? WHERE id = $plant_id");
    $st->bind_param("sssssssss", $db_plant_name, $db_climate, $db_soil, $db_sunlight, $db_watering, $db_pruning, $db_fertilizer, $db_protection, $db_resource);

    $db_plant_name = $_POST['plant_name'];
    $db_climate = $_POST['climate'];
    $db_soil = $_POST['soil'];
    $db_sunlight = $_POST['sunlight'];
    $db_watering = $_POST['watering'];
    $db_pruning = $_POST['pruning'];
    $db_fertilizer = $_POST['fertilizer'];
    $db_protection = $_POST['protection'];
    $db_resource = $_POST['resource'];

    $st->execute();

    if ($st->error) {
      array_push($errors, $st->error);
    } else {
      echo "<script>location.href='index.php'</script>";
    }
  }
}
?>

<div class="card">
  <div class="content">
    <?php include __DIR__.'/../template/errors.php'; ?>
    <form action="" method="post">
      <div class="form-group">
        <label for="plant_name">Plant Name:</label>
        <input class="form-control" type="text" name="plant_name" placeholder="Plant Name" value="<?php echo $plant_name; ?>" id="plant_name">
      </div>
      <div class="form-group">
        <label for="climate">Climate:</label>
        <input class="form-control" type="text" name="climate" placeholder="Climate" value="<?php echo $climate; ?>" id="climate">
      </div>
      <div class="form-group">
        <label for="soil">Soil:</label>
        <input class="form-control" type="text" name="soil" placeholder="Soil" value="<?php echo $soil; ?>" id="soil">
      </div>
      <div class="form-group">
        <label for="sunlight">Sunlight:</label>
        <input class="form-control" type="text" name="sunlight" placeholder="Sunlight" value="<?php echo $sunlight; ?>" id="sunlight">
      </div>
      <div class="form-group">
        <label for="watering">Watering:</label>
        <input class="form-control" type="text" name="watering" placeholder="Watering" value="<?php echo $watering; ?>" id="watering">
      </div>
      <div class="form-group">
        <label for="pruning">Pruning:</label>
        <input class="form-control" type="text" name="pruning" placeholder="Pruning" value="<?php echo $pruning; ?>" id="pruning">
      </div>
      <div class="form-group">
        <label for="fertilizer">Fertilizer:</label>
        <input class="form-control" type="text" name="fertilizer" placeholder="Fertilizer" value="<?php echo $fertilizer; ?>" id="fertilizer">
      </div>
      <div class="form-group">
        <label for="protection">Protection:</label>
        <input class="form-control" type="text" name="protection" placeholder="Protection" value="<?php echo $protection; ?>" id="protection">
      </div>
      <div class="form-group">
        <label for="resource">Resource:</label>
        <textarea class="form-control" name="resource" placeholder="Resource" id="resource"><?php echo $resource; ?></textarea>
      </div>
      <div class="form-groupd">
        <button class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__.'/../template/footer.php'; ?>
