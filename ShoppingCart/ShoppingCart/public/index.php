<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../Framework/App.php';

$app = \Framework\App::getInstance();
$app->run();

$db = new \Framework\DB\SimpleDb();
$a = $db->prepare("SELECT * FROM users")->execute()->fetchAllAssoc();
var_dump($a);
new \Framework\Test();