<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['prescription_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM prescriptions WHERE prescription_id = ?');
    $stmt->execute([$_GET['prescription_id']]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('Prescription doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM prescriptions WHERE prescription_id = ?');
            $stmt->execute([$_GET['prescription_id']]);
            $msg = 'You have deleted the prescription!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: prescriptions_read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Prescription #<?=$prescription['prescription_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete prescription #<?=$prescription['prescription_id']?>?</p>
    <div class="yesno">
        <a href="prescriptions_delete.php?prescription_id=<?=$prescription['prescription_id']?>&confirm=yes">Yes</a>
        <a href="prescriptions_delete.php?prescription_id=<?=$prescription['prescription_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
