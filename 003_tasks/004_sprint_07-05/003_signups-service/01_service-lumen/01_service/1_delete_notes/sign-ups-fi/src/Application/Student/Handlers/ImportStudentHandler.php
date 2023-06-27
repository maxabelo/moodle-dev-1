<?php

declare(strict_types=1);

namespace Application\Student\Handlers;

use Application\Student\Commands\CreateStudent;
use Application\Student\Commands\ImportStudent;
use Domain\Student\Student;

class ImportStudentHandler extends StudentHandler
{
    public function execute(ImportStudent $command) : ?Student
    {   
        $record = $this->getDataFromRecord(
            $command->studentsImporter->getRecordById($command->id)
        );

        if ( $record ){
            $dto = new CreateStudent($record);
            $student = Student::create($dto->getStudentId(), $dto->getData());
    
            return $this->repository->save($student);
        }

        return null;
    }

    /**
     * Transform the Record to a Simple Array
     *
     * @param object $record
     * @return array
     */
    protected function getDataFromRecord($record) :? array
    {
        $data = json_decode(json_encode($record), true);

        return $data;
    }

}
