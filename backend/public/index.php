
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();
session_start();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']); // needed of frontend is on different domain
    header("Access-Control-Allow-Credentials: true"); // nedded for sessions or tokens
} else {
    header("Access-Control-Allow-Origin: *");
}
header("Content-Type: application/json; charset=UTF-8"); // needed to return json data
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE"); // tell the client which HTTP methods are permitted 
header("Access-Control-Max-Age: 3600"); // needed to reduces repeated preflight calls. Tells browsers how long (in seconds) to cache the preflight OPTIONS response.
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Lists which custom request headers the client is allowed to send.

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load config (reads .env)
$config = require __DIR__ . '/../config/config.php';

// Boot App (DB etc.)
App\Core\App::init($config);

// Instantiate router and load routes
$router = new App\Core\Router();
require __DIR__ . '/../routes/api.php';

// Dispatch current request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
