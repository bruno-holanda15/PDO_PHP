<?php

$databasePath = __DIR__ . "/banco.sqlite";

// PDO é uma Interface para podermos acessar diferentes tipos de banco de dados, cada um com seu driver especifico
$pdo = new PDO("sqlite:" . $databasePath);

echo "Conectei" . PHP_EOL;

$createSql = ' CREATE TABLE IF NOT exists students (
                    id INTEGER PRIMARY KEY,
                    name TEXT,
                    birth_date TEXT
                );

                CREATE TABLE IF NOT exists phones (
                    id INTEGER PRIMARY KEY,
                    area_code TEXT,
                    number TEXT,
                    student_id INTEGER,
                    FOREIGN KEY(student_id) REFERENCES students(id)
                );
';

$pdo->exec($createSql);
