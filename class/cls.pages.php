<?php
require_once("/var/www/mp/class/cls.fpdfix.php");
$page = new Page;

class Page {
  function getPageInfo($pageName){
    $general = new General;
    $conf = new Conf;
    $pageName = $general->cleanInput($pageName);
    $testHash = $general->makeHash($pageName,$conf->page['salt']);
    $sql = mysql_query("SELECT id,admin FROM `pages` WHERE pageHash='$testHash'");
    if(mysql_numrows($sql) != 0){
      $row = mysql_fetch_array($sql);
      return $row;
    } else {
      return -1;
    }
  }

  function loadPage($request){
    $conf = new Conf;
    $general = new General;
    $hash = $general->makeHash($request,$conf->page['salt']);
    include("pages/pg_$hash.php");
  }


};
?>
