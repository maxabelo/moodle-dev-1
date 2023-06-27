<?php

namespace App\Http\Resources\Schemas;

use Ddd\Domain\Entity\Entity;
use League\Fractal\TransformerAbstract as Transformer;

final class Inscription extends Transformer
{

    public function transform(Entity $inscription)
    {
        $inscriptionId = (string) $inscription->getId();

        return array_merge(
            ['id' => $inscriptionId, 'uuid' => $inscriptionId],
            $inscription->toArray(),
            $this->getLinks($inscription)
        );
    }

    public function getLinks(Entity $inscription) : array
    {
        $inscriptionId = (string) $inscription->getId();

        $data['_links'] = [
            'self' => [
                'href' => route('inscriptions.get', ['id' => $inscriptionId]),
            ],
        ];

        return $data;
    }

    public function getType() : string
    {
        return 'inscriptions';
    }
}
