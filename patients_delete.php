<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM patients WHERE patientId = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        exit('Patient doesn\'t exist with that ID!');
    }

    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM patients WHERE patientId = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the patient!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: patients_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Patient #<?=$contact['patientId']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete patient #<?=$contact['patientId']?>?</p>
    <div class="yesno">
        <a href="patients_delete.php?id=<?=$contact['patientId']?>&confirm=yes">Yes</a>
        <a href="patients_delete.php?id=<?=$contact['patientId']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
