<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Repository\StudentRepository;
use PDO;
use Alura \Pdo\Infrastructure\Persistance\ConnectionCreator;

class PdoStudentRepository implements StudentRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students;');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function birthDateAt(\DateTimeInterface $birthDate): array
    {
        $sqlSearch = 'SELECT * FROM students WHERE birth_date = :birth_date;';
        $statement = $this->connection->prepare($sqlSearch);
        $statement->bindValue(':birth_date',$birthDate);

        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function saveStudent(Student $student): bool
    {
        if($student->id() === null){
           return $this->insert($student);
        }
        
        return $this->update($student);
        
    }

    public function insert(Student $student){

        $sqlInsert = "INSERT INTO students(name,birth_date) VALUES(:nome, :data_nasc);";
        $statement = $this->connection->prepare($sqlInsert);
        $statement->bindValue(":nome", $student->name());
        $statement->bindValue(":data_nasc", $student->birthDate()->format('Y-m-d'));
        $success = $statement->execute();
        if ($success){
            $student->defineId($this->connection->lastInsertId());
        }
        return $success;
    }

    public function update(){

        $sqlUpdate = "UPDATE students SET name = :name, birth_date = :data_nasc WHERE id = :id;";
        $statement = $this->connection->prepare($sqlUpdate);
        $statement->bindValue(":name", $student->name());
        $statement->bindValue(":data_nasc", $student->birthDate()->format('Y-m-d'));
        $statement->bindValue(":id", $student->id());

        return $statement->execute();

    }

    public function removeStudent(Student $student): boll
    {
        $sqlDelete = "DELETE FROM students WHERE id =:id";
        $statement = $this->connection->prepare($sqlDelete);
        $statement->bindValue(":id", $student->id());

        return $statement->execute();
    }

}