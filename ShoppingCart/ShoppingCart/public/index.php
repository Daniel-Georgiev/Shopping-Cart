<?php

include '../../Framework/App.php';

$app = \Framework\App::getInstance();
echo $app->getConfig()->app;
$app->run();
new \Framework\Test();