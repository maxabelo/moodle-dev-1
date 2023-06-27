<?php

namespace Domain\Inscription\Events;

use Domain\Events\DomainEvent;
use Domain\Inscription\Inscription;

class InscriptionEvent extends DomainEvent
{

    /** @var string  */
    public const NAME = 'inscription_event';

    /**
     * @var Inscription The Inscription associated to the event
     */
    public Inscription $inscription;

    /**
     * Default Constructor
     *
     * @param Inscription $inscription
     */
    public function __construct(Inscription $inscription)
    {
        parent::__construct();
        $this->inscription = $inscription;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'inscription'=> [
                    'uuid' => (string) $this->inscription->getId(),
                ] + $this->inscription->toArray()
        ];
    }
}
