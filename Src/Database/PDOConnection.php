<?php


namespace App\Database;


use App\Contracts\DatabaseConnectionInterface;
use App\Exception\DatabaseConnectionException;
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
        $credentials = $this->parseCredentials($this->credentials);
        try{
            $this->connection = new PDO(...$credentials);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                $this->credentials['default_fetch']
            );
        }catch (PDOException $exception){
            throw new DatabaseConnectionException($exception->getMessage(), $this->credentials, 500);
        }
        return $this;
    }

    public function getConnection(): PDO
    {
       return $this->connection;
    }

    protected function parseCredentials(array $credentials): array
    {
        $dsn = sprintf(
            '%s:host=%s;dbname=%s',
            $credentials['driver'],
            $credentials['host'],
            $credentials['name']
        );

        return [$dsn, $credentials['user'], $credentials['password']];
    }
}