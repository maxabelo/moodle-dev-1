<?php

namespace Domain\Inscription\Events;

use Ddd\Domain\Events\IntegrationEvent;

class InscriptionRegistered extends InscriptionEvent implements IntegrationEvent
{

    /** @var string  */
    public const NAME = 'inscription_registered';

}
