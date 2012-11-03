<?php

include __DIR__ . '/../app/config.php';

$db = \Doctrine\DBAL\DriverManager::getConnection(array(
    'driver' => 'pdo_mysql',
    'host' => $config['server'] ? $config['server'] : 'localhost',
    'dbname' => $config['database'],
    'user' => $config['username'],
    'password' => $config['password'],
),
new \Doctrine\DBAL\Configuration());

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($db),
    'dialog' => new \Symfony\Component\Console\Helper\DialogHelper(),
));
