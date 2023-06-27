<?php

namespace Application\Services\StudentWithInscription\Handlers;

use Domain\Inscription\Contract\InscriptionRepository;
use Domain\Student\StudentRepository;

class StudentWithInscriptionHandler
{

    /**
     * @var StudentRepository
     *
     */
    protected $studentRepository;

    /**
     * @var InscriptionRepository
     */
    protected $inscriptionRepository;

    /**
     * Default constructor
     *
     * @param StudentRepository $studentRepository
     * @param InscriptionRepository $inscriptionRepository
     */
    public function __construct(StudentRepository $studentRepository, InscriptionRepository $inscriptionRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->inscriptionRepository = $inscriptionRepository;
    }
}
