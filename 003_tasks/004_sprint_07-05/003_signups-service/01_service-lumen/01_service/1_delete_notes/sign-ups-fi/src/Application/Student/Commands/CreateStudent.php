<?php

declare(strict_types=1);

namespace Application\Student\Commands;

use Ddd\Application\Commands\DtoCommand;
use Domain\Student\StudentId;

class CreateStudent extends DtoCommand
{

    /**
     * Default constructor
     *
     * @param array $parameters
     * @param $institution
     *
     */
    public function __construct(array $parameters = [], $institution = null)
    {
        parent::__construct($parameters);
        $this->institution = $institution;

    }

    /** @var  */
    public $id;

    /** @var string|null  */
    public ?string $student_uuid;

    /** @var string|null  */
    public ?string $first_name;

    /** @var string|null  */
    public ?string $last_name;

    /** @var string|null  */
    public ?string $dni;

    /** @var string|null  */
    public ?string $user_name;

    /** @var string|null  */
    public ?string $password;

    /** @var string|null  */
    public ?string $email;

    /** @var string|null  */
    public ?string $country;

    /** @var string|null  */
    public ?string $city;

    /** @var string|null  */
    public ?string $phone;

    /** @var string|null  */
    public ?string $address;

    /** @var string|null  */
    public ?string $language;

    /** @var array|null  */
    public ?array $inscriptions;

    /**
     * return the Student Id
     *
     * @return StudentId
     */
    public function getStudentId()
    {
//        return StudentId::fromId($this->id);
        return new StudentId($this->student_uuid);
    }

    /**
     * return student data
     * @return array|null
     */
    public function getData() :? array
    {
        $data = $this->toArray();

        $data['reference_id'] = $this->id;
        $data['institution_abbreviation'] = $this->institution;

        // Remove the id from the data array.
        array_shift($data);

        return $data;
    }
}
