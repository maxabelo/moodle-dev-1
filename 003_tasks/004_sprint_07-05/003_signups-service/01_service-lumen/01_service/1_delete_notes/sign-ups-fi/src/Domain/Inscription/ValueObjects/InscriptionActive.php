<?php

namespace Domain\Inscription\ValueObjects;

final class InscriptionActive
{

    /** @var string[]  */
    public $inactiveStatus = ['BA'];

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
            CASE 'Baja':
                return 'BA';
            default:
                return 'ACTIVE';
        }
    }
}
