<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the patient ID is provided in the URL
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Get values from the form POST
        $patientId = isset($_POST['patientId']) ? $_POST['patientId'] : NULL;
        $patientFName = isset($_POST['patientFName']) ? $_POST['patientFName'] : '';
        $patientLName = isset($_POST['patientLName']) ? $_POST['patientLName'] : '';
        $patientGender = isset($_POST['patientGender']) ? $_POST['patientGender'] : '';
        $patientBDay = isset($_POST['patientBDay']) ? $_POST['patientBDay'] : '';
        $patientGenetic = isset($_POST['patientGenetic']) ? $_POST['patientGenetic'] : '';
        $patientDiabetes = isset($_POST['patientDiabetes']) ? $_POST['patientDiabetes'] : '';
        $patientCond = isset($_POST['patientCond']) ? $_POST['patientCond'] : '';

        // Update the patient record
        $stmt = $pdo->prepare('UPDATE patients SET patientId = ?, patientFName = ?, patientLName = ?, patientGender = ?, patientBDay = ?, patientGenetic = ?, patientDiabetes = ?, patientCond = ? WHERE patientId = ?');
        $stmt->execute([$patientId, $patientFName, $patientLName, $patientGender, $patientBDay, $patientGenetic, $patientDiabetes, $patientCond, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }

    // Fetch the existing patient data
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patientId = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update')?>

<div class="content update">
    <h2>Update Patient #<?=$contact['patientId']?></h2>
    <form action="patients_update.php?id=<?=$contact['patientId']?>" method="post">
        <label for="patientId">Patient ID</label>
        <input type="text" name="patientId" value="<?=$contact['patientId']?>" id="patientId">

        <label for="patientFName">First Name</label>
        <input type="text" name="patientFName" value="<?=$contact['patientFName']?>" id="patientFName">

        <label for="patientLName">Last Name</label>
        <input type="text" name="patientLName" value="<?=$contact['patientLName']?>" id="patientLName">

        <label for="patientGender">Gender</label>
        <input type="text" name="patientGender" value="<?=$contact['patientGender']?>" id="patientGender">

        <label for="patientBDay">Birthdate</label>
        <input type="text" name="patientBDay" value="<?=$contact['patientBDay']?>" id="patientBDay">

        <label for="patientGenetic">Genetics</label>
        <input type="text" name="patientGenetic" value="<?=$contact['patientGenetic']?>" id="patientGenetic">

<div>
        <label for="patientDiabetes">Diabetes</label>
        <select name="patientDiabetes" id="patientDiabetes">
            <option value="Yes" <?= $contact['patientDiabetes'] == 'Yes' ? 'selected' : '' ?>>Yes</option>
            <option value="No" <?= $contact['patientDiabetes'] == 'No' ? 'selected' : '' ?>>No</option>
        </select>
</div>
<div>
        <label for="patientCond">Other Conditions</label>
        <input type="text" name="patientCond" value="<?=$contact['patientCond']?>" id="patientCond">
</div>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

