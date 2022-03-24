<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\StorageException;
use PDO;

abstract class AbstractModel
{
    protected PDO $connection;

    public function __construct($config)
    {
        try {
            $this->checkConfig($config);
            $this->createConnection($config);
        } catch (StorageException $e) {
            throw new StorageException('Connection Error 123 - Storage Exception : ' . $e->getMessage());
        } catch (PDOException $e) {
            throw new StorageException('Connection Error - PDO ERROR ');
        }
    }

    protected function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
        $this->connection = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    protected function checkConfig($config): void
    {
        if (empty($config['dbname']))
            throw new StorageException('not find dbname parametr');

        if (empty($config['host']))
            throw new StorageException('not find host parametr');

        if (empty($config['username']))
            throw new StorageException('not find username parametr');

        if (empty($config['password']))
            throw new StorageException('not find password parametr');
    }
}