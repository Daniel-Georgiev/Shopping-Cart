<?php
$cnf['default']['connection_uri'] = 'mysql:host=localhost;dbname=test';
$cnf['default']['username'] = 'root';
$cnf['default']['pass'] = '';
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES UTF8";
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
return $cnf;