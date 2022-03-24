<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;
use App\Request;
use App\View;
use App\Model\Database;
abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'list';

    protected static array $configuration = [];

    protected Request $request ;
    protected View $view;
    protected Database $database;

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
        try {
            $action = $this->action() . 'Action';
            if (!method_exists($this, $action)) {
                $action = self::DEFAULT_ACTION . "Action";
            }
            $this->$action();
        } catch (StorageException|NotFoundException $e) {
            $this->view->render(
                'error',
                ['message' => $e->getMessage()]
            );
        }

    }

    private function action():string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    protected function redirect(string $to, array $params): void{
        $location = $to;
        if(count($params)){
            $queryParams = [];
            foreach ($params as $key => $value){
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
            $queryParams = implode('&',$queryParams);
            $location .= '?'.$queryParams;
        }
        header('Location:' . $location);
        exit;
    }

}