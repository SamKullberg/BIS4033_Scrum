<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $prescription_id = isset($_POST['prescription_id']) && !empty($_POST['prescription_id']) && $_POST['prescription_id'] != 'auto' ? $_POST['prescription_id'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $date_received = isset($_POST['date_received']) ? $_POST['date_received'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO prescriptions VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$prescription_id, $patient_id, $medication_id, $quantity, $date_received]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Prescription</h2>
    <form action="prescriptions_create.php" method="post">
        <label for="prescription_id">Prescription ID</label>
        <label for="patient_id">Patient ID</label>
        <input type="text" name="prescription_id" placeholder="26" value="auto" id="prescription_id">
        <input type="text" name="patient_id" id="patient_id">
        <label for="medication_id">Medication ID</label>
        <label for="quantity">Quantity</label>
        <input type="text" name="medication_id" id="medication_id">
        <input type="text" name="quantity" id="quantity">
        <label for="date_received">Date Received</label>
        <input type="text" name="date_received" id="date_received">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
