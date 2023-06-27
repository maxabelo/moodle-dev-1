<?php

declare(strict_types=1);

namespace Application\Student\Commands;

use Domain\Student\StudentId;

class GetStudent
{
    /** @var StudentId|\Ddd\Domain\ValueObjects\Id|\Ddd\Domain\ValueObjects\Uuid|null  */
    public ?StudentId $studentId;

    public function __construct($id)
    {
        $this->studentId = StudentId::fromId($id);
    }
}
