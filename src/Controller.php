<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once ("Database.php");
require_once("View.php");

class Controller
{

    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    private array $request ;
    private View $view;
    private Database $database;

    public static function initConfiguration(array $configuration):void
    {
    self::$configuration = $configuration;
    }

    public function __construct(array  $request)
    {
        if(empty(self::$configuration['db'])){
            throw new ConfigurationException('Configuration Error');
        }
        $this->database = new Database(self::$configuration['db']);
        $this->view = new View();
        $this->request = $request;
    }

    public function run():void
    {
        switch($this->action()) {
            case 'create':
                $page = "create";

                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $viewParams = [
                        'title' => $data['title'] ?? null,
                        'description' => $data['description'] ?? null
                    ];
                    $viewParams['created'] = $this->database->createNote([
                        'title'=>$data['title'],
                        'description'=>$data['description']
                    ]);

                if($viewParams['created']){
                    header("Location:./?before=created");
                } else {
                    header("Location:./?error=creationError");
                }
                exit;
                }
                break;
            case 'show':
                $data = $this->getRequestGet();
                $page='show';
                $id = $data['id'] ?? null;

                if(!$id){
                    header("Location:./?error=missingNoteId");
                    exit;
                }

                try {
                    $note = $this->database->getNote((int)$id);
                } catch (NotFoundException $e){
                    header("Location: ./?error=noteNotFound");
                    exit;
                }

                $viewParams = [
                    'note' => $note,
                ];
                break;
            default:
                $page = "list";
                $data = $this->getRequestGet();
                $viewParams = [
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null,
                    'notes' =>  $this->database->getNotes()
                ];
                break;
        }

        $this->view->render($page, $viewParams ?? []);
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