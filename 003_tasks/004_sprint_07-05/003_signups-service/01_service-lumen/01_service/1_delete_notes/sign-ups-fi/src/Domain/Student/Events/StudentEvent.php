<?php

namespace Domain\Student\Events;

use Domain\Events\DomainEvent;
use Domain\Student\Student;

abstract class StudentEvent extends DomainEvent
{

    public const NAME = 'student_event';

    /**
     * @var Student The Email associated to the event
     */
    public Student $student;

    /**
     * Default Constructor
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        parent::__construct();
        $this->student = $student;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'student'=> [
                    'uuid' => (string) $this->student->getId(),
                ] + $this->student->toArray()
        ];
    }
}
