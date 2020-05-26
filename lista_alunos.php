<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . "/banco.sqlite";
$pdo = new PDO("sqlite:" . $databasePath);

$statement = $pdo->query('SELECT * FROM students; ');
// quando queremos buscar uma linha, podemos utilizar com fetch ao inves de fetchAll
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

$studentList = [];
// echo $studentDataList[0]['name'] . PHP_EOL;
// echo $studentDataList[0]['id'];

foreach ($studentDataList as $student ) {

    $studentList[] = new Student(
        $student["id"],
        $student["name"],
        new \DateTimeImmutable($student["birth_date"])
    );

}

var_dump($studentList) . PHP_EOL;

$studentDataColumn = $pdo->query('SELECT * FROM students WHERE id = 1;');
$studentColumn =  $studentDataColumn->fetchColumn(2);
var_dump($studentColumn) . PHP_EOL;