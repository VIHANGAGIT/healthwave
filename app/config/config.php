<?php
    // App root

    // __FILE__ gives the path to this file, but we need app root
    // Taken using dirname which gives parent directory's path
    // Add it as a constant to access it anywhere
    define('APPROOT', dirname(dirname(__FILE__)));

    // URL root
    define('URLROOT', 'http://localhost/healthwave');

    // Site name
    define('SITENAME', 'HealthWave');