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

    private Request $request ;
    private View $view;
    private Database $database;

    public static function initConfiguration(array $configuration):void
    {
    self::$configuration = $configuration;
    }

    public function __construct(Request  $request)
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
                $page = 'create';
                if($this->request->hasPost()){
                    if($this->database->createNote([
                        'title' => $this->request->postParam('title'),
                        'description' => $this->request->postParam('description')
                    ])){
                        header("Location:./?before=created");
                    } else {
                        header("Location:./?error=creationError");
                    }
                    exit;
                }
                break;
            case 'show':
                $page='show';
                $id = (int) $this->request->getParam('id');

                if(!$id){
                    header("Location:./?error=missingNoteId");
                    exit;
                }

                try {
                    $note = $this->database->getNote($id);
                } catch (NotFoundException $e){
                    header("Location: ./?error=noteNotFound");
                    exit;
                }

                $viewParams = [
                    'note' => $note,
                ];
                break;
            case 'list':
                $page = "list";
                $viewParams = [
                    'before' => $this->request->getParam('message'),
                    'error' => $this->request->getParam("error"),
                    'notes' =>  $this->database->getNotes()
                ];
                break;
                default:
                    $page = 'page404';
                    break;
        }

        $this->view->render($page, $viewParams ?? []);
    }

    private function action():string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

}