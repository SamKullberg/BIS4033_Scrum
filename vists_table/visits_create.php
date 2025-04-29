<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $visitId = isset($_POST['visit_id']) && !empty($_POST['visit_id']) && $_POST['visit_id'] != 'auto' ? $_POST['visit_id'] : NULL;
    $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $date = isset($_POST['visit_date']) ? $_POST['visit_date'] : date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare('INSERT INTO visits VALUES (?, ?, ?, ?)');
    $stmt->execute([$visitId, $patientId, $doctorId, $date]);
    header('Location: visits_read.php'); 
    exit; 
}
?>
<?php template_header('Create')?>

<div class="content update">
	<h2>Add New Visit</h2>
    <form action="visits_create.php" method="post">
        
        <label for="visit_id">Visit Id</label>
        <input type="text" name="visit_id" value="auto" id="visit_id"><br>
        <?php
            $stmt = $pdo->query("SELECT patient_id, first_name, last_name FROM patients");
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt2 = $pdo->query("SELECT doctor_id, first_name, last_name FROM doctors");
            $doctors = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="patient_id">Patient ID</label>
        <select name="patient_id" id="patient_id">
            <?php foreach($patients as $patient) : ?>
                <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['first_name']. ' - ' . $patient['last_name']; ?></option>
                <?php endforeach; ?>
            </select><br>
        <label for="doctor_id">Doctor ID - Name</label>
        <select name="doctor_id" id="doctor_id">
            <?php foreach($doctors as $doctor) : ?>
                <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['first_name']. ' - ' . $doctor['last_name']; ?></option>
            <?php endforeach; ?>
            </select><br>
        <label for="visit_date">Date of Visit</label>
        <input type="datetime-local" name="visit_date" value="<?=date('Y-m-d\TH:i')?>" id="visit_date"><br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php //template_footer()?>
