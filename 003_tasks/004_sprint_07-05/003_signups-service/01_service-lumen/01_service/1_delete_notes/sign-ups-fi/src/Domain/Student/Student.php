<?php

declare(strict_types=1);

namespace Domain\Student;

use Ddd\Domain\Entity\AggregateRoot;
use Ddd\Domain\Entity\Concerns\HasAttributes;
use Ddd\Domain\Entity\Concerns\HasTimestamps;
use Domain\Inscription\Inscription;
use Domain\Student\Events;
use Domain\Student\ValueObjects\InscriptionUuid;

class Student extends AggregateRoot
{
    use HasAttributes;
    use HasTimestamps;

    /** @var string[]  */
    protected $attributes = [
        'reference_id',
        'dni',
        'first_name',
        'last_name',
        'user_name',
        'password',
        'email',
        'country',
        'city',
        'phone',
        'address',
        'language',
        'institution_abbreviation',
        'created_at',
        'inscriptions'
    ];

    /** @var array  */
    public $inscriptions = [];

    /**
     * Default constructor
     *
     * @param StudentId $id
     * @param array $data
     */
    public function __construct(StudentId $id, array $data)
    {
        parent::__construct($id);
        $this->fill($data);
    }

    /**
     * Create a new Aggregate instance
     *
     * @param StudentId $id
     * @param array $data
     * @return self
     */
    public static function create(StudentId $id, array $data) : self
    {
        $student = new self($id, $data);
        $student->setCreatedAt();

        $student->raise(new Events\StudentRegistered($student)); // emite/registra el evento  student_registered

        return $student;
    }

    /**
     * Make a Aggregate Instance.
     *
     * @param mixed $id
     * @param array $data
     * @return self
     */
    public static function make($id, array $data) : self
    {
        return new static(StudentId::fromId($id), $data);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * Set the Status property
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;
    }

    /**
     * @param $uuid
     * @return void
     */
    public function addInscription($uuid)
    {
        
        $this->inscriptions[] = InscriptionUuid::getInscriptionUuid($uuid);

    }


    /**
     * @param iterable $inscriptions
     * @return void
     */
    public function setInscriptions(iterable $inscriptions)
    {
        $this->inscriptions = [];

        foreach ($inscriptions as $inscription){
            $this->addInscription($inscription);
        }

    }

    /**
     * @return iterable|null
     */
    public function getInscriptions() :? iterable
    {
        return $this->inscriptions ?? null;
    }

}
