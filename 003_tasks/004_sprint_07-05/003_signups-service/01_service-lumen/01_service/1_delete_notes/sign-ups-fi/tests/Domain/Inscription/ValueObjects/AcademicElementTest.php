<?php

namespace Domain\Inscription\ValueObjects;

class AcademicElementTest extends \TestCase
{

    public $typeProgram = 'Program';
    public $typeSubject = 'Subject';
    public $typeActivity = 'Activity';

    public  $newAcademicElement = [
        'reference_id' => 987456,
        'reference_class' => 'Default',
        'reference_type' => '_OBLIGATORIO',
        'name' => 'Curso de Testing',
        'abbreviation'=> 'CDTFBR',
        'language'=> 'es',
        'version'=> '2023-TFBR',
    ];


    public function testNewAcademicElementProgram()
    {
        $this->newAcademicElement['reference_class'] = 'ProgramaVersion';
        $academicElement = AcademicElement::make($this->newAcademicElement);

        $this->assertEquals($this->typeProgram, $academicElement->type, 'NEW ACADEMIC ELEMENT');
    }

    public function testNewAcademicElementSubject()
    {
        $this->newAcademicElement['reference_class'] = 'AsignaturaVersion';
        $academicElement = AcademicElement::make($this->newAcademicElement);

        $this->assertEquals($this->typeSubject, $academicElement->type, 'NEW ACADEMIC ELEMENT');
    }

    public function testNewAcademicElementActivity()
    {
        $this->newAcademicElement['reference_class'] = 'Actividad';
        $academicElement = AcademicElement::make($this->newAcademicElement);

        $this->assertEquals($this->typeActivity, $academicElement->type, 'NEW ACADEMIC ELEMENT');
    }

    public function testNewAcademicElementDefault()
    {
        $otherOption = $this->newAcademicElement['reference_class'];
        $academicElement = AcademicElement::make($this->newAcademicElement);

        $this->assertEquals($otherOption, $academicElement->type, 'NEW ACADEMIC ELEMENT');
    }
}
