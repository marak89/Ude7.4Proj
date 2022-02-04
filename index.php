<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use Throwable;

require_once('src/Utils/debug.php');
require_once("src/Controller.php");
require_once("src/Request.php");
require_once("src/Exception/AppException.php");

$configuration = require_once ("config/config.php");

$request = new Request($_GET,$_POST);

try {
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
} catch (AppException $ae){
    $errInfo = $ae->getMessage();
    echo "<h1>Wystąpił błąd w aplikacji!</h1>";
    echo"<pre>$errInfo</pre>";
} catch (Throwable $e){
    echo "<h1>Wystąpił błąd w aplikacji!</h1>";
    dump($e->getMessage());
}