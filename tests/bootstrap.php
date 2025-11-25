<?php
/**
 * PHPUnit Bootstrap File
 * Sets up the testing environment
 */

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Set error reporting for tests
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set timezone
date_default_timezone_set('UTC');

// Define test constants
define('TEST_MODE', true);
define('PROJECT_ROOT', dirname(__DIR__));
define('CONFIG_PATH', PROJECT_ROOT . '/Config');

// Prevent session auto-start in tests
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Mock $_SERVER variables for tests
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';

// Test database configuration (you can override in individual tests)
define('TEST_DB_HOST', 'localhost');
define('TEST_DB_USER', 'root');
define('TEST_DB_PASS', '');
define('TEST_DB_NAME', 'shop_test'); // Use separate test database

echo "PHPUnit Bootstrap loaded successfully.\n";
