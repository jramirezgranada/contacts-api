<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

use App\Models\Database;

new Database();

require __DIR__ . '/routes/api.php';