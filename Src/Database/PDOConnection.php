<?php

namespace App\Database;
use App\Contracts\DatabaseConnectionInterface;
use PDOException, PDO;

class PDOConnection extends AbstractConnection implements DatabaseConnectionInterface
{
    const REQUIRED_CONNECTION_KEYS = [
        'driver',
        'host',
        'name',
        'user',
        'password',
        'default_fetch',
    ];

    public function connect(): PDOConnection
    {
        $credentials = $this->getConnection($this->credentials);
        try {
            $this->connection = new PDO(...$credentials);        
        } catch (PDOException $exception) {

        }
        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    protected function parseCredentials(array $credentials): array 
    {
        $dsn = sprintf(
            '%s:host=%s;name=%s',
            $credentials['driver'],
            $credentials['host'],
            $credentials['name']

        );
        return [$dsn, $credentials['user'], $credentials['password']];
    }
}