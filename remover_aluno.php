<?php

use Alura\Pdo\Domain\Model\Student;
use Alura \Pdo\Infrastructure\Persistance\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->prepare("DELETE FROM students WHERE id = :id");
$statement->bindValue(":id",3, PDO::PARAM_INT);

var_dump($statement->execute());