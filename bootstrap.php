<?php
define('BASE_URL_PATH', '/');
require_once __DIR__ . '/src/library.php';
require_once __DIR__ . '/vendor/Psr4AutoloaderClass.php';
$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('CT275\Labs', __DIR__ . '/src');

try {
    $PDO = (new CT275\Labs\PDOFactory)->create([
        'dbhost' => '127.0.0.1',
        'dbname' => 'ct275_project',
        'dbuser' => 'root',
        'dbpass' => ''
    ]);
} catch (Exception $e) {
    echo 'Không thể kết nối đến MySQL! Kiểm tra lại username và password đến MySQL.<br>';
    exit("<pre>${e}</pre>");
}
