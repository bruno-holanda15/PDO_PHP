<?php 

namespace Alura\Pdo\Repository;

use Alura\Pdo\Domain\Model\Student;

interface StudentRepository
{
    public function allStudents(): array;
    public function birthDateAt(\DateTimeInterface $birthDate): array;
    public function saveStudent(Student $student): bool;
    public function removeStudent(Student $student): boll;
}