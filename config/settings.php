<?php

// Error reporting for production
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/Berlin');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';
// Console commands
$settings['commands'] = [
    \App\Infrastructure\CLI\ContractCommand::class,
];

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

$settings['db']['host'] = 'mysql';
$settings['db']['database'] = 'signaturit';

$settings['db']['username'] = 'dh_user_test';
$settings['db']['password'] = '*43i0;l+6=7:*lA';

$settings['db']['charset'] = 'utf8mb4';


return $settings;