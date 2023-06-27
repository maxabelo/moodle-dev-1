<?php

namespace Domain\Inscription\ValueObjects;

class InscriptionModalityTest extends \TestCase
{

    public function testGetModalityVirtual()
    {
        $modality = new InscriptionModality('_VIRTUAL');
        $result = $modality->setInscriptionModality();

        $this->assertEquals('VIRTUAL', $result, 'VIRTUAL MODALITY');
    }

    public function testGetModalityPresencial()
    {
        $modality = new InscriptionModality('_TRADICIONAL');
        $result = $modality->setInscriptionModality();

        $this->assertEquals('PRESENCIAL', $result, 'PRESENCIAL MODALITY');
    }

    public function testGetModalityDefault()
    {
        $defaultModality = 'Default';
        $modality = new InscriptionModality($defaultModality);
        $result = $modality->setInscriptionModality();

        $this->assertEquals($defaultModality, $result, 'DEFAULT MODALITY');
    }
}
