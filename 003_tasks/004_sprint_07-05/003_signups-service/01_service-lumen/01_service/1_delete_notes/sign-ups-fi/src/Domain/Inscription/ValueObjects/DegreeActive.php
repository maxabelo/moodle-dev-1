<?php

namespace Domain\Inscription\ValueObjects;

final class DegreeActive
{

    /** @var string[]  */
    public $inactiveStatus = ['NTD','DST','ANT'];

    /** @var  */
    public $status;

    /**
     * @param $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function setActiveStatus()
    {
       if (in_array($this->getInactiveStatus(), $this->inactiveStatus))
       {
           return 0;
       }

       return 1;
    }

    /**
     * @return string
     */
    public function getInactiveStatus()
    {
        switch ($this->status)
        {
            CASE 'No tramitar':
                return 'NTD';
            CASE 'Desistida':
                return 'DST';
            CASE 'Antigua':
                return 'ANT';
            default:
                return 'ACTIVE';
        }
    }

}
