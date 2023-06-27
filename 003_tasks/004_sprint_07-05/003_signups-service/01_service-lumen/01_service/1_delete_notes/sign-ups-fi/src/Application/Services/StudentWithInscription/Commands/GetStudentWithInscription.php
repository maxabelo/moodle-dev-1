<?php

namespace Application\Services\StudentWithInscription\Commands;

use Domain\Services\StudentWithInscription\StudentWithInscriptionService;
use Domain\Student\Student;
use Domain\Student\StudentId;

class GetStudentWithInscription
{

    /**
     * @var StudentId|\Ddd\Domain\ValueObjects\Id|\Ddd\Domain\ValueObjects\Uuid|null
     */
    public ?StudentId $studentId;

    public function __construct($studentId)
    {
        $this->studentId = StudentId::fromId($studentId);
    }

    /**
     * @param $studentRepository
     * @param $inscriptionRepository
     * @param $studentId
     *
     * @return Student|null
     */
    public function getStudentWithInscription($studentRepository, $inscriptionRepository, $studentId)
    {

        return (new StudentWithInscriptionService($studentRepository, $inscriptionRepository, $studentId))->execute();  // Publica el evento ??

    }

}
