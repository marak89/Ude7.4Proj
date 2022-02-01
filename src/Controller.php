<?php

declare(strict_types=1);

namespace App;

require_once ("Database.php");
require_once("View.php");

class Controller
{

    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    private array $request ;
    private View $view;

    public static function initConfiguration(array $configuration):void
    {
    self::$configuration = $configuration;
    }

    public function __construct(array  $request)
    {
        $db = new Database(self::$configuration['db']);
        $this->view = new View();
        $this->request = $request;
    }

    public function run():void
    {
        $viewParams = [];

        switch($this->action()) {
            case 'create':
                $page = "create";
                $created = false;

                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $created = true;
                    $viewParams = [
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null
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

        $this->view->render($page, $viewParams);
    }

    private function action():string
    {
        $get = $this->getRequestGet();
        return $get['action'] ?? self::DEFAULT_ACTION;
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

}