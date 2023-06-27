<?php

declare(strict_types=1);

namespace Application\Student\Handlers;

use Application\Student\Commands\GetStudent;
use Domain\Student\Student;

class GetStudentHandler extends StudentHandler
{
    /**
     * @param GetStudent $command
     *
     * @return Student|null
     */
    public function execute(GetStudent $command) : ?Student
    {
        return $this->repository->find($command->studentId);
    }
}
