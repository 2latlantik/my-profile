<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

// Load cached env vars if the .env.local.php file exists
if (is_array($env = @include dirname(__DIR__).'/.env.local.php')) {
    foreach ($env as $k => $v) {
        $_ENV[$k] = $v;
        putenv("$k=$v");
    }
} elseif (class_exists(Dotenv::class)) {
    (new Dotenv())->usePutenv()->loadEnv(dirname(__DIR__).'/.env');
}

$env = $_ENV['APP_ENV'] ?? 'dev';
$debug = (bool) ($_ENV['APP_DEBUG'] ?? true);

if ($debug) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
