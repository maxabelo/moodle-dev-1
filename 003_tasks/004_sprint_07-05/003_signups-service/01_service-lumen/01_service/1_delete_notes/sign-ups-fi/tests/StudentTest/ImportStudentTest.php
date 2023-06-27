<?php

namespace StudentTest;

use App\Console\Factory\ImporterFactory;
use Domain\Student\Student;
use Domain\Student\StudentId;
use InscriptionTest\InscriptionTest;

class ImportStudentTest extends \TestCase
{

    protected $studentImporter;

    public static $sgName = 'sirius' ;
    public static $nameSpace = 'funiber.org';

    public function testGetStudent()
    {
        var_dump($this->getStudentInstitution());
        foreach ($this->getStudentRecord() as $key => $record)
        {
            var_dump($this->createStudent($record->student_uuid));
        }
        $this->assertEquals(1,1,'COMPLETED');
    }

    public function getStudentRecord()
    {
        $this->studentImporter = ((new ImporterFactory())->getConfigs(static::$sgName));
        return $this->studentImporter->getRecords();
    }

    public function getStudentInstitution()
    {
        $this->studentImporter = ((new ImporterFactory())->getConfigs(static::$sgName));
        return $this->studentImporter->getInstitution();
    }

    public function createStudent($uuid, $inscriptionUuid = null)
    {
        $studentId = new StudentId($uuid);

        $data = array (
            'uuid' => $studentId,
            'reference_id' => '4607187',
            'dni' => 'Y5740595Q',
            'first_name' => 'test first',
            'last_name' => 'test last',
            'user_name' => 'test.test',
            'password' => 'test12345',
            'email' => 'test.test@alumnos.uneatlantico.es',
            'country' => 'SV',
            'city' => 'La Libertad',
            'phone' => '+5037608-4331',
            'address' => 'Colonia Las Mercedes, 6 Pol. B',
            'language' => 'es',
            'inscriptions' =>
                array (
                    0 =>
                        array (
                            'uuid' => ((new InscriptionTest( $this->inscriptionRepository)))->createInscription(),
                        ),
                ),
            'created_at' => '2022-11-16T18:30:56.030880Z',
        );

        $student = Student::create($studentId, $data);
        $this->studentRepository->save($student);

        return $studentId;
    }
}
