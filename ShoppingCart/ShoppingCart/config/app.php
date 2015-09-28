<?php
$cnf['default_controller'] = 'Index';
$cfn['default_method'] = 'index2';
$cnf['namespaces']['Controllers'] =  'C:\XAMPP\xampp\htdocs\ShoppingCart\ShoppingCart\controllers';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'native'; //native, database
$cnf['session']['name'] = '_sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;
$cnf['session']['dbConnection'] = 'default';
$cnf['session']['dbTable'] = 'sessions';
return $cnf;