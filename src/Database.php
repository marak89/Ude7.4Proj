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

    private PDO $connection;

    public function __construct(array $config)
    {
        try {
            $this->checkConfig($config);
            $this->createConnection($config);
        } catch (StorageException $e){
            throw new StorageException('Connection Error 123 : '. $e->getMessage());
        }
        catch (PDOException $e){
            throw new StorageException('Connection Error - PDO ERROR ');
        }
    }

    public function createNote(array $data):bool
    {
        try{
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $created = $this->connection->quote(date("Y-m-d H:i:s"));
            $query = "INSERT INTO notes(title, description, created) VALUES($title,$description,$created)";
            //dump($query);
            $result = $this->connection->exec($query);
            //dump($result);
            if($result){
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e){
            throw new StorageException('Nie utworzono notatki',400);
            exit();
        }
        echo "Tworzymy notatke";
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
        $this->connection = new PDO($dsn, $config['username'], $config['password'],[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    private function checkConfig($config): void
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
