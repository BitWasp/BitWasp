<?php
require_once("/var/www/mp/class/cls.fpdfix.php");
$forms = new Forms;

class Forms {
  function login(){
    echo "<form action='".$_SERVER['PHP_SELF']."?req=login' name='login' method='post'>
Username:<br />
<input type='text' name='username' value='' /><br />
<br />
Password:<br />
<input type='password' name='password' value='' /><br />
<input type='submit' name='submitLogin' value='Login' />";
  }


  function register(){
    echo "<form action='".$_SERVER['PHP_SELF']."?req=register' name='register' method='post'>
Username:<br />
<input type='text' name='username' value='' /><br />
<br />
Password:<br />
<input type='password' name='password1' value='' /><br />
<br />
Password (again): <br />
<input type='password' name='password2' value='' /><br />
<br />
Secret Question: <br />
<input type='text' name='secret_Q' value='' /><br />
<br />
Secret Answer: <br />
<textarea name='secret_A'></textarea><br />
<br />
<input type='submit' name='submitRegister' value='Register' />
</form>";
  }
};

?>
