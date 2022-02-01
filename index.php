<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use Throwable;

require_once('src/Utils/debug.php');
require_once("src/Controller.php");

$configuration = require_once ("config/config.php");

try {
    Controller::initConfiguration($configuration);
    (new Controller(['get' => $_GET, 'post' => $_POST]))->run();
} catch (AppException $ae){
    $errInfo = $ae->getMessage();
    echo "<h1>Wystąpił błąd w aplikacji!</h1>";
    echo"<pre>$errInfo</pre>";
} catch (Throwable $e){
    echo "<h1>Wystąpił błąd w aplikacji!</h1>";
    dump($e->getMessage());
}