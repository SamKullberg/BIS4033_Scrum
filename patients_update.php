<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['prescription_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $prescription_id = isset($_POST['prescription_id']) ? $_POST['prescription_id'] : NULL;
        $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
        $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $date_received = isset($_POST['date_received']) ? $_POST['date_received'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE prescriptions SET prescription_id = ?, patient_id = ?, medication_id = ?, quantity = ?, date_received = ? WHERE prescription_id = ?');
        $stmt->execute([$prescription_id, $patient_id, $medication_id, $quantity, $date_received, $_GET['prescription_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = ?');
    $stmt->execute([$_GET['prescription_id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('Prescription doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Prescription #<?=$prescription['prescription_id']?></h2>
    <form action="prescriptions_update.php?id=<?=$prescription['prescription_id']?>" method="post">
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
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
