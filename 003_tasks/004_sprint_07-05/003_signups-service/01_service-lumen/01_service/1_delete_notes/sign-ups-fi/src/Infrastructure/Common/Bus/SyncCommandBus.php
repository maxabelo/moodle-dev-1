<?php

namespace Infrastructure\Common\Bus;

use Domain\Common\Bus\Command;
use Domain\Common\Bus\CommandBus as CommandBusContract;
use League\Tactician\CommandBus as TacticianCommandBus;

class SyncCommandBus  implements CommandBusContract
{

    /**
     * @param TacticianCommandBus $commandBus
     */
    public function __construct(private TacticianCommandBus $commandBus)
    {
    }

    /**
     * @param Command $command
     * @return void
     */
    public function dispatch(Command $command): void
    {
        $this->commandBus->handle($command);
    }

}
