<?php
require_once("/var/www/mp/class/cls.fpdfix.php");
$conf = new Conf;

class Conf {
  public $sql = Array('host' => 'localhost',
                      'user' => 'root',
                      'pass' => 'ny8ajehc',
                      'db' => 'dev');

  public $page = Array('salt' => 'W1n&x');

};
?>
