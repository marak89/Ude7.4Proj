<?php

declare(strict_types=1);

namespace App;

require_once ("src/View.php");

class Controller
{
    public function run(string $action):void
    {

        $view = new View();
        $viewParams = [];

        switch($action) {
            case 'create':
                $page = "create";
                $created = false;

                if (!empty($_POST)) {
                    $created = true;
                    $viewParams = [
                        'title' => $_POST['title'] ?? null,
                        'description' => $_POST['description'] ?? null
                    ];
                    dump($viewParams);
                }

                $viewParams['created'] = $created;
                $viewParams['resultCreate'] = "udało się";
                break;
            case 'show':

                break;
            default:
                $page = "list";
                $viewParams['resultList'] = "Wyświetlamy notatki";
                break;
        }

        $view->render($page, $viewParams);
    }

}