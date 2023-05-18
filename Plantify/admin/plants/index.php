<?php
$title = "Plants";
$icon = "nc-leaf";
include __DIR__.'/../template/header.php';

$plants = $mysqli -> query("select * from plant_care order by id")-> fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $st = $mysqli->prepare("delete from plant_care where id = ?");
  $st -> bind_param("i", $IdToDelete);
  $IdToDelete = $_POST['plant_id'];
  $st -> execute();

  if($st->error) echo $st->error; else echo "<script>location.href='index.php'</script>";

}

?>

<div class="card">
  <div class="card-body">
    <div class="content">

      <a href="create.php" class="btn btn-success">Add a new Plant info</a>
      <p>Plants: <?php echo count($plants); ?></p>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th width="0">#</th>
              <th>Name</th>
              <th>Climate</th>
              <th width="300">Soil</th>
              <th>Sunlight</th>
              <th>Watering</th>
              <th>Pruning</th>
              <th>Fertilizer</th>
              <th>Protection</th>
              <th>Resource</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($plants as $plant): ?>
              <tr>
                  <td><?php echo $plant["id"]; ?></td>
                  <td><?php echo $plant["plant_name"]; ?></td>
                  <td><?php echo $plant["climate"]; ?></td>
                  <td><?php echo $plant["soil"]; ?></td>
                  <td><?php echo $plant["sunlight"]; ?></td>
                  <td><?php echo $plant["watering"]; ?></td>
                  <td><?php echo $plant["pruning"]; ?></td>
                  <td><?php echo $plant["fertilizer"]; ?></td>
                  <td><?php echo $plant["protection"]; ?></td>
                  <td><?php echo $plant["resource"]; ?></td>
                  <td>
                    <a href="edit.php?id=<?php echo $plant["id"]; ?>" class="btn btn-warning">Edit</a>
                    <form action="" method="post" style="display: inline">
                      <input type="hidden" name="plant_id" value="<?php echo $plant["id"]; ?>">
                      <button onclick="confirm('Are you sure?')" class="btn btn-danger" type="submit" name="button">Delete</button>
                    </form>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>

    </div>
  </div>
</div>

<?php
include  __DIR__.'/../template/footer.php'; ?>
