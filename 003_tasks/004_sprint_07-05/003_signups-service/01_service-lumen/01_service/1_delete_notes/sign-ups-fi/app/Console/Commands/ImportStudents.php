<?php

namespace App\Console\Commands;

use App\Console\Factory\ImporterFactory;
use Application\Inscription\Commands\CreateInscription;
use Application\Services\StudentWithInscription\Commands\GetStudentWithInscription;
use Application\Student\Commands\CreateStudent;
use Domain\Student\StudentsImporter;
use Illuminate\Console\Command;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;

class ImportStudents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    // .env = # NOMBRE DE LOS SG - 
    protected $signature = "import:students
                        {--s|sg-name= : The name of the SG where the students come from }";
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import recently updated students";

    /**
     * The Application Command Bus
     *
     * @var CommandBus
     */
    protected CommandBus $commandBus;

    /**
     * The Application Logger.
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * The Concrete Students Importer
     *
     * @var StudentsImporter
     */
    protected StudentsImporter $studentsImporter;


    /**
     * Default Constructor
     *
     * @param CommandBus $commandBus
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandBus $commandBus,
        LoggerInterface $logger ,
    )
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->logger = $logger;

    }

    /**
     * Transform the Record to a Simple Array
     *
     * @param object $record
     *
     * @return array
     */
    protected function getDataFromRecord($record) : array
    {
        $data = json_decode(json_encode($record), true);

        return $data;
    }

    /**
     * returns the importer with the established database
     *
     * @return \App\Console\Importers\CoreAppStudentsImporter|\App\Console\Importers\CoreAppStudentsImporterSirius
     *
     * @throws \Exception
     */
    public function getImporterData($name)
    {
        if (empty($name))
            $name = (new ImporterFactory())->getSGNameDefault();

        return (new ImporterFactory())->getConfigs($name);
    }


    /**
     * Create or Update a Student in the Service Persistence
     *
     * @param Object $record
     *
     * @return void
     */
    protected function createStudentAndInscription(object $record)
    {
        $inscriptions = $record->inscriptions;
        unset($record->inscriptions);

        foreach ($inscriptions as $key => $inscription)
        {
            $newInscription = $this->commandBus->handle(new CreateInscription($this->getDataFromRecord($inscription),
                    $this->studentsImporter->getInstitutionAbbreviation()));

            $this->logger->notice(
                sprintf('Inscription %s updated, of Student %s. Uuid: %s', $inscription->id, $record->id,
                    json_encode($newInscription->getId(), JSON_PRETTY_PRINT)));

            $record->inscriptions[$key]['uuid'] = $newInscription->getId();
        }

        $student = $this->commandBus->handle(new CreateStudent($this->getDataFromRecord($record),
                $this->studentsImporter->getInstitutionAbbreviation()));

        $this->commandBus->handle(new GetStudentWithInscription($student->getId()));

        $this->logger->notice(
            sprintf('Student %s updated. Uuid: %s', $record->id,
                json_encode($student->getId(), JSON_PRETTY_PRINT)));

        return $student;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->studentsImporter = $this->getImporterData($this->option('sg-name'));

        $this->logger->notice('Starting to search new signed-up students' . " (".$this->studentsImporter->getInstitution().") ...");
        $this->logger->notice(
            'Starting Date: ' . env('APP_IMPORT_STUDENTS_DATE', date("Y-m-d H:i:s"))
        );
        $this->logger->notice(
            'Retrieving from ' . env('APP_IMPORT_STUDENTS_DAYS_INTERVAL','') . ' days ago'
        );

        // CoreApp <- getPersonIds() <- area.abreviatura = '$PROGRAM_AREA' 
        $records = $this->studentsImporter->getRecords(); 

        foreach ($records as $key => $record) {
            if (is_object($record)) $this->createStudentAndInscription($record);
        }

        $this->logger->notice(
            'Ended Processing new students. Found ' . count($records) . ' records'
        );
    }
}
