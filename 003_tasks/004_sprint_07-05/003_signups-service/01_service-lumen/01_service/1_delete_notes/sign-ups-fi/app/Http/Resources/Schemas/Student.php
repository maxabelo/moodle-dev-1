<?php

declare(strict_types=1);

namespace App\Http\Resources\Schemas;

use Domain\Student\Student as Entity;
use League\Fractal\TransformerAbstract as Transformer;

final class Student extends Transformer
{
    public function transform(Entity $student)
    {
        $studentId = (string) $student->getId();
        
        return array_merge(
            ['id' => $studentId, 'uuid' => $studentId],
            $student->toArray(),
            $this->getLinks($student)
        );
    }

    public function getLinks(Entity $student) : array
    {
        $studentId = (string) $student->getId();

        $data['_links'] = [
            'self' => [
                'href' => route('students.get', ['id' => $studentId]),
            ],
        ];

        return $data;
    }

    public function getType() : string
    {
        return 'students';
    }
}