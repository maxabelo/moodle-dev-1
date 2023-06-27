<?php

declare(strict_types=1);

namespace Application\Student\Commands;

use Domain\Student\StudentsImporter;

class ImportStudent
{
    public $id;

    public ?StudentsImporter $studentsImporter;

    public function __construct($id, StudentsImporter $studentsImporter)
    {
        $this->id = $id;
        
        $this->studentsImporter = $studentsImporter;
    }
}