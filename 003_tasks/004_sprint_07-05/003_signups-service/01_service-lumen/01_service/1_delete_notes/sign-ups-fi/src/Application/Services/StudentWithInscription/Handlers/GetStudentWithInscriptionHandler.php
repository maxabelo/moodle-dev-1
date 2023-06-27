<?php

namespace Application\Services\StudentWithInscription\Handlers;

use Application\Services\StudentWithInscription\Commands\GetStudentWithInscription;

class GetStudentWithInscriptionHandler extends StudentWithInscriptionHandler
{

    /**
     * @param GetStudentWithInscription $command
     * @return \Domain\Student\Student|null
     */
    public function execute(GetStudentWithInscription $command)
    {

        $student = $command->getStudentWithInscription($this->studentRepository, $this->inscriptionRepository, $command->studentId);

        return $student;
    }

}
