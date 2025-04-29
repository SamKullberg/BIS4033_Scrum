<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
//Connect to MySQL database
$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$stmt = $pdo->prepare('SELECT * FROM visits ORDER BY visit_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_visits = $pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
?>
<?=template_header('Read')?>
<div class="content read">
	<h2>View Visits</h2>
	<a href="visits_create.php" class="create-contact">New Visit</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Patient ID</td>
                <td>Doctor ID</td>
                <td>Visit Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($visits as $visit): ?>
            <tr>
                <td><?=$visit['visit_id']?></td>
                <td><?=$visit['patient_id']?></td>
                <td><?=$visit['doctor_id']?></td>
                <td><?=$visit['visit_date']?></td>
            <?php
            //$max_fev1 = max($visit['fev1_1'], $visit['fev1_2'], $visit['fev1_3']);
            //echo $max_fev1;
            ?>
</td>
                <td class="actions">
                    <a href="visits_update.php?visit_id=<?=$visit['visit_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="visits_delete.php?visit_id=<?=$visit['visit_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="visits_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_visits): ?>
		<a href="visits_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?php //template_footer()?>
