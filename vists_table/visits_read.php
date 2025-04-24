<?php
// @include_once ('../../app_config.php');
// @include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
// $pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$stmt = $pdo->prepare('
    SELECT visits.*, patients.first_name, patients.last_name, doctors.first_name AS docName
    FROM visits 
    JOIN patients ON visits.patient_id = patients.patient_id 
    JOIN doctors ON visits.doctor_id = doctors.doctor_id
    ORDER BY visit_id 
    LIMIT :current_page, :record_per_page
');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_visits = $pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
?>
<?php //template_header('Read')?>

<div class="content read">
	<h2>View Visits</h2>
	<a href="visits_create.php" class="create-contact">New Visit</a>
	<table>
        <thead>
            <tr>
                <td>Patient Name</td>
                <td>Visit Date</td>
                <td>Doctor ID</td>
                <td>Highest FEV1</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visits as $visit): ?>
            <tr>
                <td><?="{$visit['patientId']}-{$visit['first_name']} {$visit['last_name']}"?></td>
                <td><?=$visit['visit_date']?></td>
                <td><?="{$visit['doctorId']}-{$visit['docName']}"?></td>
                <td>
            <?php
            // $max_fev1 = max($visit['fev1_1'], $visit['fev1_2'], $visit['fev1_3']);
            // echo $max_fev1;
            ?>
</td>
                <td class="actions">
                    <a href="visits_update.php?id=<?=$visit['visit_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="visits_delete.php?id=<?=$visit['visit_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
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