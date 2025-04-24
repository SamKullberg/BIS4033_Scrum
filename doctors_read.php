<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM doctors ORDER BY doctor_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_doctors = $pdo->query('SELECT COUNT(*) FROM doctors')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Doctors</h2>
	<a href="doctors_create.php" class="create-contact">Create Doctor</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Specialty</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctor): ?>
            <tr>
                <td><?=$doctor['doctor_id']?></td>
                <td><?=$doctor['first_name']?></td>
                <td><?=$doctor['last_name']?></td>
                <td><?=$doctor['specialty']?></td>
                <td class="actions">
                    <a href="doctors_update.php?id=<?=$doctor['doctor_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="doctors_update.php?id=<?=$doctor['doctor_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="doctors_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_doctors): ?>
		<a href="doctors_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>