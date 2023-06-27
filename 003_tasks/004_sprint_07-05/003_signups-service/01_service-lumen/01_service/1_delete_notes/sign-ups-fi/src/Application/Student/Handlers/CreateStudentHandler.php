<?php

declare(strict_types=1);

namespace Application\Student\Handlers;

use Application\Student\Commands\CreateStudent;
use Domain\Student\Student;

class CreateStudentHandler extends StudentHandler
{
    /**
     * @param CreateStudent $command
     *
     * @return Student|null
     */
    public function execute(CreateStudent $command) : ?Student
    {
        $student = Student::create($command->getStudentId(), $command->getData());

        return $this->repository->save($student);
    }
}
