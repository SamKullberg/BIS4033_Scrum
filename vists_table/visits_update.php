<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['visit_id'])) { 
    if (!empty($_POST)) {

        $id = isset($_POST['visit_id']) ? $_POST['visit_id'] : NULL;
        $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
        $date = isset($_POST['visit_date']) ? $_POST['visit_date'] : date('Y-m-d H:i:s');
        $doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
       
        $stmt = $pdo->prepare('UPDATE visits SET visit_id = ?, patient_id = ?, visit_date = ?, doctor_id = ? WHERE visit_id = ?');
        $stmt->execute([$id, $patientId, $date, $doctorId, $_GET['visit_id']]);
        header('Location: visits_read.php'); 
        exit; 
    }
    $stmt = $pdo->prepare('SELECT * FROM visits WHERE visit_id = ?');
    $stmt->execute([$_GET['visit_id']]); 
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$visit) {
        exit('Visit doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?php template_header('Read')?>

<div class="content update">
	<h2>Update Visit #<?=$visit['visit_id']?></h2>
    <form action="visits_update.php?visit_id=<?=$visit['visit_id']?>" method="post">
         <label for="visit_id">Visit Id</label>
        <input type="text" name="visit_id" value="<?=$visit['visit_id']?>" value="auto" id="visit_id"><br>
        <?php
            $stmt = $pdo->query("SELECT patient_id, first_name, last_name FROM patients");
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt2 = $pdo->query("SELECT doctor_id, first_name, last_name FROM doctors");
            $doctors = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="patient_id">Patient ID</label>
        <select name="patient_id" value="<?=$visit['patient_id']?>" id="patient_id">
            <?php foreach($patients as $patient) : ?>
                <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['patient_id'] . ' - ' . $patient['first_name']. ' - ' . $patient['last_name']; ?></option>
                <?php endforeach; ?>
            </select><br>
        <label for="doctor_id">Doctor ID - Name</label>
        <select name="doctor_id" value="<?=$visit['doctor_id']?>"id="doctor_id">
            <?php foreach($doctors as $doctor) : ?>
                <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['doctor_id'] . ' - ' . $doctor['first_name']. ' - ' . $doctor['last_name']; ?></option>
            <?php endforeach; ?>
            </select><br>
        <label for="visit_date">Date of Visit</label>
        <input type="datetime-local" name="visit_date" value="<?=$visit['visit_date']?>" id="visit_date"><br>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php //template_footer()?>
