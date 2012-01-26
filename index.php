<title>asdf</title>
<?php
// still a few bits to touch up, like the page permissions for buyer, seller, admin..
// will note up more later

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include("class/cls.conf.php"); //echo 'conf<br />';
include("class/cls.sql.php"); //echo 'sql<br />';
include("class/cls.forms.php"); //echo 'forms<br />';
include("class/cls.functions.php");// echo 'functions<br />';
include("class/cls.pages.php");// echo 'pages<br />';
include("class/cls.user.php"); //echo 'user<br />';

$user->buildSession($_SESSION['id']);

$page->loadPage($user->request);


?>

