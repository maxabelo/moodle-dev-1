<?php

namespace Domain\Inscription\Entities;

use Domain\Inscription\ValueObjects\DegreeActive;

class DegreeTest extends \TestCase
{

    public  $newDegree = [
        'reference_id' => 1471435,
        'abbreviation' => 'Default',
        'status' => 'Default',
        'incidence' => null,
        'active'=> null,
    ];

    public function testNewDegreeDefault()
    {
        $otherOption = $this->newDegree['abbreviation'] = 'USAC';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals($otherOption, $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUnib()
    {
        $this->newDegree['abbreviation'] = 'UNIB';
        $this->newDegree['status'] = 'No tramitar';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UNIB', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUneatlantico()
    {
        $this->newDegree['abbreviation'] = 'UNEATLANTICO';
        $this->newDegree['status'] = 'Desistida';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UEA', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUnic()
    {
        $this->newDegree['abbreviation'] = 'UNIC';
        $this->newDegree['status'] = 'Antigua';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UNIC', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUnincol()
    {
        $this->newDegree['abbreviation'] = 'UNINCOL';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UNINCOL', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUniromana()
    {
        $this->newDegree['abbreviation'] = 'UNIROMANA';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UNIROMANA', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function testNewDegreeUniniMx()
    {
        $this->newDegree['abbreviation'] = 'UNINI-MX';

        $degree = Degree::make($this->newDegree['reference_id'], $this->newDegree);
        $degreeActive = (new DegreeActive($this->newDegree['status']))->setActiveStatus();

        $this->validateStatus($this->newDegree['status'], $degreeActive);
        $this->assertEquals('UNINIMX', $degree->getAbbreviation(), 'NEW DEGREE');
    }

    public function validateStatus($status, $degreeActive)
    {

        if($status == 'No tramitar' || $status == 'Desistida' || $status == 'Antigua')
        {
            $this->assertEquals(0, $degreeActive, 'NEW DEGREE');
        }
        else
        {
            $this->assertEquals(1, $degreeActive, 'NEW DEGREE');
        }
    }
}
