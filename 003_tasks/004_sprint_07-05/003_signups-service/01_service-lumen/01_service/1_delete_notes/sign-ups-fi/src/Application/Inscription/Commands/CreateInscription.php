<?php

namespace Application\Inscription\Commands;

use Ddd\Application\Commands\DtoCommand;
use Domain\Inscription\InscriptionId;

class CreateInscription extends DtoCommand
{

    /**
     * Default constructor
     *
     * @param array $parameters
     * @param $institution
     */
    public function __construct(array $parameters = [], $institution = null)
    {
        parent::__construct($parameters);
        $this->institution = $institution;

    }

    /** @var  */
    public $id;

    /** @var string|null  */
    public ?string $inscription_uuid;

    /** @var string|null  */
    public ?string $language;

    /** @var string|null  */
    public ?string $created_at;

    /** @var string|null  */
    public ?string $registered_at;

    /** @var string|null  */
    public ?string $started_at;

    /** @var string|null  */
    public ?string $finished_at;

    /** @var string|null  */
    public ?string $extension_finished_at;

    /** @var string|null  */
    public ?string $status;

    /** @var string|null  */
    public ?string $incidence;

    /** @var string|null  */
    public ?string $modality ;

    /** @var array|null  */
    public ?array $degrees;

    /** @var array|null  */
    public ?array $academic_program;

    /** @var array|null  */
    public ?array $enrollments;


    /**
     * return Inscription Id
     *
     * @return InscriptionId
     */
    public function getInscriptionId()
    {
        return new InscriptionId($this->inscription_uuid);
    }


    /**
     * return data
     *
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
