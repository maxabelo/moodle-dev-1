<?php


namespace Domain\Inscription;

use Carbon\Carbon;
use Ddd\Domain\Entity\AggregateRoot;
use Ddd\Domain\Entity\Concerns\HasAttributes;
use Ddd\Domain\Entity\Concerns\HasTimestamps;
use Domain\Inscription\Entities\Degree;
use Domain\Inscription\Entities\Enrollment;
use Domain\Inscription\Events\InscriptionRegistered;
use Domain\Inscription\ValueObjects\InscriptionActive;
use Domain\Inscription\ValueObjects\InscriptionModality;

class Inscription extends AggregateRoot
{

    use HasAttributes;
    use HasTimestamps;

    /** @var string[]  */
    protected $attributes = [
        'reference_id',
        'language',
        'created_at',
        'registered_at',
        'started_at',
        'finished_at',
        'extension_finished_at',
        'status',
        'incidence',
        'academic_program',
        'institution_abbreviation',
        'degrees',
        'modality',
        'active',
        'enrollments',
    ];

    /** @var array  */
    public $enrollments = [];

    /** @var array  */
    public $degrees = [];


    public $modality;
    public $registeredAt;
    public $startedAt;
    public $finishedAt;
    public $extensionFinishedAt;

    /**
     * Default constructor
     *
     * @param InscriptionId $id
     * @param array $data
     */
    public function __construct(InscriptionId $id, array $data)
    {
        parent::__construct($id);
        $this->fill($data);
        $this->setModalityInscription($data);
        $this->setActiveStatusInscription($data);
    }

    /**
     * Create a new Aggregate instance
     *
     * @param InscriptionId $id
     * @param array $data
     *
     * @return self
     */
    public static function create(InscriptionId $id, array $data) : self
    {
        $inscription = new self($id, $data);
        $inscription->setCreatedAt();

        $inscription->raise(new InscriptionRegistered($inscription));  // emite/registra event  inscription_registered

        return $inscription;
    }

    /**
     * Set the Finished At Timestamp
     *
     * @param string $dt
     * @return void
     */
    protected function setFinishedAt($dt)
    {
        $this->finishedAt = Carbon::parse($dt);

        // If the date timestamp is 0000-00-00, the finishedAt timestamp is null
        $this->finishedAt = $this->finishedAt->year < 1 ? null : $this->finishedAt;
    }

    /**
     * Get the Finished At Timestamp
     *
     * @return Carbon|null
     */
    protected function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Set the Registered At Timestamp
     *
     * @param string $dt
     * @return void
     */
    protected function setRegisteredAt($dt)
    {
        $this->registeredAt = Carbon::parse($dt);

        // If the date timestamp is 0000-00-00, the registeredAt timestamp is null
        $this->registeredAt = $this->registeredAt->year < 1 ? null : $this->registeredAt;
    }

    /**
     * Get the Registered At Timestamp
     *
     * @return Carbon|null
     */
    protected function getRegisteredAt()
    {
        return $this->registeredAt;
    }


    /**
     * Set the Started At Timestamp
     *
     * @param string $dt
     * @return void
     */
    protected function setStartedAt($dt)
    {
        $this->startedAt = Carbon::parse($dt);

        // If the date timestamp is 0000-00-00, the startedAt timestamp is null
        $this->startedAt = $this->startedAt->year < 1 ? null : $this->startedAt;
    }

    /**
     * Get the Started At Timestamp
     *
     * @return Carbon|null
     */
    protected function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set the Extension Finished At Timestamp
     *
     * @param string $dt
     * @return void
     */
    protected function setExtensionFinishedAt($dt)
    {
        $this->extensionFinishedAt = Carbon::parse($dt);

        // If the date timestamp is 0000-00-00, the extensionFinishedAt timestamp is null
        $this->extensionFinishedAt = $this->extensionFinishedAt->year < 1 ? null : $this->extensionFinishedAt;
    }

    /**
     * Get the Extension Finished At Timestamp
     *
     * @return Carbon|null
     */
    protected function getExtensionFinishedAt()
    {
        return $this->extensionFinishedAt;
    }

    /**
     * Make a Aggregate Instance.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return self
     */
    public static function make($id, array $data) : self
    {
        return new static(InscriptionId::fromId($id), $data);
    }

    public static function getInscriptionId ($id)
    {
        return $id;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     *
     * @param $data
     *
     * @return void
     */
    protected function setActiveStatusInscription($data)
    {
        $this->active = (new InscriptionActive($data['status']))->setActiveStatus();
    }

    /**
     *
     * @param $data
     *
     * @return void
     */
    protected function setModalityInscription($data)
    {
        $this->modality = (new InscriptionModality($data['modality']))->setInscriptionModality();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function addEnrollment(array $data)
    {
        $this->enrollments[] = Enrollment::make($data['reference_id'], $data);
    }

    /**
     * @param iterable $enrollments
     *
     * @return void
     */
    public function setEnrollments(iterable $enrollments)
    {
        $this->enrollments = [];

        foreach ($enrollments as $enrollment){
            $this->addEnrollment($enrollment);
        }
    }

    /**
     * @return iterable|null
     */
    public function getEnrollments() :? iterable
    {
        return $this->enrollments ?? null;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function addDegree(array $data)
    {
        $this->degrees[] = Degree::make($data['reference_id'], $data);
    }

    /**
     * @param iterable $degrees
     *
     * @return void
     */
    public function setDegrees(iterable $degrees)
    {
        $this->degrees = [];

        foreach ($degrees as $degree){
            $this->addDegree($degree);
        }
    }

    /**
     * @return iterable|null
     */
    public function getDegrees() :? iterable
    {
        return $this->degrees ?? null;
    }
}
