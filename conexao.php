<?php

$databasePath = __DIR__ . "/banco.sqlite";

// PDO é uma Interface para podermos acessar diferentes tipos de banco de dados, cada um com seu driver especifico
$pdo = new PDO("sqlite:" . $databasePath);

echo "Conectei";

$pdo->exec('CREATE TABLE students (
                id INTEGER PRIMARY KEY,
                name TEXT,
                birth_date TEXT            
)');
