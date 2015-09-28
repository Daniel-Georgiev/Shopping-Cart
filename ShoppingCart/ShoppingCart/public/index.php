<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../Framework/App.php';

$app = \Framework\App::getInstance();
$app->run();

var_dump($app->getConnection());
new \Framework\Test();