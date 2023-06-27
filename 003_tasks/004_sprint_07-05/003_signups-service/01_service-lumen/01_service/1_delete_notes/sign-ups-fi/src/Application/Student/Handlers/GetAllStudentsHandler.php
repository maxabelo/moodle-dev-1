<?php

declare(strict_types=1);

namespace Application\Student\Handlers;

use Application\Student\Commands\GetAllStudents;

class GetAllStudentsHandler extends StudentHandler
{
    /**
     * @param GetAllStudents $command
     *
     * @return iterable|null
     */
    public function execute(GetAllStudents $command) :? iterable
    {
        return $this->repository->all($command->getQuery());
    }
}
