<?php

declare(strict_types=1);

namespace App;

require_once('src/Utils/debug.php');
require_once ("src/View.php");

const DEFAULT_ACTION = 'list';

$action = $_GET['action'] ?? DEFAULT_ACTION;
$view = new View();
$viewParams = [];
if($action === 'create'){
    $page = "create";
    $created = false;

    if(!empty($_POST)){
        $created = true;
        $viewParams = [
          'title' => $_POST['title'] ?? null,
          'description' => $_POST['description'] ?? null
        ];
        dump($viewParams);
    }

    $viewParams['created'] = $created;
    $viewParams['resultCreate'] = "udało się";
} else {
    $page = "list";
    $viewParams['resultList'] = "Wyświetlamy notatki";
}

$view->render($page, $viewParams);
