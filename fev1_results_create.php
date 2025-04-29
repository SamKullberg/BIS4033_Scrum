<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $fev1_id = isset($_POST['fev1_id']) && !empty($_POST['fev1_id']) && $_POST['fev1_id'] != 'auto' ? $_POST['fev1_id'] : NULL;
    /*Check if POST variable //"fev1_value" exists, if not default //the value to blank, basically the same for //all variables*/
    $fev1_value = isset($_POST['fev1_value']) ? $_POST['fev1_value'] : '';
    $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id'] : '';
    // Insert new record into the fev1_results table
    $stmt = $pdo->prepare('INSERT INTO fev1_results(fev1_id, visit_id, fev1_value) VALUES (?, ?, ? )');
    $stmt->execute([$fev1_id, $visit_id, $fev1_value]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Results</h2>
    <form action="fev1_results_create.php" method="post">
        <label for="fev1_id">ID</label>
        <input type="text" name="fev1_id" placeholder="26" value="auto" fev1_id="fev1_id"><br>
        <label for="fev1_value">Value</label>
        <input type="number" name="fev1_value" placeholder="9867356" fev1_id="fev1_value"><br>
        <?php
            $stmt = $pdo->query("SELECT visit_id, visit_date FROM visits");
            $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="visit_id">Visit ID</label>
        <select name="visit_id" id="visit_id">
            <?php foreach($visits as $visit) : ?>
                <option value="<?php echo $visit['visit_id']; ?>"><?php echo $visit['visit_id'].' on '.$visit['visit_date'];?></option>
                <?php endforeach; ?>
            </select> <br>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
