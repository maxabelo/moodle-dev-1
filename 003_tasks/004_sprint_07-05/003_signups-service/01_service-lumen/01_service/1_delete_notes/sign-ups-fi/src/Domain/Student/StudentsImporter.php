<?php

declare(strict_types=1);

namespace Domain\Student;

interface StudentsImporter
{
    /**
     * Get Records from a Concrete Database or Persistence Mechanism
     *
     * @return array
     */
    public function getRecords() : array;

    /**
     * Get a Student Record from a Concrete Database or Persistence Mechanism
     *
     * @return object
     */
    public function getRecordById($id) :? object;

    /**
     * Set the Days to import
     *
     * @param integer $days
     * @return void
     */
    public function setDays(int $days);
}