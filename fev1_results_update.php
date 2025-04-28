<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the visit fev1_id exists, for example //update.php?fev1_id=1 will get the visit with the fev1_id //of 1
if (isset($_GET['fev1_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, //but instead we update a record and not //insert
        $fev1_id = isset($_POST['fev1_id']) ? $_POST['fev1_id'] : NULL;
        $fev1_value = isset($_POST['fev1_value']) ? $_POST['fev1_value'] : '';
        $visits_id = isset($_POST['visits_id']) ? $_POST['visits_id'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE fev1_results SET fev1_id = ?, fev1_value = ?, visits_id = ? WHERE fev1_id = ?');
        $stmt->execute([$fev1_id, $fev1_value, $visits_id, $_GET['fev1_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the visit from the visits table
    $stmt = $pdo->prepare('SELECT * FROM fev1_results WHERE fev1_id = ?');
    $stmt->execute([$_GET['fev1_id']]);
    $fev1_results = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$fev1_results) {
        exit('Results doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Results #<?=$fev1_results['fev1_id']?></h2>
    <form action="fev1_results_update.php?fev1_id=<?=$fev1_results['fev1_id']?>" method="post">
        <label for="fev1_id">ID</label>
         <label for="fev1_value">Value</label>
        <input type="text" name="fev1_id" placeholder="1" value="<?=$fev1_results['fev1_id']?>" fev1_id="fev1_id">
        <input type="text" name="fev1_value" placeholder="Summarize Results" 
               value="<?=$fev1_results['fev1_value']?>" fev1_id="fev1_value">
       
         <?php
        $stmt = $pdo->query("SELECT visits_id, name FROM visits");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <label for="visits_id">Contact</label>
        <label for="created">Created</label>
        <select name="visits_id" fev1_id="visits_id">
            <option value="<?=$fev1_results['visits_id']?>" selected><?=$fev1_results['visits_id']?></option>
            <?php foreach($visits as $visit) : ?>
            <option value="<?php echo $visit['fev1_id']; ?>"><?php echo $visit['fev1_id'] . ' - ' . $visit['name']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
