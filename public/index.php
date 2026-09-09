<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
// zaman damgasını sabit değişkene kaydeder
define('LARAVEL_START', microtime(true));

// sunucu bakımdayken framwork sayfasını hiç başltamadan bakım sayfası döndürür
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

//
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
