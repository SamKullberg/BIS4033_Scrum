<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Only one field needed: name
    $medication_id = isset($_POST['medication_id']) && !empty($_POST['medication_id']) && $_POST['medication_id'] != 'auto' ? $_POST['medication_id'] : NULL;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $quantity = isset($_POST['requires_quantity']) ? trim($_POST['requires_quantity']) : '';
    $date = isset($_POST['requires_date']) ? trim($_POST['requires_date']) : '';

    $stmt = $pdo->prepare('INSERT INTO medications VALUES (?, ?, ?, ?)');
    $stmt->execute([$medication_id, $name, $quantity, $date]);
    // Output message
    $msg = 'Created Successfully!';
}?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Medication</h2>
    <form action="medications_create.php" method="post">
        <label for="medication_id">Medication ID</label>
        <input type="text" name="medication_id" placeholder="26" value="auto" id="medication_id"><br>
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="John" id="name"><br>
        <label for="requires_quantity">Requires Quantity</label>
        <select name="requires_quantity" id="requires_quantity">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
        </select><br>
        <label for="requires_date">Requres Date</label>
        <select name="requires_date" id="requires_date">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
        </select><br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
