<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $patientId = isset($_POST['patient_id']) && !empty($_POST['patient_id']) && $_POST['patient_id'] != 'auto' ? $_POST['patient_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $patientFName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $patientLName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $patientGender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $patientBDay = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $patientGenetic = isset($_POST['genetics']) ? $_POST['genetics'] : '';
    $patientDiabetes = isset($_POST['diabetes']) ? $_POST['diabetes'] : '';
    $patientCond = isset($_POST['other_conditions']) ? $_POST['other_conditions'] : '';
   
    $stmt = $pdo->prepare('INSERT INTO patients (patient_id, first_name, last_name, gender, birthdate, genetics, diabetes, other_conditions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$patientId, $patientFName, $patientLName, $patientGender, $patientBDay, $patientGenetic, $patientDiabetes, $patientCond]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Patient</h2>
    <form action="patients_create.php" method="post">

        <label for="patient_id">Patient ID</label>
        <input type="text" name="patient_id" placeholder="26" value="auto" id="patient_id"><br>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" placeholder="John" id="first_name"><br>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" placeholder="Doe" id="last_name"><br>
        <label for="gender">Gender</label>
        <input type="text" name="gender" id="gender"><br>

        <label for="birthdate">Birthdate</label>
        <input type="date" name="birthdate" id="birthdate"><br>
        <label for="genetics">Genetics</label>
        <input type="text" name="genetics" id="genetics"><br>

        <label for="other_conditions">Other Conditions</label>
        <input type="text" name="other_conditions" id="other_conditions"><br>
        <label for="diabetes">Diabetes</label>
        <select name="diabetes" id="diabetes">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
        </select><br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
