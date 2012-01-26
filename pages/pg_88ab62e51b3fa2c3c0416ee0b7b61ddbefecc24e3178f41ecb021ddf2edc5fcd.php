<?php
$user = new User;
$form = new Forms;

if(isset($_POST['submitLogin'])){
  $user->login($_POST['username'],$_POST['password']);
} else {
  $form->login();
}

?>
