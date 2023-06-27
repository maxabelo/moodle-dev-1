<?php

namespace Domain\Inscription;

use Ddd\Domain\ValueObjects\Uuid;

class InscriptionId extends Uuid
{

    /**
     * Construct a InscriptionId Instance
     *
     * @param $uuid
     */
    public function __construct($uuid = null)
    {
        $uuid = (string) $uuid;

        $this->uuid = $uuid;

    }
}
