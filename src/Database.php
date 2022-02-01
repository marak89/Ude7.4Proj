<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(array $config)
    {
        $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
        $connection = new PDO($dsn,$config['username'],$config['password']);
        dump($connection);
    }
}