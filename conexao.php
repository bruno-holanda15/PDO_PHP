<?php

$caminhoBanco = __DIR__ . "/banco.sqlite2";

// PDO é uma Interface para podermos acessar diferentes tipos de banco de dados, cada um com seu driver especifico
$pdo = new PDO("sqlite:" . $caminhoBanco);

echo "Conectei";