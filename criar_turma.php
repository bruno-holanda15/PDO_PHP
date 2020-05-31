<?php

use Alura\Pdo\Domain\Model\Student;
use Alura \Pdo\Infrastructure\Persistance\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($connection);
$connection->beginTransaction();

$aStudent = new Student(
    null,
    'Thiago Iorc',
    new \DateTimeImmutable('1998-02-03')
);
$repository->saveStudent($aStudent);

$anotherStudent = new Student(
    null,
    'Kelly Slater',
    new \DateTimeImmutable('1983-12-23')
);
$repository->saveStudent($anotherStudent);

$connection->commit();
