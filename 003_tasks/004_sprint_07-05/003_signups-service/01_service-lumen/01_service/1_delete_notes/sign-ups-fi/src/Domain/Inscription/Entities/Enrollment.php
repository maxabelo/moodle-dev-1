<?php

namespace Domain\Inscription\Entities;

use Carbon\Carbon;
use Ddd\Domain\Entity\BaseEntity;
use Domain\Inscription\ValueObjects\EnrollmentId;

class Enrollment extends BaseEntity
{

    /** @var string[]  */
    protected $attributes = [
        'uuid',
        'reference_id',
        'language',
        'started_at',
        'finished_at',
        'updated_at',
        'academic_program',
        'academic_term',
        'academic_selections'
    ];

    /** @var array  */
    public $academic_selections = [];

    /** @var  */
    public $finishedAt;

    /** @var  */
    public $startedAt;

    /** @var  */
    public $updatedAt;


    public function __construct(EnrollmentId $enrollmentId, array $data)
    {
        parent::__construct(EnrollmentId::fromId($enrollmentId));

        $this->fill($data);
    }


    /**
     * Default setter
     *
     * @param string|int $id
     * @return void
     */
    protected function setId($id)
    {
        $this->id = EnrollmentId::fromId($id);
    }

    /**
     * Make a Entity Instance.
     *
     * @param mixed $id
     * @param array $data
     * @return self
     */
    public static function make($id, array $data) : self
    {
        return new static(EnrollmentId::fromId($id), $data);
    }


    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
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
     * Set the Updated At Timestamp
     *
     * @param string $dt
     * @return void
     */
    protected function setUpdatedAt($dt)
    {
        $this->updatedAt = Carbon::parse($dt);

        // If the date timestamp is 0000-00-00, the updatedAt timestamp is null
        $this->updatedAt = $this->updatedAt->year < 1 ? null : $this->updatedAt;
    }

    /**
     * Get the Updated At Timestamp
     *
     * @return Carbon|null
     */
    protected function getUpdatedAt()
    {
        return $this->updatedAt;
    }



    /**
     * @param array $data
     *
     * @return void
     */
    public function addAcademicSelection(array $data)
    {
        $this->academic_selections[] = AcademicSelection::make($data['admission_id'], $data);
    }


    /**
     * @param iterable $academic_selections
     *
     * @return void
     */
    public function setAcademicSelections(iterable $academic_selections)
    {
        $this->academic_selections = [];

        foreach ($academic_selections as $academic_selection){
            $this->addAcademicSelection($academic_selection);
        }
    }

    /**
     * @return iterable|null
     */
    public function getAcademicSelections() :? iterable
    {
        return $this->academic_selections ?? null;
    }

}
