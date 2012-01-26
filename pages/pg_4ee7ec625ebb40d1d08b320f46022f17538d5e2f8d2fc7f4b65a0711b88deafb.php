<?php
echo "
WELCOME TO THE SITE - 
<a href='./index.php?req=logout'>Logout</a>
";

require_once("class/cls.user.php");
$user = new User;	
echo $user->admin;
?>

