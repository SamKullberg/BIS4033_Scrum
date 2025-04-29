<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example //update.php?id=1 will get the contact with the id //of 1
if (isset($_GET['medication_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $medication_id = isset($_POST['medication_id']) ? $_POST['medication_id'] : NULL;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $quantity = isset($_POST['requires_quantity']) ? trim($_POST['requires_quantity']) : '';
        $date = isset($_POST['requires_date']) ? trim($_POST['requires_date']) : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE medications SET medication_id = ?, name = ?, requires_quantity = ?, requires_date = ? WHERE medication_id = ?');
        $stmt->execute([$medication_id, $name, $quantity, $date, $_GET['medication_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['medication_id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Medication #<?=$medication['medication_id']?></h2>
    <form action="medications_update.php?medication_id=<?=$medication['medication_id']?>" method="post">
        <label for="medication_id">Doctor ID</label>
        <input type="text" name="medication_id" value="<?=$medication['medication_id']?>" id="medication_id"><br>
        <label for="name">Name</label>
        <input type="text" name="name" value="<?=$medication['name']?>" id="name"><br>
        <label for="requires_quantity">Quantity Requires</label>
        <select name="requires_quantity" value="<?=$medication['requires_quantity']?>"" id="requires_quantity">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
        </select><br>
        <label for="requires_date">Date Requires</label>
        <select name="requires_date" value="<?=$medication['requires_date']?>"" id="requires_date">
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
