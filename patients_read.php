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
$stmt = $pdo->prepare('SELECT * FROM patients ORDER BY patientId LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="patients_read">
	<h2>Read Contacts</h2>
	<a href="patients_create.php" class="create-patient">Create Patient</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Gender</td>
                <td>Birthdate</td>
                <td>Genetics</td>
                <td>Diabetes</td>
                <td>Other Conditions</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $patient): ?>
            <tr>
                <td><?=$patient['patientId']?></td>
                <td><?=$patient['patientFName']?></td>
                <td><?=$patient['patientLName']?></td>
                <td><?=$patient['patientGender']?></td>
                <td><?=$patient['patientBDay']?></td>
                <td><?=$patient['patientGenetic']?></td>
                <td><?=$patient['patientDiabetes']?></td>
                <td><?=$patient['patientCond']?></td>
                <td class="actions">
                    <a href="patients_update.php?id=<?=$patient['patientId']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="patients_delete.php?id=<?=$patient['patientId']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="patients_read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="patients_read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
