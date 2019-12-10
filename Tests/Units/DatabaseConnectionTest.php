<?php

namespace Tests\Units;
use App\Contracts\DatabaseConnectionInterface;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class DataBaseConnectionTest extends TestCase
{
    public function testItThrowMissingArgumentExceptionWithWrongCredentialsKeys()
    {
        self::expectException(MissingArgumentException::class);
        $credentials = [];
        $pdoHandler = new PDOConnection($credentials);
        
    }

    public function testItCanConnectToDatabaseWithPdoApi()
    {
        $credentials = $this->getCredentials('pdo');
        $pdoHandler = (new PDOConnection($credentials))->connect();
        self::assertInstanceOf(DatabaseConnectionInterface::class, $pdoHandler);
        return $pdoHandler;
    }

    //** @depends testItCanConnectToDatabaseWithPdoApi */

    public function testItIsValidPdoConnection(DatabaseConnectionInterface $handler)
    {
        self::assertInstanceOf(\PDO::class, $handler->getConnection());
    }

    private function getCredentials(string $type)
    {
        return array_merge(
            Config::get('database', $type), 
            ['name' => 'blog_testing']
        );
    }
}