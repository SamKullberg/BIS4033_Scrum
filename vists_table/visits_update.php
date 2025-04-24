<?php
// @include_once ('../../app_config.php');
// @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// $pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) { 
    if (!empty($_POST)) {

        $id = isset($_POST['visit_id']) ? $_POST['visit_id'] : NULL;
        $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
        $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d H:i:s');
        $doctorId = isset($_POST['doctorId']) ? $_POST['doctorId'] : '';
       
        $stmt = $pdo->prepare('UPDATE visits SET visit_id = ?, patient_id = ?, visit_date = ?, doctor_id = ? WHERE visit_id = ?');
        $stmt->execute([$id, $patientId, $date, $doctorId, $fev1_1, $fev1_2, $fev1_3, $_GET['id']]);
        header('Location: visits_read.php'); 
        exit; 
    }
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE visit_id = ?');
    $stmt->execute([$_GET['id']]); 
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$visit) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?php //template_header('Read')?>

<div class="content update">
	<h2>Update Visit #<?=$visit['visit_id']?></h2>
    <form action="visits_update.php?id=<?=$visit['visit_id']?>" method="post">
    <label for="visit_id">Visit ID</label>
    <input type="text" name="visit_id" value="<?=$visit['visit_id']?>" id="visit_id">

    <?php
        $stmt = $pdo->query("SELECT patient_id, first_name, last_name FROM patients ORDER BY patient_id");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <label for="patientId">Patient Seen</label>
    <select name="patientId" id="patientId">
            <option value="<?=$visit['patient_id']?>" selected><?=$visit['patient_id']?></option>
            <?php foreach($patients as $patient) : ?>
            <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['patientFName']. ' ' . $patient['patientLName'] ; ?></option>
            <?php endforeach; ?>
        </select>

    <label for="date">Date of Visit</label>
    <input type="datetime-local" name="date" value="<?=date('Y-m-d\TH:i', strtotime($visit['date']))?>" id="date">

    <?php
        $stmt = $pdo->query("SELECT doctor_id, first_name, last_name, specialty FROM doctors ORDER BY doctor_id");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <label for="doctorId">Doctor Seen</label>
    <select name="doctorId" id="doctorId">
            <option value="<?=$visit['doctor_id']?>" selected><?=$visit['doctor_id']?></option>
            <?php foreach($doctors as $doctor) : ?>
            <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['first_name'].' ' . $doctor['last_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php //template_footer()?>
