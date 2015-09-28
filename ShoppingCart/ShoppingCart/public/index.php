<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../../Framework/App.php';

$app = \Framework\App::getInstance();
$app->run();
$app->getSession()->counter2+=1;
echo $app->getSession()->counter2;

