<?php

namespace Domain\Inscription\Entities;

use Ddd\Domain\Entity\BaseEntity;
use Domain\Inscription\ValueObjects\DegreeBrandsAbbreviation;
use Domain\Inscription\ValueObjects\DegreeId;
use Domain\Inscription\ValueObjects\DegreeActive;

class Degree extends BaseEntity
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'reference_id',
        'abbreviation',
        'status',
        'incidence',
        'active'
    ];

    /** @var  */
    protected $active;

    protected $abbreviation;

    /** @var  */
    protected $incidence;


    public function __construct(DegreeId $degreeId, array $data)
    {
        parent::__construct(DegreeId::fromId($degreeId));

        $this->fill($data);
        $this->setActiveStatusDegree($data);
        $this->setAbbreviationBrand($data);
        $this->setIncidenceDefault($data);
    }

    /**
     * Default setter
     *
     * @param string|int $id
     * @return void
     */
    protected function setId($id)
    {
        $this->id = DegreeId::fromId($id);
    }

    /**
     *
     * @param $data
     *
     * @return void
     */
    protected function setActiveStatusDegree($data)
    {
        $this->active = (new DegreeActive($data['status']))->setActiveStatus();
    }

    /**
     *
     * @param $data
     *
     * @return void
     */
    protected  function setAbbreviationBrand($data)
    {
        $this->abbreviation = (new DegreeBrandsAbbreviation($data['abbreviation']))->setAbbreviationBrand();
    }

    /**
     *
     * @param $data
     *
     * @return void
     */
    protected function setIncidenceDefault($data)
    {
        if(empty($data['incidence']))
        {
            $this->incidence = " - " ;
        }
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
        return new static(DegreeId::fromId($id), $data);
    }


    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

}
