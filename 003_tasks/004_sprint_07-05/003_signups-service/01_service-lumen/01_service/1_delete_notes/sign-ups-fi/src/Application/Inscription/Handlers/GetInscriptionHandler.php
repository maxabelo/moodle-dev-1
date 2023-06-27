<?php

namespace Application\Inscription\Handlers;

use Application\Inscription\Commands\GetInscription;
use Domain\Inscription\Inscription;

class GetInscriptionHandler extends InscriptionHandler
{

    /**
     *
     * @param GetInscription $command
     *
     * @return Inscription|null
     */
    public function execute(GetInscription $command) : ?Inscription
    {
        return $this->repository->find($command->inscriptionId);
    }
}
