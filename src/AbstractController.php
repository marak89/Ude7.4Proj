<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;

require_once  ("Exception/ConfigurationException.php");
require_once ("Database.php");
require_once("View.php");


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