<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['doctor_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : NULL;
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $specialty = isset($_POST['specialty']) ? $_POST['specialty'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE doctors SET doctor_id = ?, first_name = ?, last_name = ?, specialty = ? WHERE doctor_id = ?');
        $stmt->execute([$doctor_id, $first_name, $last_name, $specialty, $_GET['doctor_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM doctors WHERE doctor_id = ?');
    $stmt->execute([$_GET['doctor_id']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$doctor) {
        exit('Doctor doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Doctor #<?=$doctor['doctor_id']?></h2>
    <form action="doctors_update.php?doctor_id=<?=$doctor['doctor_id']?>" method="post">
        <label for="doctor_id">Doctor ID</label>
        <input type="text" name="doctor_id" placeholder="26" value="<?=$doctor['doctor_id']?>" id="doctor_id"><br>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" placeholder="John" value="<?=$doctor['first_name']?>" id="first_name"><br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" placeholder="Doe" value="<?=$doctor['last_name']?>" id="last_name"><br>
        <label for="specialty">Specialty</label>
        <input type="text" name="specialty" placeholder="Family Care" value="<?=$doctor['specialty']?>" id="specialty"><br>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
