<?php

namespace Domain\Inscription\ValueObjects;

class DegreeBrandsAbbreviationTest extends \TestCase
{

    public function testGetAbbreviationUnib()
    {
        $degree = new DegreeBrandsAbbreviation('UNIB');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.unib.abbreviation'), $result);
    }

    public function testGetAbbreviationUneatlantico()
    {
        $degree = new DegreeBrandsAbbreviation('UNEATLANTICO');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.guiaa.abbreviation'), $result);
    }


    public function testGetAbbreviationUniniMx()
    {
        $degree = new DegreeBrandsAbbreviation('UNINI-MX');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.uninimx.abbreviation'), $result);
    }


    public function testGetAbbreviationUnic()
    {
        $degree = new DegreeBrandsAbbreviation('UNIC');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.unic.abbreviation'), $result);
    }


    public function testGetAbbreviationUnincol()
    {
        $degree = new DegreeBrandsAbbreviation('UNINCOL');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.unincol.abbreviation'), $result);
    }


    public function testGetAbbreviationUniromana()
    {
        $degree = new DegreeBrandsAbbreviation('UNIROMANA');
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals(config('globalConnection.uniromana.abbreviation'), $result);
    }

    public function testGetAbbreviationDefault()
    {
        $variableTest = 'USAC';
        $degree = new DegreeBrandsAbbreviation($variableTest);
        $result = $degree->setAbbreviationBrand();

        $this->assertEquals($variableTest, $result, 'DEGREE DEFAULT ABBR');
    }
}
