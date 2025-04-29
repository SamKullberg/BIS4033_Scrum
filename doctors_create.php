<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $doctor_id = isset($_POST['doctor_id']) && !empty($_POST['doctor_id']) && $_POST['doctor_id'] != 'auto' ? $_POST['doctor_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $specialty = isset($_POST['specialty']) ? $_POST['specialty'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO doctors VALUES (?, ?, ?, ?)');
    $stmt->execute([$doctor_id, $first_name, $last_name, $specialty]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Doctor</h2>
    <form action="doctors_create.php" method="post">
        <label for="doctor_id">Doctor ID</label>
        <input type="text" name="doctor_id" placeholder="26" value="auto" id="doctor_id"><br>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" placeholder="John" id="first_name"><br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" placeholder="Doe" id="last_name"><br>
        <label for="specialty">Specialty</label>
        <input type="text" name="specialty" placeholder="Family Care" id="specialty"><br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
