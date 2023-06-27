<?php

namespace Domain\Inscription\Contract;

use Domain\Inscription\Inscription;
use Domain\Inscription\InscriptionId;

interface InscriptionRepository
{

    /**
     * Find Inscription by id (address)
     *
     * @param InscriptionId $id
     * @return Inscription|null
     */
    public function find(InscriptionId $id) : ?Inscription;

    /**
     * Find an Inscription by id (address) or Create a fresh one
     *
     * @param $id
     * @param array $data
     *
     * @return Inscription
     */
    public function findOrCreate($id, array $data = []) : Inscription;

    /**
     * Save Inscription
     *
     * @param Inscription $inscription
     *
     * @return Inscription
     */
    public function save(Inscription $inscription) : Inscription;

    /**
     * Get All Inscription corresponding to the query
     *
     * @param array $query
     * @return iterable
     */
    public function all(array $query) : iterable;

}
