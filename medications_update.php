<?php
@include_once('../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '../functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$msg = '';

// Check if ID exists
if (isset($_GET['id'])) {
    // If form was submitted
    if (!empty($_POST)) {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        // Update medication name only
        $stmt = $pdo->prepare('UPDATE medications SET name = ? WHERE medication_id = ?');
        $stmt->execute([$name, $_GET['id']]);

        header('Location: medications_read.php?msg=Medication+updated+successfully');
        exit;
    }

    // Fetch medication data to display
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Medication')?>

<div class="content update">
    <h2>Update Medication #<?=htmlspecialchars($medication['medication_id'])?></h2>
    <form action="medications_update.php?id=<?=urlencode($medication['medication_id'])?>" method="post">
        <label for="name">Medication Name</label>
        <input type="text" name="name" value="<?=htmlspecialchars($medication['name'])?>" id="name" required>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=htmlspecialchars($msg)?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
