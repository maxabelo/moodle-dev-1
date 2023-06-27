<?php

namespace Application\Inscription\Commands;

use Domain\Inscription\InscriptionId;

class GetInscription
{
    /** @var InscriptionId|\Ddd\Domain\ValueObjects\Id|\Ddd\Domain\ValueObjects\Uuid|null  */
    public ?InscriptionId $inscriptionId;

    /**
     * @param $id
     */
    public function __construct($id)
    {
        $this->inscriptionId = InscriptionId::fromId($id);
    }

}
