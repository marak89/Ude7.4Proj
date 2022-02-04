<?php

declare(strict_types=1);

namespace App;
require_once  ("Exception/ConfigurationException.php");
require_once ("Database.php");
require_once("View.php");

use App\Request;
use Throwable;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;



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

    public function createAction(): void
    {
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
        $this->view->render( 'create');
    }

    public function showAction():void
    {
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
        $this->view->render('show', ['note' => $note]);
    }
    public function listAction():void
    {
        $this->view->render('list', [
                'before' => $this->request->getParam('message'),
                'error' => $this->request->getParam("error"),
                'notes' =>  $this->database->getNotes()
            ]);
    }

    public function page404(){
        header("Page not found",true,404);
        $page = 'page404';
        $this->view->render($page);
    }

    public function run():void
    {
        $action = $this->action().'Action';
        if(!method_exists($this,$action)){
            $action = self::DEFAULT_ACTION . "Action";
        }
        $this->$action();
    }

    private function action():string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

}