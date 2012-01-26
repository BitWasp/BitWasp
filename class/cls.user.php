<?php
//require_once("/var/www/mp/class/cls.fpdfix.php");
$user = new User;

class User {
  public $id;
  public $username;
  public $request;
  public $admin;
  public $login;

  function checkAdmin(){
    $sql = mysql_fetch_array(mysql_query("SELECT admin FROM `users` WHERE id='".$this->id."'"));
    echo $sql['admin'];
  }

  function userById($id){
    $id = $general->cleanInput($id);
    $sql = mysql_query("SELECT username FROM `users` WHERE id='$id'");
    if(mysql_numrows($sql) != 0){
      $row = mysql_fetch_array($sql);
      return $row['username'];
    } else {
      return -1;
    }
  }
 
  function displaySession(){
    echo '<br />SESSID: '.$_SESSION['id'].'<br />
ID: '.$this->id.'<br />
get request: '.$_GET['req'].'<br />
Request: '.$this->request.'<br />';
  }

  function buildSession($id){
    $pages = new Page;
    $general = new General;
    if(isset($_GET['req'])){
      $request = $general->cleanInput($_GET['req']);
    } else {
      $request = 'home';
    }

    if(!empty($id) && is_numeric($id)){
      $row = mysql_fetch_array(mysql_query("SELECT username,sessionRefresh,admin,seller FROM `users` WHERE id='$id'"));
      if((time()-$row['sessionRefresh']) > 3600){
        echo "Your session has expired. Redirecting you to the login page.<br />";
        $this->logout(10);
      } else {
        mysql_query("UPDATE `users` SET sessionRefresh='".time()."' WHERE id='$id'");
        $_SESSION['id'] = $id;
        $this->id = $id;

        $this->username = $row['username'];
        $this->admin = $row['admin'];
        $this->seller = $row['seller'];

        $pageInfo = $pages->getPageInfo($request);

        if(($pageInfo['id'] != -1) && ($pageInfo['admin'] <= $this->admin)){
          $this->request = $request;
        } else if(($pageInfo['id'] != -1) && ($pageInfo['admin'] > $this->admin)){
          $this->request = '403';
        } else {
          $this->request = '404';
        }
      }
    } else {
      $_SESSION['id'] = "guest"; 
      $this->id = 'guest';
      $this->username = 'guest';

      if(($request == 'login') || ($request == 'register')){
        $this->request = $request;
      } else {
        $this->request = 'login';
      }
    }
  }      
  

  function createSalt(){
    $salt = NULL;
    for($i = 0; $i < 11; $i++){
      $salt .= chr(rand(33,126));
    }
    return $salt;
  }

  function login($username,$password){
    $general = new General;
    $username = $general->cleanInput($username);
    $password = $general->cleanInput($password);

    $sql = mysql_query("SELECT id,hash,salt FROM `users` WHERE username='$username'");
    if(mysql_numrows($sql) != 0){
      $row = mysql_fetch_array($sql);
      $test = $general->makeHash($password,$row['salt']);
      if($test == $row['hash']){
        $_SESSION['id'] = $row['id'];
        mysql_query("UPDATE `users` SET sessionRefresh='".time()."' WHERE id='".$row['id']."'");
        $this->buildSession($row['id']);
        echo "<meta http-equiv='refresh' content='0; url=./index.php?req=home'>";
      } else {
        echo "Unable to login with these credentials<br />";
      }
    } else {
      echo "Unable to login with these credentials<br />";
    }
  }

  function register($username,$password1,$password2,$secureQ,$secureA){
    $general = new General;
    $forms = new Forms;
    $username = $general->cleanInput($username);
    $password1 = $general->cleanInput($password1);
    $password2 = $general->cleanInput($password2);
    $secureQ = htmlentities($general->cleanInput($secureQ));
    $secureA = $general->cleanInput($secureA);
    $error = array();

    if(!$general->checkRegex($username,'A|N|U'))
      array_push($error,"Username can only contain letters, numbers, and underscores.");

    if(empty($username) || empty($password1) || empty($password2) || empty($secureQ) || empty($secureA) )
      array_push($error,"Please fill out all entries on the form.");

    if(strlen($username) > 50)
      array_push($error,"Username must be less than 50 characters.");

    $checkUser = mysql_numrows(mysql_query("select id from `users` where username='$username'"));
    if($checkUser != 0)
      array_push($error,"This username is already in use.");

    if($password1 != $password2)
      array_push($error,"Your passwords do not match.");

    if(count($error) == 0){
      $salt = $this->createSalt();

      $hash = $general->makeHash($password1,$salt);
      $hashA = $general->makeHash($secureA,$salt);
      $add = mysql_query("INSERT INTO users (username,hash,salt,challenge_Q,challenge_A) VALUES ('$username', '$hash', '$salt', '$secureQ', '$hashA')");
      if($add){
        echo "User sucessfully created, please login below<br />";
        $forms->login();
      } else {
        echo "Unable to register you!<br />";
      }
    } else {
      echo "It was not possible to register you:<br />
<ul>";
      foreach($error as $text){
        echo "  <li>$text<br />";
      }
      echo "</ul>";
      $forms->register();
    }
  }

  function logout($time){
    $this->buildSession("guest");
    echo "<meta http-equiv=\"refresh\" content=\"$time; url=./index.php?req=login\">";
  }

};
?>
