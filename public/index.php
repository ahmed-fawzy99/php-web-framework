<?php

$app = include __DIR__ . '/../src/App/bootstrap.php';

try {
    $app->run();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

