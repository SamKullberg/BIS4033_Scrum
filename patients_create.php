<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $patientId = isset($_POST['patientId']) && !empty($_POST['patientId']) && $_POST['patientId'] != 'auto' ? $_POST['patientId'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $patientFName = isset($_POST['patientFName']) ? $_POST['patientFName'] : '';
    $patientLName = isset($_POST['patientLName']) ? $_POST['patientLName'] : '';
    $patientGender = isset($_POST['patientGender']) ? $_POST['patientGender'] : '';
    $patientBDay = isset($_POST['patientBDay']) ? $_POST['patientBDay'] : '';
    $patientGenetic = isset($_POST['patientGenetic']) ? $_POST['patientGenetic'] : '';
    $patientDiabetes = isset($_POST['patientDiabetes']) ? $_POST['patientDiabetes'] : '';
    $patientCond = isset($_POST['patientCond']) ? $_POST['patientCond'] : '';
   
    $stmt = $pdo->prepare('INSERT INTO patients (patientId, patientFName, patientLName, patientGender, patientBDay, patientGenetic, patientDiabetes, patientCond) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$patientId, $patientFName, $patientLName, $patientGender, $patientBDay, $patientGenetic, $patientDiabetes, $patientCond]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Patient</h2>
    <form action="patients_create.php" method="post">
<div>
        <label for="patientId">Patient ID</label>
</div>
<div>
        <label for="patientFName">First Name</label>
        <input type="text" name="patientFName" placeholder="John" id="name">
</div>
<div>
        <label for="patientLName">Last Name</label>
        <input type="text" name="patientLName" placeholder="Doe" id="name">
</div>
<div>
        <label for="patientGender">Gender</label>
        <input type="text" name="patientGender" id="patientGender">
</div>
<div>
        <label for="patientBDay">Birthdate</label>
        <input type="date" name="patientBDay" id="patientBDay">
</div>
<div>
        <label for="patientGenetic">Genetics</label>
        <input type="text" name="patientGenetic" id="patientGenetic">
</div>
<div>
    <label for="patientDiabetes">Diabetes</label>
    <select name="patientDiabetes" id="patientDiabetes">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</div>
<div>
        <label for="patientCond">Other Conditions</label>
        <input type="text" name="patientCond" id="patientCond">
</div>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
