<?php

namespace Domain\Inscription\Entities;

use Carbon\Carbon;
use Ddd\Domain\Entity\BaseEntity;
use Domain\Inscription\ValueObjects\AcademicElement;
use Domain\Inscription\ValueObjects\AcademicSelectionId;

class AcademicSelection extends BaseEntity
{

    /** @var string[]  */
    protected $attributes = [
        'uuid',
        'reference_id',
        'admission_id',
        'started_at',
        'finished_at',
        'academic_element',
    ];

    /** @var  */
    public $startedAt;

    /** @var  */
    public $finishedAt;


    public $academicElement = [];

    public function __construct(AcademicSelectionId $academicSelectionId, array $data)
    {
        parent::__construct(AcademicSelectionId::fromId($academicSelectionId));
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
        $this->id = AcademicSelectionId::fromId($id);
    }


    /**
     * @param $dt
     *
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
     * Make a Entity Instance.
     *
     * @param mixed $id
     * @param array $data
     * @return self
     */
    public static function make($id, array $data) : self
    {

        return new static(AcademicSelectionId::fromId($id), $data);
    }




    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
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
     * @param array $data
     *
     * @return void
     */
    public function addAcademicElement(array $data)
    {

        $this->academicElement[] = AcademicElement::make($data);

    }


    /**
     * @param iterable $academic_selections
     *
     * @return void
     */
    public function setAcademicElement(iterable $academic_elements)
    {
        $this->academicElement = [];
        foreach ($academic_elements as $academic_element){
            $this->addAcademicElement($academic_element);
        }

    }

    /**
     * @return AcademicElement
     */
    public function getAcademicElement()
    {
        return $this->academicElement;
    }

}
