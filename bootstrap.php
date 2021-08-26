<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

date_default_timezone_set('Europe/Berlin');
require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration(array(__DIR__ . "/config/yaml"), $isDevMode);

$conn = array(
'host' => 'localhost',
'driver' => 'pdo_mysql',
'user' => 'root',
'password' => '',
'dbname' => 'litzlerTP06',
'port' => '3306'
);
$entityManager = EntityManager::create($conn, $config);
