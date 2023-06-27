<?php

namespace Domain\Inscription\ValueObjects;

class DegreeBrandsAbbreviation
{

    /**
     * @param $abbreviationDegree
     */
    public function __construct($abbreviationDegree)
    {
        $this->nameDegree = $abbreviationDegree;
    }

    /**
     * @return string
     */
    public function setAbbreviationBrand()
    {
       return $this->getAbbreviationBrand();
    }

    /**
     * @return string
     */
    public function getAbbreviationBrand()
    {
        switch ($this->nameDegree)
        {
            CASE 'UNIB':
                return config('globalConnection.unib.abbreviation');
            CASE 'UNEATLANTICO':
                return config('globalConnection.guiaa.abbreviation');
            CASE 'UNINI-MX':
                return config('globalConnection.uninimx.abbreviation');
            CASE 'UNINCOL':
                return config('globalConnection.unincol.abbreviation');
            CASE 'UNIC':
                return config('globalConnection.unic.abbreviation');
            CASE 'UNIROMANA':
                return config('globalConnection.uniromana.abbreviation');
            default:
                return $this->nameDegree;
        }
    }

}
