<?php

namespace Domain\Inscription\ValueObjects;

use Ddd\Domain\ValueObjects\ValueObject;

class AcademicElement implements ValueObject
{

    /** @var string|null  */
    public $uuid;

    /** @var int  */
    public $reference_id;

    /** @var string|null  */
    public $reference_class;

    /** @var string|null  */
    public $reference_type;

    /** @var string|null  */
    public $type;

    /** @var string|null  */
    public $name;

    /** @var string|null  */
    public $abbreviation;

    /** @var string|null  */
    public $language;

    /** @var string|null  */
    public $version;


    /**
     * Default Constructor
     *
     * @param string|null $uuid
     * @param int $reference_id
     * @param string|null $reference_class
     * @param string|null $reference_type
     * @param string|null $type
     * @param string|null $name
     * @param string|null $abbreviation
     * @param string|null $language
     * @param string|null $version
     */
    public function __construct(
        string $uuid = null,
        int $reference_id,
        string $reference_class = null,
        string $reference_type = null,
        string $type = null,
        string $name = null,
        string $abbreviation = null,
        string $language = null,
        string $version = null
    ){
        $this->uuid = $uuid;
        $this->reference_id = $reference_id;
        $this->reference_class = $reference_class;
        $this->reference_type = $reference_type;
        $this->type = $type;
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->language = $language;
        $this->version = $version;
    }

    /**
     * Make a Entity Instance.
     *
     * @param mixed $id
     * @param array $data
     * @return self
     */
    public static function make(array $data) : self
    {
        return new static(
            $data['uuid'] ?? null,
            $data['reference_id'],
            $data['reference_class'] ?? null,
            $data['reference_type'] ?? null,
            static::setType($data) ?? null,
            $data['name'] ?? null,
            $data['abbreviation'] ?? null,
            $data['language'] ?? null,
            $data['version'] ?? null
        );
    }


    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->abbreviation;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return (array) $this;
    }

    /**
     * returns the type of academic element
     *
     * @param $data
     * @return string
     */
    public static function setType($data)
    {
        Switch ($data['reference_class']){
            CASE 'ProgramaVersion':
                return 'Program';
            CASE 'AsignaturaVersion':
                return 'Subject';
            CASE 'Actividad':
                return 'Activity';
            default:
                return $data['reference_class'];
        }

    }


}
