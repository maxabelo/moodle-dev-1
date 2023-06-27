<?php

namespace App\Console\Importers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Domain\Student\StudentsImporter;

class CoreAppStudentsImporter implements StudentsImporter
{
    /**
     * Days between to import students that have updates.
     */
    protected static $DAYS = 1;

    /**
     *
     * @param $name
     */
    public function __construct($name = null)
    {
        $this->configData = config('globalConnection.'.$name);
    }

    /**
     * @inheritDoc
     */
    public function setDays(int $days)
    {
        static::$DAYS = $days;
    }

    /**
     * returns the institution taking into account the database
     *
     * @return array|mixed
     */
    public function getInstitution()
    {
        return data_get($this->configData, 'institution');
    }

    /**
     * returns the institution abbreviation taking into account the database
     *
     * @return array|mixed
     */
    public function getInstitutionAbbreviation()
    {
        return data_get($this->configData, 'abbreviation');
    }

    /**
     * returns the namespace taking into account the database
     *
     * @return array|mixed
     */
    public function getNameSpace()
    {
        return data_get($this->configData, 'nameSpace');
    }

    /**
     * returns the configuration of the database to connect
     *
     * @return array|mixed
     */
    public function getConnection()
    {
        return data_get($this->configData, 'connection');
    }

    /**
     * @inheritDoc
     */
    public function getRecordById($id) :? object
    {
        foreach ($this->getStudentRecordById($id) as $record){
                $record->inscriptions = $this->filterInscriptions($this->getInscriptionByStudentId($id));

            return $record;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRecords() : array // called by command -> import:students -s sirius <- cron
    {
        $records = [];

        foreach ($this->getPersonIds() as $idRecord) {
            $records[$idRecord->id] = $this->getRecordById($idRecord->id);
        }

        return $records;
    }

    /**
     * obtains the data of the inscription
     *
     * @param $inscriptions
     *
     * @return mixed
     */
    protected function filterInscriptions($inscriptions)
    {
        foreach ($inscriptions as $inscription)
        {
            $inscription->academic_program['uuid'] = $inscription->program_uuid;
            $inscription->academic_program['reference_id'] = $inscription->program_id;
            $inscription->academic_program['type'] = 'Program';
            $inscription->academic_program['abbreviation'] = $inscription->program_abbreviation;
            $inscription->academic_program['language'] = $inscription->language ;
            $inscription->academic_program['name'] = $inscription->program_name;
            $inscription->academic_program['version'] = $inscription->program_version;

            $inscription->degrees = $this->getDegreesByInscriptionId($inscription->id);
            $inscription->enrollments = $this->getEnrollmentByInscriptionId($inscription->id);

            foreach ($inscription->enrollments as $enrollment)
            {
                $enrollment->academic_program = $inscription->academic_program;

                $enrollment->academic_term['reference_id'] = $enrollment->announcement_id;
                $enrollment->academic_term['school_period'] = $enrollment->announcement_school_period;
                $enrollment->academic_term['study_model'] = $enrollment->announcement_study_model;
                $enrollment->academic_term['started_at'] = Carbon::parse($enrollment->announcement_started_at)->year < 1 ? null : Carbon::parse($enrollment->announcement_started_at) ;
                $enrollment->academic_term['finished_at'] = Carbon::parse($enrollment->announcement_finished_at)->year < 1 ? null : Carbon::parse($enrollment->announcement_finished_at);

                $enrollment->academic_selections = $this->getAcademicSelectionByEnrollmentId($enrollment->reference_id);

                foreach ($enrollment->academic_selections as $academic_selection)
                {
                    $academic_selection->academic_element = $this->getAcademicElementBySelectionAcademicId($academic_selection->reference_id);

                }

                // Cleaning Up...
                unset($enrollment->announcement_id, $enrollment->announcement_school_period, $enrollment->announcement_study_model, $enrollment->announcement_started_at, $enrollment->announcement_finished_at);
            }

            // Cleaning Up...
            unset($inscription->program_uuid, $inscription->program_id, $inscription->program_abbreviation, $inscription->program_name, $inscription->program_version);

        }

        return $inscriptions;
    }

    /**
     * Get the Person Ids
     *
     * Return a recorset of Ids from Students that have been modified $DAYS DAYs ago.
     *
     * @return array
     */
    protected function getPersonIds() // importador de Sirius
    {
        // Check if days is set in an ENV variable.
        // @todo: Set it outside the concrete importer.
        $DAYS = (int) env('APP_IMPORT_STUDENTS_DAYS_INTERVAL', static::$DAYS);
        $DATE = env('APP_IMPORT_STUDENTS_DATE', '');

        // Set the Date Range depending on the ENV Variables
        $BETWEEN = empty($DATE)
            ? "BETWEEN DATE_SUB(CURDATE(), INTERVAL $DAYS DAY) AND CURDATE()"
            : "BETWEEN DATE_SUB('$DATE', INTERVAL $DAYS DAY) AND DATE('$DATE')"
        ;

        $query =
            "SELECT DISTINCT
                inscripcion.persona_id as id
            FROM inscripcion
            INNER JOIN persona
                ON inscripcion.persona_id = persona.id
            INNER JOIN student
                ON student.persona_id = persona.id
            INNER JOIN inscription
                ON inscription.inscripcion_id = inscripcion.id
            INNER JOIN expediente
                ON expediente.persona_id = persona.id
            INNER JOIN matricula
                ON inscripcion.id = matricula.inscripcion_id
            INNER JOIN enrollment
                ON enrollment.matricula_id = matricula.id
            INNER JOIN credencial
                ON credencial.expediente_id = expediente.id
                AND credencial.habilitado = '1'
            LEFT JOIN persona_email
                ON persona.id = persona_email.persona_id
                AND persona_email.nacceso = 'publico'
            INNER JOIN titulacion
                ON inscripcion.id = titulacion.inscripcion_id
                AND titulacion.nacceso = 'publico'
            LEFT JOIN especializacion
                ON inscripcion.id = especializacion.inscripcion_id
                AND especializacion.nacceso = 'publico'
            WHERE DATE(inscripcion.fecha_inicio_programa) $BETWEEN
                OR DATE (inscripcion.fecha_modificacion) $BETWEEN
                OR DATE (matricula.fecha_inicio_programa) $BETWEEN
                OR DATE (matricula.fecha_modificacion) $BETWEEN
                OR DATE (especializacion.fecha_creacion) $BETWEEN
                OR DATE (especializacion.fecha_modificacion) $BETWEEN
            GROUP BY inscripcion.persona_id
            -- LIMIT 0, 10;
            "
        ;

        return DB::connection($this->getConnection())->select($query);
    }

    /**
     * Get the Student Data from a Person ID
     *
     * @param int $id
     *
     * @return array
     */
    protected function getInscriptionByStudentId($id)
    {
        $query =
            "SELECT inscripcion.id as id,
                inscription.uuid AS 'inscription_uuid',
                ico.abreviatura_iso_639_1 as 'language',
                inscripcion.fecha_creacion as 'created_at',
                inscripcion.fecha_registro as 'registered_at' ,
                inscripcion.fecha_inicio_programa as 'started_at',
                inscripcion.fecha_fin_programa as 'finished_at',
                inscripcion.fecha_fin_prorroga as 'extension_finished_at',
                e.es_ES as 'status',
                i.es_ES as 'incidence',
                inscripcion.modo as 'modality',
                GROUP_CONCAT(organizacion.sigla) as 'degree_abbreviation',
                academic_entity.uuid as 'program_uuid',
                pi.id as 'program_id',
                pi.abreviatura as 'program_abbreviation',
                r.es_ES as 'program_name',
                vi.version as 'program_version'
                FROM inscripcion
                INNER JOIN persona
                    ON inscripcion.persona_id = persona.id
                INNER JOIN nodo_academico
					ON nodo_academico.class = 'ProgramaVersion'
                    AND nodo_academico.class_id = inscripcion.programa_version_id
				INNER JOIN academic_entity
					ON academic_entity.element = 'ProgramaVersion'
                    AND academic_entity.element_id = nodo_academico.class_id
                INNER JOIN expediente
                    ON expediente.persona_id = persona.id
                INNER JOIN credencial
                    ON credencial.expediente_id = expediente.id
                    AND credencial.habilitado = '1'
                INNER JOIN inscription
                    ON inscription.inscripcion_id = inscripcion.id
                LEFT JOIN entidad_idioma eca
                    ON inscripcion.id = eca.class_id
                    AND eca.class = 'Inscripcion'
                    AND eca.tipo = '_CAMPUS'
                LEFT JOIN idioma ic
                    ON eca.idioma_id = ic.id
                LEFT JOIN entidad_idioma eco
                    ON inscripcion.id = eco.class_id
                    AND eco.class = 'Inscripcion'
                    AND eco.tipo = '_CONTENIDO'
                LEFT JOIN idioma ico
                    ON eco.idioma_id = ico.id
                INNER JOIN programa_version vi
                    ON inscripcion.programa_version_id = vi.id
                INNER JOIN programa pi
                    ON vi.programa_id = pi.id
                INNER JOIN estado
                    ON inscripcion.estado_id = estado.id
                LEFT JOIN incidencia
                    ON inscripcion.incidencia_id = incidencia.id
                INNER JOIN titulacion
                    ON inscripcion.id = titulacion.inscripcion_id
                    AND titulacion.nacceso = 'publico'
                INNER JOIN resolucion
                    ON titulacion.resolucion_id = resolucion.id
                LEFT JOIN i18n_texto r
                    ON resolucion.nombre = r.id
                INNER JOIN i18n_texto e
                    ON estado.nombre = e.id
                LEFT JOIN i18n_texto i
                    ON incidencia.nombre = i.id
                INNER JOIN convenio
                    ON resolucion.convenio_id = convenio.id
                INNER JOIN organizacion
                    ON convenio.organizacion_id = organizacion.id
                WHERE inscripcion.nacceso = 'publico'
                    AND inscripcion.persona_id = :idpersona
                GROUP BY inscripcion.id"
        ;

        return DB::connection($this->getConnection())->select($query, ['idpersona' => $id]);
    }

    /**
     * obtains the degrees by means of the id of the inscription
     *
     * @param $id
     * @return array
     */
    protected function getDegreesByInscriptionId($id)
    {
        $query =
            "SELECT titulacion.id AS 'reference_id',
                organizacion.sigla as 'abbreviation',
                estado_titulacion.es_ES as 'status',
                incidencia_titulacion.es_ES as 'incidence'
                FROM titulacion
                INNER JOIN inscripcion
                    ON titulacion.inscripcion_id = inscripcion.id
                    AND titulacion.nacceso = 'publico'
                INNER JOIN resolucion
                    ON titulacion.resolucion_id = resolucion.id
                INNER JOIN convenio
                    ON resolucion.convenio_id = convenio.id
                INNER JOIN organizacion
                    ON convenio.organizacion_id = organizacion.id
                INNER JOIN estado
                    ON titulacion.estado_id = estado.id
                LEFT JOIN incidencia
                    ON titulacion.incidencia_id = incidencia.id
                INNER JOIN i18n_texto estado_titulacion
                    ON estado.nombre = estado_titulacion.id
                LEFT JOIN i18n_texto incidencia_titulacion
                    ON incidencia.nombre = incidencia_titulacion.id
                WHERE inscripcion.id = :inscripcion_id
                    AND inscripcion.nacceso = 'publico'"
        ;

        return DB::connection($this->getConnection())
        ->select($query, ['inscripcion_id' => $id]);
    }

    /**
     * Get the enrollment data from a Inscription ID
     *
     * @param $id
     *
     * @return array
     */
    protected function getEnrollmentByInscriptionId($id)
    {
        $query =
            "SELECT enrollment.uuid AS 'uuid',
                matricula.id AS 'reference_id',
                matricula.fecha_creacion AS 'started_at',
                matricula.fecha_fin_real AS 'finished_at',
                matricula.fecha_modificacion AS 'updated_at',
                ico.abreviatura_iso_639_1 AS 'language',
                periodo_lectivo.id AS 'announcement_id',
                periodo_lectivo.nombre AS 'announcement_school_period',
                convocatoria.tipo AS 'announcement_study_model',
                periodo_lectivo.fecha_inicio AS 'announcement_started_at',
                periodo_lectivo.fecha_fin AS 'announcement_finished_at'
                FROM inscripcion
                LEFT JOIN entidad_idioma eco
                    ON inscripcion.id = eco.class_id
                    AND eco.class = 'Inscripcion'
                    AND eco.tipo = '_CONTENIDO'
                LEFT JOIN idioma ico
                    ON eco.idioma_id = ico.id
                INNER JOIN persona
                    ON inscripcion.persona_id = persona.id
                INNER JOIN matricula
                    ON matricula.inscripcion_id = inscripcion.id
                    AND matricula.nacceso = 'publico'
                LEFT JOIN enrollment
                    ON enrollment.matricula_id = matricula.id
                INNER JOIN admision
                    ON admision.matricula_id = matricula.id
                    AND admision.nacceso = 'publico'
                INNER JOIN seleccion_academica
                    ON seleccion_academica.admision_id = admision.id
                    AND admision.nacceso = 'publico'
                INNER JOIN periodo_lectivo
                    ON matricula.periodo_lectivo_id = periodo_lectivo.id
                INNER JOIN convocatoria
                    ON convocatoria.periodo_lectivo_id = periodo_lectivo.id
                INNER JOIN titulacion
                    ON inscripcion.id = titulacion.inscripcion_id
                    AND titulacion.nacceso = 'publico'
                INNER JOIN resolucion
                    ON titulacion.resolucion_id = resolucion.id
                INNER JOIN i18n_texto r
                    ON resolucion.nombre = r.id
                INNER JOIN convenio
                    ON resolucion.convenio_id = convenio.id
                INNER JOIN programa_version pv
                    ON inscripcion.programa_version_id = pv.id
                INNER JOIN programa p
                    ON pv.programa_id = p.id
                WHERE inscripcion.id = :inscripcion_id
                    AND inscripcion.nacceso = 'publico'
                GROUP BY matricula.id"
        ;

        return DB::connection($this->getConnection())->select($query, ['inscripcion_id' => $id]);
    }


    /**
     * Get the academic selection data from a Enrollment ID
     *
     * @param $id
     *
     * @return array
     */
    public function getAcademicSelectionByEnrollmentId($id)
    {
        $query =
            "SELECT academic_selection.uuid AS 'uuid',
                seleccion_academica.id AS 'reference_id',
                admision.id as 'admission_id',
                matricula.fecha_inicio_programa AS 'started_at',
                matricula.fecha_fin_real AS 'finished_at'
                FROM seleccion_academica
                INNER JOIN admision
                    ON admision.id = seleccion_academica.admision_id
                    AND admision.nacceso = 'publico'
                INNER JOIN academic_selection
                    ON academic_selection.seleccion_academica_id = seleccion_academica.id
                INNER JOIN matricula
                    ON admision.matricula_id = matricula.id
                    AND matricula.nacceso = 'publico'
                INNER JOIN inscripcion
                    ON matricula.inscripcion_id = inscripcion.id
                    AND inscripcion.nacceso = 'publico'
                INNER JOIN persona
                    ON inscripcion.persona_id = persona.id
                    AND persona.nacceso = 'publico'
                WHERE matricula.id = :enrollment_id
                    AND seleccion_academica.nacceso = 'publico'
            ";

        return DB::connection($this->getConnection())->select($query, ['enrollment_id' => $id]);
    }

    /**
     * Get the academic element data from a academic selection ID
     * @param $id
     * @return array
     */
    public function getAcademicElementBySelectionAcademicId($id)
    {

        $query =
            "SELECT academic_entity.uuid AS 'uuid',
            nodo_academico.id AS 'reference_id',
            nodo_academico.class AS 'reference_class',
            nodo_academico.tipo AS 'reference_type',
            i.es_ES AS 'name',
            nodo_academico.abreviatura  AS 'abbreviation',
            ico.abreviatura_iso_639_1 AS 'language',
            ASIG.version AS 'version'
            FROM seleccion_academica
            INNER JOIN admision
                ON admision.id = seleccion_academica.admision_id
                AND admision.nacceso = 'publico'
            INNER JOIN matricula
                ON admision.matricula_id = matricula.id
                AND matricula.nacceso = 'publico'
            INNER JOIN plaza_academica
                ON seleccion_academica.plaza_academica_id = plaza_academica.id
            INNER JOIN nodo_academico
                ON plaza_academica.class ='NodoAcademico'
                AND plaza_academica.class_id = nodo_academico.id
            INNER JOIN academic_entity
                ON (academic_entity.element = 'ProgramaVersion' OR academic_entity.element = 'AsignaturaVersion' OR academic_entity.element = 'Actividad')
                AND academic_entity.element_id = nodo_academico.class_id
            INNER JOIN asignatura_version AS ASIG
                ON (nodo_academico.class = 'AsignaturaVersion' OR nodo_academico.class = 'ProgramaVersion' OR nodo_academico.class = 'Actividad')
                AND nodo_academico.class_id = ASIG.id
            INNER JOIN asignatura
                ON (asignatura.id = ASIG.asignatura_id)
            INNER JOIN i18n_texto AS i
                ON nodo_academico.nombre = i.id
            INNER JOIN inscripcion
                ON matricula.inscripcion_id = inscripcion.id
                AND inscripcion.nacceso = 'publico'
            LEFT JOIN idioma ico
                ON seleccion_academica.idioma_id = ico.id
            INNER JOIN programa_version
                ON(inscripcion.programa_version_id=programa_version.id)
            INNER JOIN programa AS PRO
                ON( programa_version.programa_id =PRO.id)
            INNER JOIN persona
                ON inscripcion.persona_id = persona.id
                AND persona.nacceso = 'publico'
            WHERE seleccion_academica.id = :academic_selection_id
                AND (seleccion_academica.nacceso = 'publico' OR seleccion_academica.nacceso = 'privado')
            GROUP BY seleccion_academica.id
        ";

        return DB::connection($this->getConnection())->select($query, ['academic_selection_id' => $id]);

    }


    /**
     * Get the Student Data from a Person ID
     *
     * @param int $id
     *
     * @return array
     */
    protected function getStudentRecordById($id)
    {
        $query =
            "SELECT persona.id AS id,
                student.uuid AS student_uuid,
                persona.dni AS dni,
                persona.nombre AS first_name,
                persona.apellido AS last_name,
                credencial.username AS user_name,
                credencial.password AS password,
                persona_email.email AS email,
                pais.iso3166_code2 AS country,
                poblacion.nombre AS city,
                telefono.numero AS phone,
                direccion.direccion AS address,
                ic.abreviatura_iso_639_1 AS language
                FROM persona
                INNER JOIN inscripcion
                    ON inscripcion.persona_id = persona.id
                INNER JOIN expediente
                    ON expediente.persona_id = persona.id
                INNER JOIN student
                    ON student.persona_id = persona.id
                INNER JOIN inscription
                    ON inscription.inscripcion_id = inscripcion.id
                INNER JOIN matricula
                    ON matricula.inscripcion_id = inscripcion.id
                INNER JOIN enrollment
                    ON enrollment.matricula_id = matricula.id
                INNER JOIN credencial
                    ON credencial.expediente_id = expediente.id
                    AND credencial.habilitado = '1'
                INNER JOIN direccion
                    ON direccion.class_id = persona.id
                INNER JOIN telefono
                    ON direccion.id = telefono.direccion_id
                LEFT JOIN entidad_idioma eca
                    ON inscripcion.id = eca.class_id
                    AND eca.class = 'Inscripcion'
                    AND eca.tipo = '_CAMPUS'
                LEFT JOIN idioma ic
                    ON eca.idioma_id = ic.id
                LEFT JOIN persona_email
                    ON persona.id = persona_email.persona_id
                    AND persona_email.nacceso = 'publico'
                LEFT JOIN pais
                    ON persona.pais_id = pais.id
                LEFT JOIN poblacion
                    ON persona.poblacion_id = poblacion.id
                WHERE inscripcion.nacceso = 'publico'
                    AND inscripcion.persona_id = :idpersona
                GROUP BY persona.id, persona_email.email";

        return DB::connection($this->getConnection())->select($query, ['idpersona' => $id]);
    }

}
