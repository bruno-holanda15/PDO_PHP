<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Repository\StudentRepository;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Model\Phone;
use PDO;
use Alura \Pdo\Infrastructure\Persistance\ConnectionCreator;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    //injeção de dependência 
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students;');
        // return $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->hydrateStudentList($statement);
    }

    public function birthDateAt(\DateTimeInterface $birthDate): array
    {
        $sqlSearch = 'SELECT * FROM students WHERE birth_date = :birth_date;';
        $statement = $this->connection->prepare($sqlSearch);
        $statement->bindValue(':birth_date',$birthDate);

        if($statement->execute()){
            // return $statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->hydrateStudentList($statement);
        }
    }

    // hidratar , padrão que transfere dado de uma camada para outra, podemos ver que estamos recebendo dados da camada do banco de dados , pelo metodo fetchALl, e passando para a camada da regra de négocio desenvolvida 

    public function hydrateStudentList(\PDOStatement $statement ): array
    {
        $studentDataList = $statement->fetchAll();
        // não é necessário passar PDO::FETCH_ASSOC pq já setei esse atributo na hora de criar a conexão , ConnectionCreator
        $studentList = [];
        
        foreach ($studentDataList as $student ) {
            $student = new Student(
                $student['id'],
                $student['name'],
                new \DateTimeImmutable($student['birth_date'])
            );

            $this->fillPhonesOf($student);

            $studentList[] = $student;
        }    
        

        return $studentList;
    }

    private function fillPhonesOf(Student $student): void
    {
        $sqlPhones = "SELECT id, area_code, number FROM phones where student_id = :id ";
        $statement = $this->connection->prepare($sqlPhones);
        $statement->bindValue(":id", $student->id(),PDO::PARAM_INT);
        $statement->execute();

        $phonesDatalist = $statement->fetchAll();
        
        foreach ($phonesDatalist as $phoneData) {
            $phone = new Phone(
                $phoneData['id'],
                $phoneData['area_code'],
                $phoneData['number']
            );

            $student->addPhone($phone);
        }

    }

    public function saveStudent(Student $student): bool
    {
        if($student->id() === null){
           return $this->insert($student);
        }
        
        return $this->update($student);
        
    }

    public function insert(Student $student): bool
    {

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

    public function update(): bool
    {

        $sqlUpdate = "UPDATE students SET name = :name, birth_date = :data_nasc WHERE id = :id;";
        $statement = $this->connection->prepare($sqlUpdate);
        $statement->bindValue(":name", $student->name());
        $statement->bindValue(":data_nasc", $student->birthDate()->format('Y-m-d'));
        $statement->bindValue(":id", $student->id());

        return $statement->execute();

    }

    public function removeStudent(Student $student): bool
    {
        $sqlDelete = "DELETE FROM students WHERE id =:id";
        $statement = $this->connection->prepare($sqlDelete);
        $statement->bindValue(":id", $student->id());

        return $statement->execute();
    }

}