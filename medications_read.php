<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the current page from URL, or default to page 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Number of records per page
$records_per_page = 20;

// Prepare SQL to select medications with LIMIT
$stmt = $pdo->prepare('SELECT * FROM medications ORDER BY medication_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch medications into $medications
$medications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of medications for pagination
$total_medications = (int)$pdo->query('SELECT COUNT(*) FROM medications')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Medications List</h2>
    <a href="medications_create.php" class="create-medication">Add Medication</a>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Medication Name</td>
                <td>Requires Quantity</td>
                <td>Requires Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medications as $medication): ?>
            <tr>
                <td><?=$medication['medication_id']?></td>
                <td><?=$medication['name']?></td>
                <td><?=$medication['requires_quantity']?></td>
                <td><?=$medication['requires_date']?></td>
                <td class="actions">
                    <a href="medications_update.php?medication_id=<?=$medication['medication_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="medications_delete.php?medication_id=<?=$medication['medication_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="medications_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $total_medications): ?>
		<a href="medications_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
