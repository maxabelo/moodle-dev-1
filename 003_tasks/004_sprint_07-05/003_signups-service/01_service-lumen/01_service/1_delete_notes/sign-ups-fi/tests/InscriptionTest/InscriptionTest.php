<?php

namespace InscriptionTest;

use Domain\Inscription\Contract\InscriptionRepository;
use Domain\Inscription\Inscription;
use Domain\Inscription\InscriptionId;

class InscriptionTest
{

    /** @var InscriptionRepository  */
    protected $inscriptionRepository;
    public function __construct(InscriptionRepository $inscriptionRepository)
    {
        $this->inscriptionRepository = $inscriptionRepository;
    }

    /**
     * @return InscriptionId
     */
    public function createInscription ($id = null)
    {
        $inscriptionId = new InscriptionId('5cc55292-d1ff-54c7-a32b-e7b82b90e77e');

        $data = array (
            'uuid' => $inscriptionId,
            'reference_id' => 3085,
            'started_at' => '2023-01-10',
            'finished_at' => '2028-01-10',
            'extension_finished_at' => '2028-01-10',
            'status' => 'Activo',
            'incidence' => 'Al Día',
            'academic_program' =>
                array (
                    'reference_id' => 13,
                    'abbreviation' => 'DEGDE',
                    'language' => NULL,
                    'name' => NULL,
                    'version' => '2021-PPS-TFC',
                ),
            'institution_abbreviation' => 'UNIC',
            'degrees' =>
                array (
                    0 =>
                        array (
                            'reference_id' => 3085,
                            'abbreviation' => 'UNIC',
                            'status' => 'Creado',
                            'incidence' => 'null',
                            'active' => 1,
                        ),
                ),
            'modality' => '_VIRTUAL',
            'enrollments' =>
                array (
                    0 =>
                        array (
                            'reference_id' => 4492,
                            'started_at' => '2023-01-10 14:51:52',
                            'academic_program' =>
                                array (
                                    'reference_id' => 13,
                                    'abbreviation' => 'DEGDE',
                                    'language' => NULL,
                                    'name' => NULL,
                                    'version' => '2021-PPS-TFC',
                                ),
                            'announcement' =>
                                array (
                                    'reference_id' => 9,
                                    'school_period' => '2022-2023',
                                    'study_model' => '_SEMESTRE',
                                    'started_at' => '2022-06-17',
                                    'finished_at' => '2023-06-30',
                                ),
                            'academic_selections' =>
                                array (
                                    0 =>
                                        array (
                                            'reference_id' => 57538,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 263,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'ID072',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    1 =>
                                        array (
                                            'reference_id' => 57539,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 266,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'CSJ004',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    2 =>
                                        array (
                                            'reference_id' => 57540,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 267,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'LG014',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    3 =>
                                        array (
                                            'reference_id' => 57541,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 265,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => 'Informática Básica',
                                                            'abbreviation' => 'MM075',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    4 =>
                                        array (
                                            'reference_id' => 57542,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 262,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'ID071',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    5 =>
                                        array (
                                            'reference_id' => 57543,
                                            'admision_id' => 10674,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 811,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'PS097',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    6 =>
                                        array (
                                            'reference_id' => 57544,
                                            'admision_id' => 10675,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 271,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'ID074',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    7 =>
                                        array (
                                            'reference_id' => 57545,
                                            'admision_id' => 10675,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 268,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'MD002',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    8 =>
                                        array (
                                            'reference_id' => 57546,
                                            'admision_id' => 10675,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 269,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'DD152',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    9 =>
                                        array (
                                            'reference_id' => 57547,
                                            'admision_id' => 10675,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 270,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'DE074',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                    10 =>
                                        array (
                                            'reference_id' => 57548,
                                            'admision_id' => 10675,
                                            'started_at' => '2023-01-10T00:00:00.000000Z',
                                            'academic_element' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'reference_id' => 264,
                                                            'type' => '_OBLIGATORIO',
                                                            'name' => NULL,
                                                            'abbreviation' => 'ID073',
                                                            'language' => 'es',
                                                            'version' => '2021-PPS-TFC',
                                                        ),
                                                ),
                                        ),
                                ),
                        ),
                ),
        );

        $inscription = Inscription::create($inscriptionId , $data);
        $this->inscriptionRepository->save($inscription);

        return $inscriptionId;
    }
}
