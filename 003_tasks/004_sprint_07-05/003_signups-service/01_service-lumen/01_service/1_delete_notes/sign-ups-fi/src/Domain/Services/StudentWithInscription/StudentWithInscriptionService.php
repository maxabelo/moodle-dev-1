<?php

namespace Domain\Services\StudentWithInscription;

use Ddd\Domain\Entity\AggregateRoot;
use Ddd\Domain\Entity\Concerns\HasAttributes;
use Domain\Inscription\Contract\InscriptionRepository;
use Domain\Inscription\InscriptionId;
use Domain\Student\Events\StudentSignedUp;
use Domain\Student\Student;
use Domain\Student\StudentId;
use Domain\Student\StudentRepository;

class StudentWithInscriptionService extends AggregateRoot
{
    use HasAttributes;

    /** @var StudentRepository v */
    protected $studentRepository;

    /** @var InscriptionRepository  */
    protected  $inscriptionRepository;

    /** @var StudentId  */
    protected $studentId;

    /**
     * @param StudentRepository $studentRepository
     * @param InscriptionRepository $inscriptionRepository
     * @param StudentId $studentId
     */
    public function __construct(
        StudentRepository $studentRepository,
        InscriptionRepository $inscriptionRepository,
        StudentId $studentId
    )
    {
        $this->studentRepository = $studentRepository;
        $this->inscriptionRepository = $inscriptionRepository;
        $this->studentId = $studentId;
    }

    /**
     * @return Student|null
     */
    public function execute()
    {
        $Student = $this->getStudent($this->studentId);

        foreach ($Student->inscriptions as $key => $inscriptionId)
        {
            $inscriptionId = new InscriptionId($inscriptionId['uuid']);
            $Inscription = $this->getInscriptionsByUuid($inscriptionId);
            $Student->inscriptions[$key] = $Inscription;
        }

        $Student->raise(new StudentSignedUp($Student)); // publica el evento de dominio   student_signedup

        return $Student;
    }

    /**
     * @param StudentId $studentId
     *
     * @return Student|null
     */
    public function getStudent(StudentId $studentId)
    {

        $student = $this->studentRepository->find($studentId);

        return $student;
    }

    /**
     * @param InscriptionId $inscriptionId
     *
     * @return array
     */
    public function getInscriptionsByUuid(InscriptionId $inscriptionId)
    {
        $inscription = $this->inscriptionRepository->find($inscriptionId);

        return [
                'uuid' => (string) $inscription->getId(),
            ] + $inscription->toArray();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }
}
