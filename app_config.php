<?php 
//application folder name on your web root or htdocs folder
define('APP_ROOT',$_SERVER['DOCUMENT_ROOT']);
//DEBUG echo (APP_ROOT)."      <br>";
define('APP_FOLDER_NAME', '/myCrud');
define('WEB_ROOT','http://'.$_SERVER['SERVER_NAME']);
//DEBUG echo(WEB_ROOT);
define('DSN1', 'mysql:host=localhost;dbname=phpcrud');
define('USER1','root');
define('PASSWD1','');
?>
