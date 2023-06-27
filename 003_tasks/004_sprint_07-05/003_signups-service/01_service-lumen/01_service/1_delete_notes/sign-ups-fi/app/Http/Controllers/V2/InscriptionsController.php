<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Application\Inscription\Commands\{CreateInscription, GetAllInscriptions, GetInscription};
use Illuminate\Http\{Request, Response};

class InscriptionsController extends Controller
{

    /**
     * Handle single GET requests
     *
     * @param string $id
     * @return Response
     */
    public function get(string $id) : Response
    {
        try {
            return $this->createResponse(
                $this->commandBus->handle(new GetInscription($id))
            );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle POST Requests
     *
     * @param Request $request
     * @return Response
     */
    public function post(Request $request) : Response
    {
        // Create the Email using the Command + Command Handler
        $inscription = $this->commandBus->handle(
            new CreateInscription($request->all())
        );

        return $this->createResponse($inscription, 201);
    }


    /**
     * Handle GET requests
     *
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request) : Response
    {
        $inscription = $this->commandBus->handle(
            new GetAllInscriptions($request->all())
        );

        return $this->createResponse($inscription, 200);
    }
}
