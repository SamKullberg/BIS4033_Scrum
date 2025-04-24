<?php
@include_once('../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Your PHP code here.
?>

<?=template_header('Home')?>

<div class="content">
    <h2>Home</h2>
    <p>Welcome to the ACME Medical Records System!</p>
    <p>This is where you can find your ACME Medical Records.</p>

    <div class="cards">
        <a href="doctors/doctors_read.php" class="dashboard-card">
            <i class="fas fa-user-md fa-2x"></i>
            <span>Doctors</span>
        </a>
        <a href="patients/patients_read.php" class="dashboard-card">
            <i class="fas fa-procedures fa-2x"></i>
            <span>Patients</span>
        </a>
        <a href="prescriptions/prescriptions_read.php" class="dashboard-card">
            <i class="fas fa-prescription-bottle-alt fa-2x"></i>
            <span>Prescriptions</span>
        </a>
    </div>
</div>

<?=template_footer()?>
