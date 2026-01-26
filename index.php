<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Disesuaikan untuk Shared Hosting
 * 
 * STRUKTUR FOLDER DI HOSTING:
 * 
 * public_html/
 * ├── index.php         ← file ini
 * ├── .htaccess
 * ├── css/
 * ├── js/
 * ├── images/
 * │
 * ├── app/
 * ├── bootstrap/
 * ├── config/
 * ├── database/
 * ├── resources/
 * ├── routes/
 * ├── storage/
 * ├── vendor/
 * └── .env
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);