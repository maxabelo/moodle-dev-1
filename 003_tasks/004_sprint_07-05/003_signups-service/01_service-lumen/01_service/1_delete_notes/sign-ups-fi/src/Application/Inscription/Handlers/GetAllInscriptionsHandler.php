<?php

namespace Application\Inscription\Handlers;

use Application\Inscription\Commands\GetAllInscriptions;

class GetAllInscriptionsHandler extends InscriptionHandler
{

    /**
     *
     * @param GetAllInscriptions $command
     *
     * @return iterable|null
     */
    public function execute(GetAllInscriptions $command) :? iterable
    {
        return $this->repository->all($command->getQuery());
    }
}
