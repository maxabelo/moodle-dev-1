<?php

declare(strict_types=1);

namespace Domain\Student;

use Ddd\Domain\ValueObjects\Uuid;

class StudentId extends Uuid
{


    /**
     * Construct a StudentId Instance
     *
     * @param $uuid
     */
    public function __construct($uuid = null)
    {
        $uuid = (string) $uuid;

        $this->uuid = $uuid;

    }
}
