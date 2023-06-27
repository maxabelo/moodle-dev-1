<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Application\Student\Commands\{CreateStudent, GetAllStudents, GetStudent};
use Illuminate\Http\{Request, Response};

class StudentsController extends Controller
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
                $this->commandBus->handle(new GetStudent($id))
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
        $student = $this->commandBus->handle(
            new CreateStudent($request->all())
        );

        return $this->createResponse($student, 201);
    }

    /**
     * Handle GET requests
     *
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request) : Response
    {
        $students = $this->commandBus->handle(
            new GetAllStudents($request->all())
        );

        return $this->createResponse($students, 200);
    }
}
