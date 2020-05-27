<?php

namespace Alura\Pdo\Infrastructure\Persistance;

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . "/../../../banco.sqlite";
        
        return new PDO("sqlite:" . $databasePath);
    }

}