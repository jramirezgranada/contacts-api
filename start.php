<?php

require 'vendor/autoload.php';
require 'config/database.php';

use Models\Database;

new Database();

require 'routes/api.php';