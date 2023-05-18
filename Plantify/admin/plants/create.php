<?php
$title = "Create Plant";
$icon = "nc-leaf";
include __DIR__.'/../template/header.php';

$errors = [];
$plant_name = '';
$climate = '';
$soil = '';
$sunlight = '';
$watering = '';
$pruning = '';
$fertilizer = '';
$protection = '';
$resource = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plant_name = mysqli_real_escape_string($mysqli, $_POST['plant_name']);
    $climate = mysqli_real_escape_string($mysqli, $_POST['climate']);
    $soil = mysqli_real_escape_string($mysqli, $_POST['soil']);
    $sunlight = mysqli_real_escape_string($mysqli, $_POST['sunlight']);
    $watering = mysqli_real_escape_string($mysqli, $_POST['watering']);
    $pruning = mysqli_real_escape_string($mysqli, $_POST['pruning']);
    $fertilizer = mysqli_real_escape_string($mysqli, $_POST['fertilizer']);
    $protection = mysqli_real_escape_string($mysqli, $_POST['protection']);
    $resource = mysqli_real_escape_string($mysqli, $_POST['resource']);

    if (empty($plant_name)) array_push($errors, "Plant name is required");
    if (empty($climate)) array_push($errors, "Climate is required");
    if (empty($soil)) array_push($errors, "Soil is required");
    if (empty($sunlight)) array_push($errors, "Sunlight is required");
    if (empty($watering)) array_push($errors, "Watering is required");
    if (empty($pruning)) array_push($errors, "Pruning is required");
    if (empty($fertilizer)) array_push($errors, "Fertilizer is required");
    if (empty($protection)) array_push($errors, "Protection is required");
    if (empty($resource)) array_push($errors, "Resource is required");

    if (!count($errors)) {
        $insertQuery = "INSERT INTO plant_care (plant_name, climate, soil, sunlight, watering, pruning, fertilizer, protection, resource) VALUES ('$plant_name', '$climate', '$soil', '$sunlight', '$watering', '$pruning', '$fertilizer', '$protection', '$resource')";
        $mysqli->query($insertQuery);

        if ($mysqli->error) {
            array_push($errors, $mysqli->error);
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
                <textarea class="form-control" name="resource" placeholder="Resource" rows="5" id="resource"><?php echo $resource; ?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Create Plant</button>
            </div>
        </form>
    </div>
</div>

<?php
include __DIR__.'/../template/footer.php';
?>
