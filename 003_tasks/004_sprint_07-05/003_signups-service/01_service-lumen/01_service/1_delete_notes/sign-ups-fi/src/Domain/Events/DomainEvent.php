<?php

namespace Domain\Events;


use Ddd\Domain\Events\DomainEvent as DomainEventCore;
abstract class DomainEvent extends DomainEventCore
{

    /**
     * Default parent constructor
     */
    protected function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array|string[]
     */
    public function jsonSerialize()
    {
        return [
                'uuid'=> (string) $this->uuid,
                'fired_at'=>  $this->firedAt,
            ] + $this->toArray();
    }

}
