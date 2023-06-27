<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\Tactician\CommandBus;
use App\Http\Resources\ResourceManager;

class Controller extends BaseController
{
    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Create a Response using the Resources Factory
     *
     * @param object|iterator $resource
     * @param integer $code
     * @return Response
     */
    public function createResponse($resource, $code = 200) : Response
    {
        return ResourceManager::createResponse(
            $resource, 
            $code,
            getallheaders()['Content-Type']
        );
    }
}
