<?php
/**
 * PHPUnit bootstrap for hypeDirectory plugin tests.
 * Plugin must be installed at {elgg_root}/mod/hypedirectory/
 */

// tests/ -> mod/hypedirectory/ -> mod/ -> elgg_root/
$elggRoot = dirname(__DIR__, 3);

require_once $elggRoot . '/vendor/autoload.php';

// Load Elgg test classes (UnitTestCase, IntegrationTestCase, etc.)
$testClassesDir = $elggRoot . '/vendor/elgg/elgg/engine/tests/classes';
spl_autoload_register(function ($class) use ($testClassesDir) {
    $file = $testClassesDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load plugin autoloader
$pluginRoot = dirname(__DIR__);
if (file_exists($pluginRoot . '/vendor/autoload.php')) {
    require_once $pluginRoot . '/vendor/autoload.php';
}
if (file_exists($pluginRoot . '/autoloader.php')) {
    require_once $pluginRoot . '/autoloader.php';
}

// Manually register plugin PSR-0 classes so tests work even if plugin is inactive
spl_autoload_register(function ($class) use ($pluginRoot) {
    $prefix = 'hypeJunction\\Directory\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = $pluginRoot . '/classes/hypeJunction/Directory/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

\Elgg\Application::loadCore();
