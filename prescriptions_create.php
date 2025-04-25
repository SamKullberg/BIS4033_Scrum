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
        <input type="text" name="prescription_id" placeholder="26" value="auto" id="prescription_id"><br>
        <?php
            $stmt = $pdo->query("SELECT patient_id, last_name FROM patients");
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt2 = $pdo->query("SELECT medication_id, name FROM medications");
            $medications = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="patient_id">Patient ID</label>
        <select name="patient_id" id="patient_id">
            <?php foreach($patients as $patient) : ?>
                <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['last_name']; ?></option>
                <?php endforeach; ?>
            </select> <br>
        <label for="medication_id">Medication ID</label>
            <select name="medication_id" id="medication_id">
            <?php foreach($medications as $medication) : ?>
            <option value="<?php echo $medication['medication_id']; ?>"><?php echo $medication['medication_id'] . ' - ' . $medication['name']; ?></option>
            <?php endforeach; ?>
        </select> <br>
        <label for="quantity">Quantity</label>
        <input type="text" name="quantity" id="quantity"><br>
        <label for="date_received">Date Received</label>
        <input type="text" name="date_received" id="date_received"><br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
