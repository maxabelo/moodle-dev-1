<?php

namespace Infrastructure\Inscription;

use Domain\Inscription\Inscription;
use Domain\Inscription\InscriptionId;
use Domain\Inscription\Contract\InscriptionRepository;
use Infrastructure\Common\Repository\ElasticRepository;
use Infrastructure\Common\Repository\HasPaginator;

class ElasticInscriptionRepository extends ElasticRepository implements
    InscriptionRepository
{

    use HasPaginator;

    protected $index = 'inscriptions';

    /**
     * @inheritDoc
     */
    public function find(InscriptionId $id) : ?Inscription
    {
        $record = $this->get((string) $id);

        return Inscription::make($id, $record['_source']);
    }

    /**
     * @inheritDoc
     */
    public function findOrCreate($id, array $data = []) : Inscription
    {
        $InscriptionId = InscriptionId::fromId($id);

        try{
            return $this->find($InscriptionId);
        }
        catch(\Throwable $e){
            return Inscription::create($InscriptionId, $data);
        }
    }

    /**
     * @inheritDoc
     */
    public function save(Inscription $Inscription) : Inscription
    {
        $this->index(
            $Inscription->toArray(), (string) $Inscription->getId()
        );

        return $Inscription;
    }

    /**
     * @inheritDoc
     */
    public function all(array $query) : iterable
    {
        // @version 1.0: Sorted by desc created date, by default.
        $query['sort'] = ['created_at'=> ['order'=> 'desc']];

        $results = $this->search($query);

        foreach ($results['hits'] as $record){
            $list[] = Inscription::make($record['_id'], $record['_source']);
        }

        return $this->createIterable(
            $list ?? [], $query, (int) $results['total']['value']
        );
    }
}
