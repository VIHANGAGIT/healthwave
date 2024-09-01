<?php
    // Database params
    define('DB_HOST', 'localhost');
    define('DB_USER', // <<YOUR DB USERNAME>>);
    define('DB_PASS', // <<YOUR DB PASS>>);
    define('DB_NAME', // <<YOUR DB NAME>>);


    // App root

    // __FILE__ gives the path to this file, but we need app root
    // Taken using dirname which gives parent directory's path
    // Add it as a constant to access it anywhere
    define('APPROOT', dirname(dirname(__FILE__)));

    // URL root
    define('URLROOT', 'http://localhost/healthwave');

    // Site name
    define('SITENAME', 'HealthWave');

    // App version
    define('VERSION', '1.0.0');
