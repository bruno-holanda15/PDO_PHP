<?php

use Alura\Pdo\Domain\Model\Student;
use Alura \Pdo\Infrastructure\Persistance\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$list = $repository->studentsWithPhones();
var_dump($list);
