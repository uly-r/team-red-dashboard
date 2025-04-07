<?php

// Load environment variables from the .env file
$env = parse_ini_file(__DIR__ . '/../.env');


//define() is used to define a constant and can be accessed from anywhere in the script
define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS',  $env['DB_PASS']);
?>