<?php

declare(strict_types=1);

namespace Domain\Student;

interface StudentRepository
{
    /**
     * Find Student by id (address)
     *
     * @param StudentId $id
     * @return Student
     */
    public function find(StudentId $id) : ?Student;

    /**
     * Find an Student by id (address) or Create a fresh one
     *
     * @param $id
     * @param array $data
     *
     * @return Student
     */
    public function findOrCreate($id, array $data = []) : Student;

    /**
     * Save Student
     *
     * @param Student $Student
     * @return Student
     */
    public function save(Student $Student) : Student;

    /**
     * Get All Students corresponding to the query
     *
     * @param array $query
     * @return iterable
     */
    public function all(array $query) : iterable;
}
