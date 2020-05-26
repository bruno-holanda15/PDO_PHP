<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO("sqlite:" . $databasePath);

$student = new Student(
    null,
    "Marcelo Holanda', ''); DROP TABLE students;",
    new \DateTimeImmutable('1967-11-24')
);

$sqlInsert = "INSERT INTO students(name,birth_date) VALUES(:nome, :data_nasc);";

$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(":nome", $student->name());
$statement->bindValue(":data_nasc", $student->birthDate()->format('Y-m-d'));

if($statement->execute()){
    echo "aluno incluido";
}else{
    echo "aluno nao incluido";
}
