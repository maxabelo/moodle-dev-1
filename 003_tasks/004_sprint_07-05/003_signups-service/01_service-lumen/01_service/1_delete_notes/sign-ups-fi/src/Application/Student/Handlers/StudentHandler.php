<?php

declare(strict_types=1);

namespace Application\Student\Handlers;

use Domain\Student\StudentRepository;

abstract class StudentHandler
{
    /**
     * @var StudentRepository
     * */
    protected $repository;

    /**
     * Default constructor
     *
     * @param StudentRepository $repository
     */
    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }
}
