<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO("sqlite:" . $databasePath);

$student = new Student(
    null,
    "Patricia Robin",
    new \DateTimeImmutable('1997-01-24')
);

$sqlInsert = "INSERT INTO students(name,birth_date) VALUES(:nome, :data_nasc);";

// Com prepared statements evitamos problemas com SQL Injections 
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(":nome", $student->name());
$statement->bindValue(":data_nasc", $student->birthDate()->format('Y-m-d'));

if($statement->execute()){
    echo "aluno incluido";
}else{
    echo "aluno nao incluido";
}
