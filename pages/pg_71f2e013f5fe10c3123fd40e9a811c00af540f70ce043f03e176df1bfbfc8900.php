<?php
$user = new User;
$form = new Forms;

if(isset($_POST['submitRegister'])){
  $user->register($_POST['username'],$_POST['password1'],$_POST['password2'],$_POST['secret_Q'],$_POST['secret_A']);
} else {
  $form->register();
}

?>
