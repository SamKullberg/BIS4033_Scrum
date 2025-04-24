<?php
// @include_once ('../app_config.php');
// @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// $pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $visitId = isset($_POST['visit_id']) && !empty($_POST['visit_id']) && $_POST['visit_id'] != 'auto' ? $_POST['visit_id'] : NULL;
    $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $date = isset($_POST['visit_date']) ? $_POST['visit_date'] : date('Y-m-d H:i:s');
    $doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    
    $stmt = $pdo->prepare('INSERT INTO visits VALUES (?, ?, ?, ?,)');
    $stmt->execute([$visit_id, $patientId, $doctorId, $date]);
    header('Location: visits_read.php'); 
    exit; 
}
?>
<?php //template_header('Create')?>

<div class="content update">
	<h2>Add New Visit</h2>
    <form action="visits_create.php" method="post">
        
        <label for="visitId">VisitId</label>
        <input type="text" name="visitId" placeholder="1" value="auto" id="visitId">
        
        <?php
        $stmt = $pdo->query("SELECT patient_id, first_name, last_name FROM patients ORDER BY patient_id");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="patientId">Patient ID - Name</label>
            <select name="patientId" id="patientId" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($patients as $patient) : ?>
                    <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['patientFName'] . ' ' . $patient['patientLName']  ; ?></option>
                <?php endforeach; ?>
            </select>
        
        <label for="date">Date of Visit</label>
        <input type="datetime-local" name="date" value="<?=date('Y-m-d\TH:i')?>" id="date">

        <?php
        $stmt = $pdo->query("SELECT doctor_id, first_name, last_name, specialty FROM doctors ORDER BY doctor_id");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="doctorId">Doctor ID - Name</label>
            <select name="doctorId" id="doctorId" required>
                <option value="" disabled selected>Please select an option</option>
                <?php foreach($doctors as $doctor) : ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['first_name'].' '.$doctor['last_name'] ; ?></option>
                <?php endforeach; ?>
            </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php //template_footer()?>