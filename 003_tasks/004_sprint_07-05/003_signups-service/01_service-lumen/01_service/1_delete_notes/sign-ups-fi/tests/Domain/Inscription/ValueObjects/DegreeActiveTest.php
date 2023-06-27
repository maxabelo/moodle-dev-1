<?php

namespace Domain\Inscription\ValueObjects;

class DegreeActiveTest extends \TestCase
{

    public function testDegreeActiveDefault()
    {
        $degreeActiveStatus = ['Creada', 'Pendiente de cobro de tasas', 'Pendiente de tramite', 'En tramite', 'Recibido', 'Legalizar', 'Pendiente de envio', 'Enviado'];
        $degreeActive = new DegreeActive('Creada');
        $result = $degreeActive->setActiveStatus();

        $this->assertEquals(1, $result, 'DEGREE ACTIVE');
    }

    public function testDegreeInactiveNoTramitar()
    {
        $degreeInactive = new DegreeActive('No tramitar');
        $result = $degreeInactive->setActiveStatus();

        $this->assertEquals(0, $result, 'DEGREE INACTIVE');
    }

    public function testDegreeInactiveDesistida()
    {
        $degreeInactive = new DegreeActive('Desistida');
        $result = $degreeInactive->setActiveStatus();

        $this->assertEquals(0, $result, 'DEGREE INACTIVE');
    }

    public function testDegreeInactiveAntigua()
    {
        $degreeInactive = new DegreeActive('Antigua');
        $result = $degreeInactive->setActiveStatus();

        $this->assertEquals(0, $result, 'DEGREE INACTIVE');
    }
}
