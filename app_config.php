<?php 
// Application folder name on your web root or htdocs folder
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT']);

// Define your application folder name
define('APP_FOLDER_NAME', '/myCrud');

// Define your web root (domain)
define('WEB_ROOT', 'http://' . $_SERVER['SERVER_NAME']);

// Update the DSN to point to the BIS4033Scrum database
define('DSN1', 'mysql:host=localhost;dbname=BIS4033Scrum');

// MySQL username and password
define('USER1', 'root');       // Or replace with your actual MySQL user, e.g., 'kermit'
define('PASSWD1', '');         // Update if your MySQL user has a password
?>
