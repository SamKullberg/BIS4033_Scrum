<?php
@include_once('../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// include 'functions.php';
// Your PHP code here.

// Home Page template below.
?>

<?=template_header('Home')?>

<div class="content">
	<h2>Home</h2>
	<p>Welcome to the ACME Medical records page! You can find your medical records here.</p>
</div>

<?=template_footer()?>
