<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;

class Database
{
    public PDO $connection;
    private \PDOStatement $stmt;

    public function __construct(
        string $driver,
        array $config,
        string $username,
        string $password
    ) {
        $config = http_build_query(data: $config, arg_separator: ';');
        $dsn = "{$driver}:{$config}";

        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param string $query
     * @param array $params
     * @return Database
     * @throws PDOException
     */
    public function query(string $query, array $params): Database
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);
        return $this;
    }

    public function fetch(): array|false
    {
        return $this->stmt->fetch();
    }

    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function count(): int
    {
        return $this->stmt->fetchColumn();
    }

    public function fetchAll(): array
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }
}