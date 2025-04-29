<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the patient ID is provided in the URL
if (isset($_GET['patient_id'])) {
    if (!empty($_POST)) {
        // Get values from the form POST
        $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
        $patientFName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $patientLName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $patientGender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $patientBDay = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
        $patientGenetic = isset($_POST['genetics']) ? $_POST['genetics'] : '';
        $patientDiabetes = isset($_POST['diabetes']) ? $_POST['diabetes'] : '';
        $patientCond = isset($_POST['other_conditions']) ? $_POST['other_conditions'] : '';

        // Update the patient record
        $stmt = $pdo->prepare('UPDATE patients SET patient_id = ?, first_name = ?, last_name = ?, gender = ?, birthdate = ?, genetics = ?, diabetes = ?, other_conditions = ? WHERE patient_id = ?');
        $stmt->execute([$patientId, $patientFName, $patientLName, $patientGender, $patientBDay, $patientGenetic, $patientDiabetes, $patientCond, $_GET['patient_id']]);
        $msg = 'Updated Successfully!';
    }

    // Fetch the existing patient data
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patient_id = ?');
    $stmt->execute([$_GET['patient_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        exit('Patient doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update')?>

<div class="content update">
    <h2>Update Patient #<?=$patient['patient_id']?></h2>
    <form action="patients_update.php?patient_id=<?=$patient['patient_id']?>" method="post">
            <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" value="<?=$patient['patient_id']?>" id="patient_id"><br>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?=$patient['first_name']?>" id="first_name"><br>


            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" value="<?=$patient['last_name']?>" id="last_name"><br>
            <label for="gender">Gender</label>
            <input type="text" name="gender" value="<?=$patient['gender']?>" id="gender"><br>

            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" value="<?=$patient['birthdate']?>" id="birthdate"><br>
            <label for="genetics">Genetics</label>
            <input type="text" name="genetics" value="<?=$patient['genetics']?>" id="genetics"><br>
        
            <label for="diabetes">Diabetes</label>
            <input type="text" name="other_conditions" value="<?=$patient['other_conditions']?>" id="other_conditions"><br>
            <label for="other_conditions">Other Conditions</label>
            <select name="diabetes" value="<?=$patient['diabetes']?>" id="diabetes">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br>
            <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
