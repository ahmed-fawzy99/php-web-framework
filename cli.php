<?php

use Framework\Database;

include __DIR__ . '/src/Framework/Database.php';
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database(
    'mysql',
    [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'dbname' => $_ENV['DB_DATABASE']
    ],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);


$sqlFile = file_get_contents(__DIR__ . '/database.sql');

$db->connection->query($sqlFile);



