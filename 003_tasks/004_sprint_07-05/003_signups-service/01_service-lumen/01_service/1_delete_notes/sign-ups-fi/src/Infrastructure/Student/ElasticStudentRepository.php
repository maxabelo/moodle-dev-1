<?php

declare(strict_types=1);

namespace Infrastructure\Student;

use Infrastructure\Common\Repository\ElasticRepository;
use Infrastructure\Common\Repository\HasPaginator;
use Domain\Student\Student;
use Domain\Student\StudentId;
use Domain\Student\StudentRepository;

class ElasticStudentRepository extends ElasticRepository implements 
    StudentRepository
{
    use HasPaginator;

    protected $index = 'students';

    /**
     * @inheritDoc
     */
    public function find(StudentId $id) : ?Student
    {
        $record = $this->get((string) $id);

        return Student::make($id, $record['_source']);
    }

    /**
     * @inheritDoc
     */
    public function findOrCreate($id, array $data = []) : Student
    {
        $StudentId = StudentId::fromId($id);
        
        try{
            return $this->find($StudentId);
        }
        catch(\Throwable $e){
            return Student::create($StudentId, $data);
        }
    }

    /**
     * @inheritDoc
     */
    public function save(Student $Student) : Student
    {   
        $this->index(
            $Student->toArray(), (string) $Student->getId()
        );

        return $Student;
    }

    /**
     * @inheritDoc
     */
    public function all(array $query) : iterable
    {
        // @version 1.0: Sorted by desc created date, by default.
        $query['sort'] = ['created_at'=> ['order'=> 'desc']];

        $results = $this->search($query);

        foreach ($results['hits'] as $record){
            $list[] = Student::make($record['_id'], $record['_source']);
        }

        return $this->createIterable(
            $list ?? [], $query, (int) $results['total']['value']
        );
    }
}