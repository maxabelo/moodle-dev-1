<?php

namespace Domain\Inscription\ValueObjects;

class InscriptionActiveTest extends \TestCase
{

    public function testInscriptionActiveDefault()
    {
        $inscriptionActiveStatus = ['Activo', 'Prorroga', 'Tesista', 'Finalizado', 'Pendiente'];
        $inscriptionActive = new InscriptionActive('Activo');
        $result = $inscriptionActive->setActiveStatus();

        $this->assertEquals(1, $result, 'INSCRIPTION ACTIVE');
    }

    public function testInscriptionInactiveBaja()
    {
        $inscriptionInactive = new InscriptionActive('Baja');
        $result = $inscriptionInactive->setActiveStatus();

        $this->assertEquals(0, $result, 'INSCRIPTION INACTIVE');
    }

}
