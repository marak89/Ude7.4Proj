<?php

declare(strict_types=1);

namespace App;

require_once ("Exception/AppException.php");
require_once ("Exception/StorageException.php");
require_once ("Exception/ConfigurationException.php");

use App\Exception\AppException;
use App\Exception\StorageException;
use PDOException;
use Exception;
use Throwable;
use PDO;


class Database
{
    public function __construct(array $config)
    {
        try {
            $this->checkConfig($config);
            $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
            $connection = new PDO($dsn, $config['username'], $config['password']);
        } catch (StorageException $e){
            throw new StorageException('Connection Error 123 : '. $e->getMessage());
        }
        catch (PDOException $e){
            throw new StorageException('Connection Error - PDO ERROR ');
        }
    }

    public function checkConfig($config): void
    {
        if(empty($config['dbname']))
            throw new StorageException('not find dbname parametr');

        if(empty($config['host']))
            throw new StorageException('not find host parametr');

        if(empty($config['username']))
            throw new StorageException('not find username parametr');

        if(empty($config['password']))
            throw new StorageException('not find password parametr');
    }
}
