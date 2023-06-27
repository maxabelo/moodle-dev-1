<?php

namespace Application\Inscription\Handlers;

use Application\Inscription\Commands\CreateInscription;
use Domain\Inscription\Inscription;

class CreateInscriptionHandler extends InscriptionHandler
{
    /**
     *
     * @param CreateInscription $command
     *
     * @return Inscription|null
     */
    public function execute(CreateInscription $command) : ?Inscription
    {
        $inscription = Inscription::create($command->getInscriptionId(), $command->getData());

        return $this->repository->save($inscription);
    }
}
