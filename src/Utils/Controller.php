<?php

declare(strict_types=1);

namespace App;

require_once ("src/View.php");

class Controller
{

    private const DEFAULT_ACTION = 'list';

    private array $postData ;
    private array $getData;

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
    }


    public function run():void
    {
        $action = $_GET['action'] ?? self::DEFAULT_ACTION;
        $view = new View();
        $viewParams = [];

        switch($action) {
            case 'create':
                $page = "create";
                $created = false;

                if (!empty($this->postData)) {
                    $created = true;
                    $viewParams = [
                        'title' => $this->postData['title'] ?? null,
                        'description' => $this->postData['description'] ?? null
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