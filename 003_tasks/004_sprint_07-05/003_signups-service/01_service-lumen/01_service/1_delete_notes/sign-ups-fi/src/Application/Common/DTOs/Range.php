<?php

declare(strict_types=1);

namespace Application\Common\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class Range extends DataTransferObject
{
    public ?string $gt;

    public ?string $gte;

    public ?string $lt;

    public ?string $lte;

    public function toArray(): array
    {
        return [
            'range' => parent::toArray()
        ];
    }
}