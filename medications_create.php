<?php
@include_once('../app_config.php');
@include_once(APP_ROOT . APP_FOLDER_NAME . '/functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Only one field needed: name
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (!empty($name)) {
        // Insert into medications, let medication_id auto-generate
        $stmt = $pdo->prepare('INSERT INTO medications (name) VALUES (?)');
        $stmt->execute([$name]);
        header('Location: medications_read.php');
        exit;
    } else {
        $msg = 'Please enter a medication name.';
    }
}
?>

<?=template_header('Create Medication')?>

<div class="content update">
    <h2>Add New Medication</h2>
    <form action="medications_create.php" method="post">
        <label for="name">Medication Name</label>
        <input type="text" name="name" id="name" placeholder="Enter medication name" required>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
