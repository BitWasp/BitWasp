<?php
require_once("/var/www/mp/class/cls.fpdfix.php");
$general = new General;

class General {
  function cleanInput($input){
    return mysql_real_escape_string(trim($input));
  }

  function makeHash($string,$salt){
    return hash('sha256',$salt.hash('sha256',$string));
  }

  function checkRegex($in,$regex){
    $array['A|N|U'] = '/^[a-zA-Z0-9_]+$/';
    $array['A|N'] = '/^[a-zA-Z0-9]+$/';
    return preg_match($array[$regex],$in);
  }
};
?>
