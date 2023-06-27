<?php

namespace Application\Inscription\Handlers;

use Domain\Inscription\Contract\InscriptionRepository;

abstract class InscriptionHandler
{

    /** @var InscriptionRepository  */
    protected $repository;

    /**
     * Default constructor
     *
     * @param InscriptionRepository $repository
     */
    public function __construct(InscriptionRepository $repository)
    {
        $this->repository = $repository;
    }
}
