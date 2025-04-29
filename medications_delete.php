<?php
@include_once('../app_config.php');
@include_once('../functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$msg = '';

// Check if an ID was provided
if (isset($_GET['id'])) {
    // Fetch medication record
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }

    // If confirm parameter is set
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Delete medication
            $stmt = $pdo->prepare('DELETE FROM medications WHERE medication_id = ?');
            $stmt->execute([$_GET['id']]);
            header('Location: medications_read.php?msg=Medication+deleted+successfully');
            exit;
        } else {
            // If "no" clicked, redirect back without deleting
            header('Location: medications_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete Medication')?>

<div class="content delete">
    <h2>Delete Medication #<?=htmlspecialchars($medication['medication_id'])?></h2>
    <p>Are you sure you want to delete medication <strong><?=htmlspecialchars($medication['name'])?></strong>?</p>
    <div class="yesno">
        <a href="medications_delete.php?id=<?=urlencode($medication['medication_id'])?>&confirm=yes" class="btn-yes">Yes</a>
        <a href="medications_read.php" class="btn-no">No</a>
    </div>
</div>

<?=template_footer()?>
