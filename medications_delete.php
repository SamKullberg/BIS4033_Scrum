<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check if an ID was provided
if (isset($_GET['medication_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM medications WHERE medication_id = ?');
    $stmt->execute([$_GET['medication_id']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM medications WHERE medication_id = ?');
            $stmt->execute([$_GET['medication_id']]);
            $msg = 'You have deleted the medication!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: medications_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Medication #<?=$medication['medication_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete medication #<?=$medication['medication_id']?>?</p>
    <div class="yesno">
        <a href="medications_delete.php?medication_id=<?=$medication['medication_id']?>&confirm=yes">Yes</a>
        <a href="medications_delete.php?medication_id=<?=$medication['medication_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
