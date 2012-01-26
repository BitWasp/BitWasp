<?php
require_once("/var/www/mp/class/cls.fpdfix.php");
$mysql = new MySQL;

class MySQL {

  function connect(){
    require_once("/var/www/mp/class/cls.conf.php");$conf = new Conf;
    $connect = mysql_connect($conf->sql['host'],$conf->sql['user'],$conf->sql['pass']);
    if(!$connect){
      echo "ERR1: There is a problem with the database, try again later.";
    } 

    $DB = mysql_select_db($conf->sql['db'],$connect);
    if(!$DB){
      echo "ERR2: There is a problem with the database, try again later.";
    }
  }
};

$mysql->connect();
?>
