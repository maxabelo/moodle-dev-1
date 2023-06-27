<?php

namespace App\Console\Importers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CoreAppStudentsImporterSirius extends CoreAppStudentsImporter
{
    /**
     * @param $id
     * @return object|null
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
                $enrollment->academic_term['study_model'] = 'Abierto';
                $enrollment->academic_term['started_at'] = Carbon::parse($inscription->started_at)->year < 1 ? null : Carbon::parse($inscription->started_at) ;
                $enrollment->academic_term['finished_at'] = Carbon::parse($inscription->finished_at)->year < 1 ? null : Carbon::parse($inscription->finished_at);

                try
                {
                    $enrollment->academic_selections = $this->getAcademicSelectionByEnrollmentIdSirius($enrollment->reference_id);

                    if (empty($enrollment->academic_selections))
                    {
                        $enrollment->academic_selections = $this->getAcademicSelectionByEnrollmentId($enrollment->reference_id);
                    }

                }catch (\Exception)
                {
                    $enrollment->academic_selections = $this->getAcademicSelectionByEnrollmentId($enrollment->reference_id);
                }

                foreach ($enrollment->academic_selections as $academic_selection)
                {
                    $academic_selection->academic_element = $this->getAcademicElementBySelectionAcademicId($academic_selection->reference_id);

                        if(empty($academic_selection->academic_element))
                        {
                            $academic_selection->academic_element = $this->getAcademicElementMedidaBySelectionAcademicId($academic_selection->reference_id);
                        }

                        if(empty($academic_selection->academic_element))
                        {
                            $academic_selection->academic_element = $this->getTesisByAcademecicSelectionId($academic_selection->reference_id);
                        }

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
     * get the legacy academic selections through the enrollment id
     *
     * @param $id
     *
     * @return array
     */
    public function getAcademicSelectionByEnrollmentIdSirius($id)
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
                INNER JOIN matricula
                    ON admision.matricula_id = matricula.id
                    AND matricula.nacceso = 'publico'
                INNER JOIN academic_selection
                    ON academic_selection.seleccion_academica_id = seleccion_academica.id
                INNER JOIN inscripcion
                    ON matricula.inscripcion_id = inscripcion.id
                    AND inscripcion.nacceso = 'publico'
                INNER JOIN persona
                    ON inscripcion.persona_id = persona.id
                    AND persona.nacceso = 'publico'
                WHERE matricula.id = :enrollment_id
                    AND (seleccion_academica.nacceso = 'publico' OR seleccion_academica.nacceso = 'privado')
                    AND seleccion_academica.seleccion_legacy = 0
            ";

        return DB::connection($this->getConnection())->select($query, ['enrollment_id' => $id]);
    }

    /**
     * obtains the academic legacy elements through the academic selection id
     *
     * @param $id
     *
     * @return array
     */
    public function getAcademicElementMedidaBySelectionAcademicId($id)
    {
        $query =
            "SELECT academic_entity.uuid AS 'uuid',
            nodo_medida.id AS 'reference_id',
            nodo_medida.class AS 'reference_class',
            nodo_medida.tipo AS 'reference_type',
            i.es_ES AS 'name',
            nodo_medida.abreviatura  AS 'abbreviation',
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
            INNER JOIN nodo_medida
                ON plaza_academica.class ='NodoMedida'
                AND plaza_academica.class_id = nodo_medida.id
            INNER JOIN academic_entity
                ON (academic_entity.element = 'ProgramaVersion' OR academic_entity.element = 'AsignaturaVersion' OR academic_entity.element = 'Actividad')
                AND academic_entity.element_id = nodo_medida.class_id
            INNER JOIN asignatura_version AS ASIG
                ON (nodo_medida.class = 'AsignaturaVersion' OR nodo_medida.class = 'ProgramaVersion' OR nodo_medida.class = 'Actividad')
                AND nodo_medida.class_id = ASIG.id
            INNER JOIN asignatura
                ON (asignatura.id = ASIG.asignatura_id)
            INNER JOIN i18n_texto AS i
                ON nodo_medida.nombre = i.id
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
                AND (seleccion_academica.nacceso = 'publico' OR seleccion_academica.nacceso = 'privado')";

        return DB::connection($this->getConnection())->select($query, ['academic_selection_id' => $id]);
    }

    /**
     * Support for importing the academic element of TFC
     *
     * @param $id
     *
     * @return array
     */
    public function getTesisByAcademecicSelectionId($id)
    {
        $query =
            "SELECT academic_entity.uuid AS 'uuid',
            nodo_academico.id AS 'reference_id',
            nodo_academico.class AS 'reference_class',
            nodo_academico.tipo AS 'reference_type',
            i.es_ES AS 'name',
            nodo_academico.abreviatura  AS 'abbreviation',
            ico.abreviatura_iso_639_1 AS 'language',
            programa_version.version AS 'version'
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
            INNER JOIN actividad
                ON nodo_academico.class = 'Actividad'
                AND nodo_academico.class_id = actividad.id
            LEFT JOIN academic_entity
                ON academic_entity.element = 'Actividad'
                AND academic_entity.element_id = nodo_academico.class_id
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
        ";

        return DB::connection($this->getConnection())->select($query, ['academic_selection_id' => $id]);
    }
}
