<?php

declare(strict_types=1);

namespace Application\Student\Commands;

use Application\Common\DTOs\Range;
use Ddd\Application\Commands\DtoCommand;
use Ddd\Application\Commands\HasPagination;

class GetAllStudents extends DtoCommand
{
    use HasPagination;

    public ?string $limit = '10';

    /**
     * @var \Application\Common\DTOs\Range|string|null
     */
    public $created_at;

    /**
     * Get the parsed search query
     *
     * @return array
     */
    public function getQuery() : array
    {
        $this->setCreatedAtRange();

        return array_merge(
            $this->except('inscriptions')->toArray(),
            isset($this->inscriptions) ? $this->inscriptions->toArray() : []
        );
    }

    /**
     * Set the created_at range
     *
     * Checks if a created_at range was set, otherwise it defaults to 2 days ago.
     *
     * @return void
     */
    protected function setCreatedAtRange()
    {
        $this->created_at = $this->created_at ?? new Range([
            'gte' => 'now-2d/d',
            'lt' => 'now/d',
        ]);
    }
}
