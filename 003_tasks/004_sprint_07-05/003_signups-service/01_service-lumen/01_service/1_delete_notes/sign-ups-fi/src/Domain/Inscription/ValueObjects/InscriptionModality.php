<?php

namespace Domain\Inscription\ValueObjects;

final class InscriptionModality
{

    /**
     * @param $modality
     */
    public function __construct($modality)
    {
        $this->modality = $modality;
    }

    /**
     * @return string
     */
    public function setInscriptionModality()
    {
        return $this->getInscriptionModality();
    }

    /**
     * @return string
     */
    public function getInscriptionModality()
    {
        switch($this->modality)
        {
            CASE '_VIRTUAL':
                return 'VIRTUAL';
            CASE '_TRADICIONAL':
                return 'PRESENCIAL';
            default:
                return $this->modality;
        }
    }
}
