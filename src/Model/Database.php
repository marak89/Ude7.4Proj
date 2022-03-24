<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use \PDOException;
use \Throwable;
use \PDO;


class Database extends AbstractModel implements ModelInterface
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function delete(int $id): void
    {

        $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
        try {
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało sie usunac notatki');
        }
    }

    public function edit(int $id, array $note): bool
    {
        $title = $this->connection->quote($note['title']);
        $description = $this->connection->quote($note['description']);
        $query = "
        UPDATE notes
        SET title = $title, description = $description
        WHERE id = $id
        ";
        try {
            return (bool)$this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się zaktualizować notatki");
        }
    }

    public function get(int $id): array
    {
        try {
            $query = "SELECT * FROM notes where id = $id;";
            $note = ($this->connection->query($query))->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać danych o notatce', 400, $e);
        }

        if (!$note) {
            throw new NotFoundException('Nie ma notatki o id: ' . $id);
        }

        return $note;
    }

    public function count(string $phrase = null): int
    {
        try {
            $query = "
        SELECT count(*) as cnt FROM notes ";

            if (is_string($phrase)) {
                $query .= " WHERE `description` LIKE '%$phrase%' OR `title` LIKE '%$phrase%' ";
            }

            $result = $this->connection->query($query);
            return (int)$result->fetch(PDO::FETCH_ASSOC)['cnt'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać danych o liczbie notatek', 400, $e);
        }
    }

    public function list(
        int    $pageNumber,
        int    $pageSize,
        string $sortBy,
        string $sortOrder,
        string $phrase = null
    ): array
    {
        return $this->findBy($pageNumber,$pageSize,$sortBy,$sortOrder,$phrase);
    }

    public function create(array $data): bool
    {
        try {
            $title = $this->connection->quote($data['title']);
            $description = $this->connection->quote($data['description']);
            $created = $this->connection->quote(date("Y-m-d H:i:s"));
            $query = "INSERT INTO notes(title, description, created) VALUES($title,$description,$created)";
            //dump($query);
            $result = $this->connection->exec($query);
            //dump($result);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (Throwable $e) {
            throw new StorageException('Nie utworzono notatki', 400);
            exit();
        }
        echo "Tworzymy notatke";
    }

    private function findBy(
        int    $pageNumber,
        int    $pageSize,
        string $sortBy,
        string $sortOrder,
        ?string $phrase = null
    ): array
    {
        try {
            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;
            if (!in_array($sortBy, ['created', 'title'])) {
                $sortBy = 'title';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }
            $query = " SELECT id, title, created 
                        FROM notes ";
            if ($phrase) {
                $phrase = $this->connection->quote('%'.$phrase.'%',PDO::PARAM_STR);
                $query .= " WHERE `description` LIKE ($phrase) OR `title` LIKE ($phrase) ";
            }
            $query .= " ORDER BY $sortBy $sortOrder
                        LIMIT $offset, $limit";
//            var_dump($query);
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać danych o notatkach', 400, $e);
        }

    }


}
